<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 店舗一覧ページ
    public function index(Request $request)
    {
        // Area モデルの全レコードを取得（オブジェクトの配列）
        $areas = Area::all();
        $genres = Genre::all();

        // 検索機能
        $shopsQuery = Shop::with(['area', 'genre']);

        if ($request->filled('area')) {
            $shopsQuery->where('area_id', $request->area);
        }

        if ($request->filled('genre')) {
            $shopsQuery->where('genre_id', $request->genre);
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
        $shop = Shop::with(['area', 'genre'])->findOrFail($id);

        $reviews = $shop->reservations()
            ->with(['review', 'comment', 'user'])
            ->whereHas('review')
            ->get();

        return view('detail', compact('shop', 'reviews'));
    }

    // リアルタイム検索（AJAX用）
    public function search(Request $request)
    {
        $query = Shop::with(['area', 'genre']);

        if ($request->filled('area')) {
            $query->where('area_id', $request->area);
        }

        if ($request->filled('genre')) {
            $query->where('genre_id', $request->genre);
        }

        if ($request->filled('keyword')) {
            $query->where('shop_name', 'like', '%' . $request->keyword . '%');
        }

        $shops = $query->get();

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
