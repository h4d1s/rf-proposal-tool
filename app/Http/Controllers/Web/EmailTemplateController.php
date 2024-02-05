<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplate\StoreEmailTemplateRequest;
use App\Http\Requests\EmailTemplate\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(EmailTemplate::class, 'email_template');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = EmailTemplate::query();
        $query = $query->forTeam($team_id);

        if (
            $request->filled(['email_template', 'action']) &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('email_template');
            EmailTemplate::whereIn('id', $ids)->each(function($email_template) {
                $email_template->delete();
            });
            $request->request->remove('email_template');

            $email_templates = $query
                ->all()
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('email_templates', compact('email_templates'))
                ->with('status', __('Email templates deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search');
            $query = $query->where('first_name', 'LIKE', '%'.$q.'%');
            $query = $query->where('last_name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order');
            $orderby = $request->query('orderby');
            $query = $query->orderBy($orderby, $order);
        }

        $email_templates = $query
            ->paginate(10)
            ->withQueryString();

        return view('settings.email-templates.index', compact('email_templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.email-templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmailTemplateRequest $request)
    {
        $validated = $request->safe()->all();
        EmailTemplate::create($validated);

        return redirect()
            ->route('settings.email-templates.index')
            ->with('status', __('Email template created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $email_template)
    {
        return view('settings.email-templates.show', compact('email_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $email_template)
    {
        return view('settings.email-templates.edit', compact('email_template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $email_template)
    {
        $validated = $request->safe()->all();
        $email_template->update($validated);

        return back()
            ->with('status', __('Email template updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $email_template)
    {
        $email_template->delete();

        return back()
            ->with('status', __('Email template deleted!'));
    }
}
