<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticeRequest extends FormRequest
{
    /**1
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'attachedFile' => ['sometimes', 'mimes:png,jpg,jpeg,gif,webp,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:102400'],
            'banner' => ['sometimes', 'mimes:png,jpg,jpeg,gif,webp', 'max:24576'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->attachedFile) {
            $this->merge([
                'attached_file' => $this->attachedFile,
            ]);
        }
    }
}
