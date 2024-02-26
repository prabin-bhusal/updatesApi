<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:255'],
            'startDate' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'endDate' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date', 'after:today'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ]);
    }
}
