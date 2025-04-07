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
            'area' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'overview' => ['required', 'string', 'max:1000'],
            'img' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // 新規作成時のみ img を必須に
        if (!$this->route('shop')) {
            $rules['img'][] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => '店舗名は必須です。',
            'area.required' => 'エリアは必須です。',
            'genre.required' => 'ジャンルは必須です。',
            'overview.required' => '概要は必須です。',
            'img.required' => '画像は必須です。',
            'img.image' => '画像ファイルをアップロードしてください。',
            'img.mimes' => '画像の形式は jpeg, png, jpg, gif のいずれかにしてください。',
            'img.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}
