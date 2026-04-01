<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('tasks')->where(fn ($query) => $query->where('due_date', $this->due_date))
            ],
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ];
    }
}