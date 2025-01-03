<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
           'username' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:3|max:255',
        ];
    }
    public function messages(){
        return [
           'username.required' => ' Login kiritish majburiy',
            'username.min' => ' Login kamida 3 ta belgidan iborat bolishi kerak',
            'username.max' => 'Login ko\'pi bilan 255 ta  belgidan iborat bo\'lsin',
            'password.required' => 'Parol kiritish majburiy ',
            'password.min' => 'Parol kamida 3 belgidan iborat bolishi kerak ',
            'password.max' => 'Parol ko\'pi bilan 255 ta  belgidan iborat bo\'lsin',
        ];
    }
}
