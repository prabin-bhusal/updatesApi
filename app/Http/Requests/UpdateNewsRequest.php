<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('update');
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
                'bannerImage' => 'required|mimes:png,jpg,jpeg,gif,webp', //TODO: make this required
                'slug' => ['required', 'unique:news,slug'],
                'userId' => 'required|integer',
                'status' => ['required', Rule::in(['published', 'unpublished', 'draft'])]
            ];
        } else {
            return [
                'title' => 'sometimes|required',
                'content' => 'sometimes|required',
                'bannerImage' => 'sometimes|required|mimes:png,jpg,jpeg,gif,webp', //TODO: make this required
                'slug' => ['sometimes', 'required', 'unique:news,slug'],
                'userId' => 'sometimes|required|integer',
                'status' => ['sometimes', 'required', Rule::in(['published', 'unpublished', 'draft'])]
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->userId) {
            $this->merge([
                'user_id' => $this->userId,
                'banner_image' => $this->bannerImage
            ]);
        }
    }
}
