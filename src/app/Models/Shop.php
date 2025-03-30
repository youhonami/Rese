<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['shop_name', 'area', 'genre', 'overview', 'img'];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function detail(Shop $shop)
    {
        $reviews = $shop->reservations()
            ->with(['review', 'comment', 'user']) // ユーザー情報も表示したい場合
            ->whereHas('review') // レビューがある予約のみ取得
            ->get();

        return view('shops.detail', compact('shop', 'reviews'));
    }
}
