<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

class UpdatePlanteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required",
            "price" => ["required", "numeric", "regex:/^\d+(\.\d{1,2})?$/"],
            "image" => [File::image()->max(12 * 1024)],
            "description" => "required",
            "category_id" => ["required", "integer", "exists:App\Models\Category,id"],
        ];
    }
}
