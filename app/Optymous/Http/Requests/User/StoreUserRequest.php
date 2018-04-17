<?php

namespace App\Optymous\Http\Requests\User;

use App\Optymous\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('create', User::class);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
			"name" => "required",
			"email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required",
        ];
    }
}