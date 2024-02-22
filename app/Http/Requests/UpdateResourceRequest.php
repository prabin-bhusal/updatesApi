<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceRequest extends FormRequest
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
        $method = $this->method();

        if ($method == "PUT") {
            return [
                'title' => 'required',
                'content' => 'required',
                'resourceFile' => 'required|mimes:pdf,doc,docs,xlx,ppt,pptx', //TODO: make this required
                'userId' => 'required|integer',
            ];
        } else {
            return [
                'title' => 'sometimes|required',
                'content' => 'sometimes|required',
                'resourceFile' => 'sometimes|required|mimes:pdf,doc,docs,xlx,ppt,pptx',
                'userId' => 'sometimes|required|integer',
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->userId) {
            $this->merge([
                'user_id' => $this->userId,
                'resource_file' => $this->resourceFile
            ]);
        }
    }
}
