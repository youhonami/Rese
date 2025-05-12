<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ];
    }


    public function messages(): array
    {
        return [
            'subject.required' => '件名は入力必須です。',
            'message.required' => '本文は入力必須です。',
        ];
    }
}
