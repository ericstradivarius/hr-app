<?php

namespace App\Optymous\Http\Requests\UserType;

use App\Optymous\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExportUserTypeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('read', UserType::class);
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