<?php

namespace App\Optymous\Http\Requests\UserPermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserPermissionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('update', $this->route('userPermission'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
			"entity" => "required",
			"label" => "required",
			"user_type_id" => "required",
			"user_type_id" => "required|exists:". app('App\Optymous\UserType')->getTable() . ",id"
        ];
    }
}