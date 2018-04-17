<?php

namespace App\Optymous\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $user = $this->route('user');
        return [
			"name" => "required",
            "password" => "confirmed",
            'email' => 'required|string|email|max:255' . ($user ? '|unique:users,email,' . $user->id : ''),
        ];
    }
}