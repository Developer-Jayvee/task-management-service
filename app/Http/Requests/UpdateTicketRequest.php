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
        return true;
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
            'description' => ['sometimes'],
            'status' => ['required','in:to-do,in-progress,completed'],
            'priority' => ['required','in:low,medium,high'],
            'assignee_id' => ['sometimes'],
            'due_date' => ['required','string'],
        ];
    }
}
