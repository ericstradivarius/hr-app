<?php

namespace App\Optymous\Http\Requests\UserPermission;

use App\Optymous\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExportUserPermissionRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('read', UserPermission::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'type' => 'required|in:xls,xlsx,ods,pdf,html,csv',
			'filename' => 'required'
        ];
    }
}