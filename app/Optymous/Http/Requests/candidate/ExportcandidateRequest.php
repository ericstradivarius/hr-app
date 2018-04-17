<?php

namespace App\Optymous\Http\Requests\candidate;

use App\Optymous\candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExportcandidateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('read', candidate::class);
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