<?php

namespace App\Http\Requests;

use App\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskFormRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
            'name' => ['bail', 'required', Rule::unique('tasks', 'name')->ignore($this->task?->id)],
            'description' => ['bail', 'required'],
            'start_date' => ['bail', 'required', 'date_format:d-m-Y', 'before_or_equal:due_date'],
            'due_date' => ['bail', 'required', 'date_format:d-m-Y', 'after_or_equal:start_date'],
            'status' => ['bail', 'nullable', Rule::enum(TaskStatusEnum::class)]
        ];
    }
}
