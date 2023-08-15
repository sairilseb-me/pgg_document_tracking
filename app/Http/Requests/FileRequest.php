<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $validate = [
            'user-id' => 'required|numeric',
            'filename' => 'required|string',
            'file' => 'required|mimes:doc,docx,xls,xlsx,pdf,zip,txt',
        ];

        return $validate;
    }
}
