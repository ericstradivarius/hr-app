<?php

namespace App\Optymous\Http\Requests\campaign;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatecampaignRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('update', $this->route('campaign'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
			"name" => "required|max:255",
			"start_date" => "required|date",
			"end_date" => "required|date",
			"status" => "required|in:active,inactive",
			"available_jobs" => "required|numeric",
			"description" => "max:255"
        ];
    }
}