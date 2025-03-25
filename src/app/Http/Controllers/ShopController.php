<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    // 店舗一覧ページ
    public function index(Request $request)
    {
        // エリアとジャンルのユニーク値を取得
        $areas = Shop::select('area')->distinct()->pluck('area');
        $genres = Shop::select('genre')->distinct()->pluck('genre');

        // 検索機能
        $shops = Shop::query();
        if ($request->filled('area')) {
            $shops->where('area', $request->area);
        }
        if ($request->filled('genre')) {
            $shops->where('genre', $request->genre);
        }
        if ($request->filled('keyword')) {
            $shops->where('shop_name', 'like', '%' . $request->keyword . '%');
        }
        $shops = $shops->get();

        return view('index', compact('shops', 'areas', 'genres'));
    }


    // 店舗詳細ページ
    public function detail($id)
    {
        $shop = Shop::findOrFail($id); // 指定IDの店舗を取得
        return view('detail', compact('shop')); // detail.blade.php にデータを渡す
    }

    //リアルタイム検索
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
            $query->where('shop_name', 'LIKE', '%' . $request->keyword . '%');
        }

        $shops = $query->get();

        return response()->json($shops);
    }
}
