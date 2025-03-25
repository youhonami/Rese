<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:30'],
            'email'    => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'ユーザーネームを入力してください。',
            'email.required'    => 'メールアドレスを入力してください。',
            'email.email'       => '正しいメールアドレス形式で入力してください。',
            'email.unique'      => 'このメールアドレスはすでに登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.min'      => 'パスワードは6文字以上で入力してください。',
        ];
    }
}
