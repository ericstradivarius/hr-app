<?php

namespace App\Optymous\Http\Requests\File;

use App\Optymous\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFileRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->can('create', File::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            "file" => "required|file",
            "type" => "required|in:document,image",
            "entity" => "required",
            "purpose" => "required"
        ];
    }
}