<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            'description' => ['sometimes','string'],
            'status' => ['required','in:to-do,on-going,completed'],
            'priority' => ['required','in:low,medium,high'],
            'assignee_id' => ['sometimes'],
            'due_date' => ['required','string'],
        ];
    }
}
