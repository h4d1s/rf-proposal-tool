<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:255',
            'email' => 'required|max:255', // email:rfc,dns
            'phone' => 'nullable|max:255',
            'password' => 'required|confirmed|max:255',
            'password_confirmation' => 'required|same:password|max:255',
            'role' => 'required|numeric'
        ];
    }
}
