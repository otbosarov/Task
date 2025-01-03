<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'full_name' => 'required|string|min:3|max:120',
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'password' => 'required|string|min:4|max:255',
            'phone' => 'required|starts_with:+998|size:17|string|unique:users,phone'
        ];
    }
    public function messages(){
        return [
            'full_name.required' => 'Foydalanuvchi ismini kiritish majburiy!',
            'full_name.min' => 'Foydalanuvchi ismi kamida 3 ta belgidan iborat bolishi kerak ',
            'full_name.max' => "Foydalanuvchi ismi ko'pi bilan 120 ta belgidan iborat bolishi kerak",
            'username.required' => ' Login kiritish majburiy',
            'username.min' => ' Login kamida 3 ta belgidan iborat bolishi kerak',
            'username.max' => 'Login ko\'pi bilan 255 ta  belgidan iborat bo\'lsin',
            'username.unique' => 'Bu foydalanuvchi nomi allaqachon mavjud',
            'password.required' => 'Parol kiritish majburiy ',
            'password.min' => 'Parol kamida 4 belgidan iborat bolishi kerak ',
            'password.max' => 'Parol ko\'pi bilan 255 ta  belgidan iborat bo\'lsin',
            'phone.required' => 'Telefon raqam kiriting',
            'phone.starts_with' => 'Telefon raqamning boshi  +998 boshlanishi kerak ',
            'phone.size' => 'Telefon nomer kiritish maydoni 17 ta belgidan iborat bolishii kerak ',
            'phone.unique' => 'Telefon allaqachon olingan'

        ];
    }
}
