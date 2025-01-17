<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
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
            'name' => ['required', 'unique:tours,name'],
            'description' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'max_people' => 'required|numeric'
        ];
    }
}
