<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'shop_name' => ['required', 'string', 'max:255'],
            'area_id' => ['required', 'exists:areas,id'],
            'genre_id' => ['required', 'exists:genres,id'],
            'overview' => ['required', 'string', 'max:1000'],
            'img' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // 新規作成時のみ画像を必須にする
        if (!$this->route('shop')) {
            $rules['img'][] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => '店舗名は必須です。',
            'area_id.required' => 'エリアは必須です。',
            'area_id.exists' => '選択されたエリアが存在しません。',
            'genre_id.required' => 'ジャンルは必須です。',
            'genre_id.exists' => '選択されたジャンルが存在しません。',
            'overview.required' => '概要は必須です。',
            'img.required' => '画像は必須です。',
            'img.image' => '画像ファイルをアップロードしてください。',
            'img.mimes' => '画像の形式は jpeg, png, jpg, gif のいずれかにしてください。',
            'img.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}
