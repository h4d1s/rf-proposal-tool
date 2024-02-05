<?php

namespace App\Http\Controllers\Web;

use App\Enums\ChartPeriodicity;
use App\Enums\ProposalState as ProposalStateEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardRequest;
use App\Models\Activity;
use App\Models\Proposal;
use App\Models\ProposalState;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(DashboardRequest $request)
    {
        if (!$request->filled(['date_from', 'date_to', 'periodicity'])) {
            return redirect()->route('dashboard', [
                'date_from' => Carbon::now()->firstOfYear()->format('Y-n'),
                'date_to' => Carbon::now()->format('Y-n'),
                'periodicity' => ChartPeriodicity::Monthly->value,
            ]);
        }

        $team_id = $request->user()->team->id;

        $periodicity = $request->query('periodicity', ChartPeriodicity::Monthly->value);
        $date_from = $request->query('date_from', '');
        $date_to = $request->query('date_to', '');

        $date_format = ($periodicity === ChartPeriodicity::Weekly->value ? 'W-Y' : 'Y-n');
        $carbon_date_from = '';
        $carbon_date_to = '';

        if ($periodicity === ChartPeriodicity::Weekly->value) {
            [$year_from, $week_from] = explode('-', $date_from);
            [$year_to, $week_to] = explode('-', $date_to);
            $carbon_date_from = Carbon::now()->setISODate($year_from, $week_from)->startOfWeek();
            $carbon_date_to = Carbon::now()->setISODate($year_to, $week_to)->endOfWeek();
        } else {
            $carbon_date_from = Carbon::createFromFormat($date_format, $date_from)->firstOfMonth();
            $carbon_date_to = Carbon::createFromFormat($date_format, $date_to)->lastOfMonth();
        }

        // Bar chart

        $proposal_states = ProposalState::all();

        $period_format = ($periodicity === ChartPeriodicity::Weekly->value ? '1 week' : '1 month');
        $period = CarbonPeriod::create($carbon_date_from, $period_format, $carbon_date_to);
        $bar_chart_labels = [];
        foreach ($period as $date) {
            $bar_chart_labels[] = $date->format($date_format);
        }

        $format_year_month = '%Y/%m';
        $format_week = '%x/%v';
        $bar_chart_format = $periodicity === ChartPeriodicity::Weekly->value ? $format_week : $format_year_month;
        $bar_chart_interval = $periodicity === ChartPeriodicity::Weekly->value ? 'WEEK' : 'MONTH';

        $chart = [];
        if ($carbon_date_from->diffInMonths($carbon_date_to) >= 0) {
            foreach ($proposal_states as $state) {
                $rawSql = <<<SQL
                        WITH RECURSIVE dates AS (
                            SELECT DATE('$carbon_date_from') date
                            UNION ALL
                            SELECT dates.date + INTERVAL 1 $bar_chart_interval
                            FROM dates
                            WHERE DATE_FORMAT(dates.date, '$bar_chart_format') < DATE_FORMAT('$carbon_date_to', '$bar_chart_format')
                        )
                        SELECT
                            count(*) - 1 AS data
                        FROM (
                            (SELECT
                                DATE_FORMAT(proposals.created_at, '$bar_chart_format') as chart_label
                            FROM proposals
                            WHERE proposals.project_id IN (
                                SELECT projects.id
                                FROM projects
                                WHERE (projects.projectable_id IN (
                                    SELECT clients.id
                                    FROM clients
                                    WHERE clients.team_id = $team_id
                                ) AND projects.projectable_type = "App\\\Models\\\Client")
                                OR (projects.projectable_id IN (
                                    SELECT companies.id
                                    FROM companies
                                    WHERE companies.team_id = $team_id
                                ) AND projects.projectable_type = "App\\\Models\\\Company")
                            )
                            AND proposals.proposal_state_id = $state->id 
                            AND
                                (DATE_FORMAT(proposals.created_at, '$bar_chart_format')
                                    BETWEEN DATE_FORMAT('$carbon_date_from', '$bar_chart_format')
                                        AND DATE_FORMAT('$carbon_date_to', '$bar_chart_format'))
                            )
                            UNION ALL
                            (SELECT
                                DATE_FORMAT(dates.date, '$bar_chart_format') as chart_label
                            FROM dates)
                        ) AS t
                        GROUP BY chart_label
                        ORDER BY chart_label;
                    SQL;
                $expression = DB::raw($rawSql);
                $string = $expression->getValue(DB::connection()->getQueryGrammar());
                $chart[$state->name] = collect(DB::select($string))->pluck('data');
            }
        }

        // Counts

        $proposals_chart = [];
        foreach ($proposal_states as $state) {
            $proposals_chart['data'][] = Proposal::query()
                ->forTeam($team_id)
                ->with('state')
                ->whereHas('state', function ($query) use ($state) {
                    $query->where('id', $state->id);
                })
                ->whereBetween('created_at', [$carbon_date_from, $carbon_date_to])
                ->count();
            $proposals_chart['labels'][] = ucfirst($state->name);
        }

        // Quick stats

        function quick_stats($team_id, $start, $end)
        {
            $proposal_states = ProposalState::all();

            $all_count = Proposal::query()
                ->forTeam($team_id)
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $counts = [];
            foreach ($proposal_states as $state) {
                $counts[$state->name] = Proposal::query()
                    ->forTeam($team_id)
                    ->with('state')
                    ->whereHas('state', function ($query) use ($state) {
                        $query->where('id', $state->id);
                    })
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
            }

            $approved = ($all_count === 0 ? 0 : $counts['approved'] / $all_count) * 100;
            $rejected = ($all_count === 0 ? 0 : $counts['rejected'] / $all_count) * 100;
            $other = ($all_count === 0 ? 0 : (($counts['draft'] + $counts['viewed'] + $counts['sent']) / $all_count)) * 100;

            return [
                'approved' => $approved,
                'rejected' => $rejected,
                'other' => $other,
            ];
        }

        $this_month_start = Carbon::now()->startOfMonth();
        $this_month_end = Carbon::now();
        $this_month = quick_stats($team_id, $this_month_start, $this_month_end);

        $last_month_start = Carbon::now()->subMonth()->startOfMonth();
        $last_month_end = Carbon::now()->subMonth()->endOfMonth();
        $last_month = quick_stats($team_id, $last_month_start, $last_month_end);

        $this_year_start = Carbon::now()->startOfYear();
        $this_year_end = Carbon::now();
        $this_year = quick_stats($team_id, $this_year_start, $this_year_end);

        $proposals = [];
        foreach ($proposal_states as $state) {
            if (
                $state->name === ProposalStateEnum::Draft->value ||
                $state->name === ProposalStateEnum::Viewed->value
            ) {
                continue;
            }

            $proposals[$state->name] = Proposal::query()
                ->forTeam($team_id)
                ->with('state')
                ->whereHas('state', function ($query) use ($state) {
                    $query->where('id', $state->id);
                })
                ->latest()
                ->limit(4)
                ->get();
        }

        // Activity

        $activities = Activity::query()
            ->forTeam($team_id)
            ->take(4)
            ->get();

        return view('dashboard.index', [
            'bar_chart' => [
                'data' => $chart,
                'labels' => $bar_chart_labels,
            ],
            'proposals_chart' => $proposals_chart,
            'quick_stats' => [
                'this_month' => $this_month,
                'last_month' => $last_month,
                'this_year' => $this_year,
            ],
            'proposals' => $proposals,
            'activities' => $activities,
        ]);
    }
}
