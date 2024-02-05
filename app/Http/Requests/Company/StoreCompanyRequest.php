<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'required|max:255',
            'website' => 'nullable|string',
            'address' => 'required|max:255',
            'postal_code' => 'required|numeric',
            'city' => 'required',
            'country' => 'required',
        ];
    }
}
