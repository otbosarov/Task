<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRejectionTaskRequest extends FormRequest
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
            "task_id" => "required|integer|exists:tasks,id",
            "task_comment" => "required|string|min:10|max:255"
        ];
    }
    public function messages(){
        return [
            'task_id.required' => "Rad etilgan loyihani ID sini kiriting",
            'task_id.integer' => "Rad etilgan loyihani ID sini raqam ko'rinishda kiriting",
            'task_id.exists' => "Rad etilgan loyihani ID si tizimda mavjud emas",
            'task_comment.required' => "Rad etilgan loyihaga izoh kiritilishi shart!",
            'task_comment.string' => "Rad etilgan loyihaga kiritilgan izoh matn korinishda bo'lishi kerak",
            'task_comment.min' => 'Rad etilgan loyihaga kiritilgan izoh kamida 10 ta belgidan iborat bo\'lishi kerak',
            'task_comment.max' => 'Rad etilgan loyihaga kiritilgan izoh  255 ta belgidan oshmasligi kerak'
        ];
    }
}
