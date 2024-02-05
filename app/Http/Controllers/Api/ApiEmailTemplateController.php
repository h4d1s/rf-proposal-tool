<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmailTemplateResource;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class ApiEmailTemplateController extends Controller
{
    /**
     * Api Client Controller Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(EmailTemplate::class, 'emailTemplate');
    }

    /**
     * Show the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        return EmailTemplateResource::collection(EmailTemplate::where('id', $emailTemplate->id)->get());
    }

    /**
     * Search the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = EmailTemplate::query();
        $query->forTeam($team_id);

        if($request->has('q')) {
            $q = $request->query('q', '');
            $query->where('name', 'LIKE', '%'.$q.'%');
        }

        $emailTemplates = $query
            ->limit(5)
            ->get();

        return EmailTemplateResource::collection($emailTemplates);
    }
}
