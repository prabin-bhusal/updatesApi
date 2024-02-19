<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'resourceFile' => 'required|mimes:pdf,doc,docs,xlx,ppt,pptx',
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'user_id' => $this->userId,
            'resourceFile' => $this->resourceFile
        ]);
    }
}
