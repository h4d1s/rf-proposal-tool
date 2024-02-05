<?php

namespace App\Http\Requests\Client;

use App\Validators\Client\StoreValidator;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'nullable|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'nullable',
            'company' => 'nullable|numeric',
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'country' => 'required',
        ];
    }
}
