<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopController extends Controller
{
    /**
     * 店舗情報フォーム表示
     */
    public function form()
    {
        $shop = auth()->user()->shop;
        $areas = Area::all();
        $genres = Genre::all();

        return view('representative.shop_form', compact('shop', 'areas', 'genres'));
    }

    /**
     * 店舗情報登録（新規 or 更新）
     */
    public function store(StoreShopRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        // 現在のショップを取得
        $shop = Shop::where('user_id', Auth::id())->first();

        // 画像処理
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('shops-img', 'public');
            $data['img'] = $path;
        } elseif ($shop && $shop->img) {
            $data['img'] = $shop->img;
        } else {
            return back()->withErrors(['img' => '画像は必須です'])->withInput();
        }

        // 登録または更新
        Shop::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'shop_name' => $data['shop_name'],
                'area_id' => $data['area_id'],
                'genre_id' => $data['genre_id'],
                'overview' => $data['overview'],
                'img' => $data['img'],
                'user_id' => $data['user_id'],
            ]
        );

        return redirect()->route('representative.dashboard')->with('success', '店舗情報を保存しました');
    }

    /**
     * 店舗情報更新（storeを再利用）
     */
    public function update(StoreShopRequest $request, Shop $shop)
    {
        return $this->store($request);
    }

    /**
     * ダッシュボード表示
     */
    public function index()
    {
        $shop = Shop::where('user_id', Auth::id())->first();
        return view('representative.dashboard', compact('shop'));
    }

    /**
     * 編集画面用（未使用なら削除してもOK）
     */
    public function edit()
    {
        $shop = Shop::firstOrNew(['user_id' => Auth::id()]);
        $areas = Area::all();
        $genres = Genre::all();

        return view('representative.shop_form', compact('shop', 'areas', 'genres'));
    }
}
