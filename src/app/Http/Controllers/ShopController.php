<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 店舗一覧ページ
    public function index(Request $request)
    {
        // エリアとジャンルのユニーク値を取得
        $areas = Shop::select('area')->distinct()->pluck('area');
        $genres = Shop::select('genre')->distinct()->pluck('genre');

        // 検索機能
        $shopsQuery = Shop::query();

        if ($request->filled('area')) {
            $shopsQuery->where('area', $request->area);
        }
        if ($request->filled('genre')) {
            $shopsQuery->where('genre', $request->genre);
        }
        if ($request->filled('keyword')) {
            $shopsQuery->where('shop_name', 'like', '%' . $request->keyword . '%');
        }

        $shops = $shopsQuery->get();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    // 店舗詳細ページ
    public function detail($id)
    {
        $shop = Shop::findOrFail($id);

        // この店舗の予約に紐づいたレビューとコメントを取得
        $reviews = $shop->reservations()
            ->with(['review', 'comment', 'user'])
            ->whereHas('review')
            ->get();

        return view('detail', compact('shop', 'reviews'));
    }

    // リアルタイム検索（AJAX用）
    public function search(Request $request)
    {
        $query = Shop::query();

        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('keyword')) {
            $query->where('shop_name', 'like', '%' . $request->keyword . '%');
        }

        $shops = $query->get();

        // お気に入り情報を付加
        if (Auth::check()) {
            $favorites = Auth::user()->favorites->pluck('id')->toArray();
            $shops->transform(function ($shop) use ($favorites) {
                $shop->is_favorite = in_array($shop->id, $favorites);
                return $shop;
            });
        }

        return response()->json($shops);
    }
}
