<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'required',
            'newsId' => ['required', 'integer', Rule::exists('news', 'id')],
            'parentId' => ['nullable', 'integer', Rule::exists('comments', 'id')]
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'news_id' => $this->newsId,
            'parent_id' => $this->parentId
        ]);
    }
}
