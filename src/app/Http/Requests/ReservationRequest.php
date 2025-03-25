<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 認可が不要なら true
    }

    public function rules(): array
    {
        return [
            'shop_id' => 'required|exists:shops,id',
            'date'    => 'required|date|after_or_equal:today',
            'time'    => 'required|in:17:00,18:00,19:00,20:00,21:00',
            'number'  => 'required|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'shop_id.required' => '店舗情報が見つかりません。',
            'shop_id.exists'   => '無効な店舗です。',
            'date.required'    => '日付を選択してください。',
            'date.date'        => '日付の形式が正しくありません。',
            'date.after_or_equal' => '過去の日付は選択できません。',
            'time.required'    => '時間を選択してください。',
            'time.in'          => '選択できる時間を選んでください。',
            'number.required'  => '人数を選択してください。',
            'number.integer'   => '人数は数字で指定してください。',
            'number.min'       => '1人以上を選択してください。',
            'number.max'       => '5人以下を選択してください。',
        ];
    }
}
