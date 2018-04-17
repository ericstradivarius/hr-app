<?php

namespace App\Optymous\Http\Requests\candidate;

use App\Optymous\candidate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorecandidateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('create', candidate::class);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
			"first_name" => "required|max:255",
			"last_name" => "required|max:255",
			"email" => "required|email|max:255|unique:candidates,email",
			"phone" => "required|max:255",
			"status" => "required|max:255",
			"dob" => "required|date",
            "stage" => "required"
        ];
    }
}