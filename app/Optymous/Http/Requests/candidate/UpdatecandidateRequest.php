<?php

namespace App\Optymous\Http\Requests\candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatecandidateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('update', $this->route('candidate'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $candidate = $this->route('candidate');
        return [
			"first_name" => "required|max:255",
			"last_name" => "required|max:255",
            'email' => 'required|string|email|max:255' . ($candidate ? '|unique:candidates,email,' . $candidate->id : ''),
			"phone" => "required|max:255",
			"status" => "required|max:255",
			"dob" => "required|date",
            "stage" => "required"
        ];
    }
}