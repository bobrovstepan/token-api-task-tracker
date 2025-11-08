<?php

namespace App\Http\Requests;

use App\Enums\TaskStatuses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'status' => ['required', new Enum(TaskStatuses::class)],
            'finished_at' => ['sometimes', 'nullable', 'date_format:Y-m-d H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.enum' => 'Status must be one of: ' . implode(', ', TaskStatuses::values()),
            'finished_at.date_format' => 'Valid date format must be ' . date('Y-m-d H:i'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Incorrect data',
            'errors' => $validator->errors()
        ], 422));
    }
}
