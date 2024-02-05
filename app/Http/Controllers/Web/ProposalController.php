<?php

namespace App\Http\Controllers\Web;

use App\Enums\ActivityType as EnumsActivityType;
use App\Enums\ProposalState as EnumsProposalState;
use App\Exports\ProposalsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proposal\StoreProposalRequest;
use App\Http\Requests\Proposal\UpdateProposalRequest;
use App\Mail\ProposalComment;
use App\Mail\ProposalSent;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Discussion;
use App\Models\Note;
use App\Models\PricingTable;
use App\Models\PricingTableItem;
use App\Models\Proposal;
use App\Models\ProposalState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Proposal::class);

        $team_id = $request->user()->team->id;
        $query = Proposal::query();
        $query->with(['state', 'products']);
        $query->forTeam($team_id);

        if (
            $request->filled('proposal') &&
            $request->filled('action') &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('proposal');
            Proposal::whereIn('id', $ids)->each(function($proposal) {
                $proposal->delete();
            });
            $request->request->remove('proposal');

            $proposals = $query
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('proposals', $proposals)
                ->with('status', __('Proposals deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['date_from', 'date_to'])) {
            $date_from = $request->query('date_from', '');
            $date_to = $request->query('date_to', '');
            $start_date = Carbon::createFromFormat('Y-m-d', $date_from)->startOfDay();
            $end_date = Carbon::createFromFormat('Y-m-d', $date_to)->endOfDay();

            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order', '');
            $orderby = $request->query('orderby', '');

            $query->orderBy($orderby, $order);
        }

        if($request->filled('state')) {
            $state = $request->query('state');
            $query->whereHas('state', function ($query) use ($state) {
                $query->whereIn('name', $state);
            });
        }

        if ($request->filled('project')) {
            $project_id = $request->query('project');
            $query->with('project');
            $query->whereHas('project', function ($query) use ($project_id) {
                $query->where('id', $project_id);
            });
        }

        $proposals = $query
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Proposal::class);

        $tab = request()->tab;
        return view('proposals.create', compact('tab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalRequest $request)
    {
        $this->authorize('create', Proposal::class);

        $user = $request->user();
        $validated = $request->safe();
        $proposal_data = $request->safe()->except('project');
        $proposal = Proposal::make($proposal_data);

        // Project

        if($request->filled('project')) {
            $proposal->project()->associate($validated['project']);
        }

        // Products

        if($request->filled('products')) {
            $proposal->products()->attach($validated['products']);
        }
    
        // User

        $proposal->user()->associate($request->user());

        $proposal->save();

        // Add Activity

        $activity_type = ActivityType::where('name', EnumsActivityType::Created->value)->first();
        $activity = Activity::make();
        $activity->team()->associate($user->team);
        $activity->subject()->associate($proposal);
        $activity->causer()->associate($user);
        $activity->activity_type()->associate($activity_type);
        $activity->save();

        return redirect()
            ->route('proposals.index')
            ->with('status', __('Proposal created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Proposal $proposal)
    {
        $customer = null;
        $is_paid = false;
        $is_expired = false;

        // Check if token is present from email

        if(!$request->filled('t')) {
            $this->authorize('view', $proposal);
            $customer = $proposal->project->projectable;

            $payment = $customer->payments()
                ->where("proposal_id", $proposal->id)
                ->first();

            if($payment) {
                $is_paid = $payment->pivot->is_paid;
            }
        } else {
            $token = $request->query('t');

            // Check if expired
    
            $expiration_date_carbon = Carbon::parse($proposal->expiration_date);
            $now_carbon = Carbon::now();
            if($expiration_date_carbon->lt($now_carbon)) {
                $is_expired = true;
            }
            
            $queryClient = $proposal->clients()->where('token', $token)->with("payments");
            $queryCompany = $proposal->companies()->where('token', $token)->with("payments");

            if(!$queryClient->exists() && !$queryCompany->exists()) {
                return abort(404);
            }

            if($queryClient->exists()) {
                $customer = $queryClient->first();
            } else {
                $customer = $queryCompany->first();
            }

            // Change state to 'viewed'

            if(
                $proposal->state->name === EnumsProposalState::Draft->value ||
                $proposal->state->name === EnumsProposalState::Sent->value
            ) {
                $state_viewed = ProposalState::where('name', EnumsProposalState::Viewed->value)->first();
                $proposal->state()->associate($state_viewed)->save();

                // Add Activity

                $activity_type = ActivityType::where('name', EnumsActivityType::Viewed->value)->first();
                $activity = Activity::make();
                $activity->team()->associate($customer->team);
                $activity->subject()->associate($proposal);
                $activity->causer()->associate($customer);
                $activity->activity_type()->associate($activity_type);
                $activity->save();
            }
            
            $payment = $customer->payments()
                    ->where("proposal_id", $proposal->id)
                    ->first();

            if($payment) {
                $is_paid = $payment->pivot->is_paid;
            }
        }

        return view('proposals.show', compact('proposal', 'customer', 'is_paid', 'is_expired'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        $this->authorize('update', $proposal);

        $proposal = Proposal::find($proposal->id);
        $tab = request()->tab;

        return view('proposals.edit', compact('proposal', 'tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateProposalRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        $this->authorize('update', $proposal);

        $user = $request->user();
        $validated = $request->safe();
        $proposal_data = $validated->except(
            'products',
            'pricing_table',
            'note',
            'discussion',
            'state'
        );
        $proposal->update($proposal_data);

        // Products

        if($request->filled('products')) {
            $proposal->products()->sync($validated['products']);
            $proposal->save();
        }

        // Pricing table

        if($request->filled('pricing_table')) {
            if(!$proposal->pricingTable()->exists()) {
                $pricing_table = PricingTable::create([
                    'name' => 'Pricing Table'
                ]);
                $proposal->pricingTable()->associate($pricing_table)->save();
            }

            $table_items = [];
            foreach($validated['pricing_table'] as $item) {
                $query = PricingTableItem::where('id', $item['id']);
                if(!$query->exists()) {
                    $table_items[] = PricingTableItem::make($item);
                } else {
                    $query->update($item);
                }
            }
            $proposal->pricingTable->items()->saveMany($table_items);
        }

        // Note

        if($request->filled('note')) {
            $new_note = Note::make([
                'body' => $validated['note']
            ]);
            $new_note->proposal()->associate($proposal);
            $new_note->user()->associate($user);
            $new_note->save();
        }

        // Discussion

        if($request->filled('discussion')) {
            $new_discussion = Discussion::make([
                'body' => $validated['discussion'],
                'discussionable_type' => $user->getMorphClass()
            ]);
            $new_discussion->discussionable()->associate($user);
            $new_discussion->proposal()->associate($proposal);
            $new_discussion->save();

            // Add Activity

            $activity_type = ActivityType::where('name', EnumsActivityType::Commented->value)->first();
            $activity = Activity::make();
            $activity->team()->associate($user->team);
            $activity->subject()->associate($proposal);
            $activity->causer()->associate($user);
            $activity->activity_type()->associate($activity_type);
            $activity->save();

            // Email client

            Mail::to($proposal->project->projectable->email)
                ->queue(new ProposalComment($proposal, $validated['discussion']));
        }

        // State

        if($request->filled("state")) {
            $proposal->state()->associate($validated['state']);
            $proposal->save();
        }

        // Email template

        if($request->filled("email_template")) {
            $proposal->emailTemplate()->associate($validated['email_template']);
            $proposal->save();
        }

        return back()
            ->with('status', __('Proposal updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        $this->authorize('delete', $proposal);

        $proposal->delete();

        return redirect()
            ->route('proposals.index')
            ->with('status', __('Proposal deleted!'));
    }

    public function send(Request $request, Proposal $proposal)
    {
        $user = $request->user();

        // Send Email

        Mail::to($proposal->project->projectable->email)
            ->queue(new ProposalSent($proposal));

        // Add Activity

        $activity_type = ActivityType::where('name', EnumsActivityType::Created->value)->first();
        $activity = Activity::make();
        $activity->team()->associate($user->team);
        $activity->subject()->associate($proposal);
        $activity->causer()->associate($user);
        $activity->activity_type()->associate($activity_type);
        $activity->save();

        return back()
            ->with('status', __('Email sent!'));
    }

    public function exportCsv()
    {
        return Excel::download(
            new ProposalsExport,
            'proposals.csv',
            \Maatwebsite\Excel\Excel::CSV,
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }

    public function exportPdf(Proposal $proposal)
    {
        $pdf = Pdf::loadView('pdf.proposal', compact('proposal'));
        return $pdf->download('proposal.pdf');
    }

    public function action(Request $request, Proposal $proposal)
    {
        if(!$request->filled('t')) {
            return abort(404);
        }

        $token = $request->input('t');

        $customer = null;
        $queryClient = $proposal->clients()->where('token', $token);
        $queryCompany = $proposal->companies()->where('token', $token);

        if($queryClient->exists()) {
            $customer = $queryClient->first();
        } else {
            $customer = $queryCompany->first();
        }

        if(!$request->filled('action')) {
            return abort(404);
        }

        $action = $request->input('action');
        $activity_type = null;

        if($action === EnumsProposalState::Rejected->value) {
            $state = ProposalState::where("name", EnumsProposalState::Rejected->value)->first();
            $proposal->state()->associate($state)->save();

            // Add Activity

            $activity_type = ActivityType::where('name', EnumsActivityType::Approved->value)->first();
            $activity = Activity::make();
            $activity->team()->associate($customer->team);
            $activity->subject()->associate($proposal);
            $activity->causer()->associate($customer);
            $activity->activity_type()->associate($activity_type);
            $activity->save();
            
            return back()
                ->with('status', __('Proposal approved!'));
        } else {
            $state = ProposalState::where("name", EnumsProposalState::Approved->value)->first();
            $proposal->state()->associate($state)->save();

            // Add Activity

            $activity_type = ActivityType::where('name', EnumsActivityType::Rejected->value)->first();
            $activity = Activity::make();
            $activity->team()->associate($customer->team);
            $activity->subject()->associate($proposal);
            $activity->causer()->associate($customer);
            $activity->activity_type()->associate($activity_type);
            $activity->save();

            return back()
                ->with('status', __('Proposal rejected!'));
        }
    }
}
