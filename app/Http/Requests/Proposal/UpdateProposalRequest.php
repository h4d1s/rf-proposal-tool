<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => 'nullable',
            'name' => 'required',
            'project' => 'required',
            'expiration_date' => 'nullable',
            'cover_letter' => 'nullable',
            'products' => 'nullable|array',
            'conclusion' => 'nullable',
            'note' => 'nullable',
            'discussion' => 'nullable',
            'state' => 'nullable',
            'email_template' => 'nullable',
            'pricing_table' => 'nullable',
            'pricing_table.*.id' => 'nullable|numeric',
            'pricing_table.*.name' => 'nullable|string',
            'pricing_table.*.qty' => 'nullable|numeric',
            'pricing_table.*.price' => 'nullable|numeric',
            'pricing_table.*.unit' => 'nullable|string',
            'pricing_table.*.description' => 'nullable|string',
        ];
    }
}
