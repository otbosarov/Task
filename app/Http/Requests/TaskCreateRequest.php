<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
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
            "projectname" => 'required|string|min:6|max:255',
            "dascription" => 'required|string|min:10|max:255',
            "expiration_date" => 'required|date'
        ];
    }
    public function messages(){
        return [
            'projectname.required' => 'Loyiha nomi kiriting!',
            'projectname.min' => 'Loyiha  nomi kamida 6 ta belgidan iborat bo\'lishi kerak',
            'projectname.max' => 'Loyiha nomi ko\'pi bilan 255 ta belgidan iborat bolishi kerak ',
            'dascription.required' => 'Loyiha haqida qisqacha tavsif kiriting',
            'dascription.min' => 'Loyiha haqida qisqacha tavsif kamida 10 ta belgidan iborat bo\'lishi kerak',
            'dascription.max' => 'Loyiha haqida qisqacha tavsif ko\'pi bilan 255 ta belgidan iborat bo\'lishi kerak',
            'expiration_date.required' => 'Loyihani tugash sanasini  kiriting ',
            'expiration_date.date' => "Kiritilayotgan sana date('Y-m-d') formatda bolsin!"
        ];
    }
}
