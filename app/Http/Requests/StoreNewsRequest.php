<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
        // return true;
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
            'bannerImage' => 'required|mimes:png,jpg,jpeg,gif,webp', //TODO: make this required
            'slug' => ['required', 'unique:news,slug'],
            'status' => ['required', Rule::in(['published', 'unpublished', 'draft'])]
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'user_id' => $this->userId,
            'banner_image' => $this->bannerImage
        ]);
    }
}
