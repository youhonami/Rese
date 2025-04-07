<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShopRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * 店舗情報フォーム表示
     */
    public function form()
    {
        $shop = auth()->user()->shop;
        return view('representative.shop_form', compact('shop'));
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

        // 画像がある場合は保存、ない場合は既存の画像を保持
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('shops-img', 'public');
            $data['img'] = $path;
        } elseif ($shop && $shop->img) {
            $data['img'] = $shop->img; // 既存画像を保持
        } else {
            // 新規登録かつ画像もない場合はエラー
            return back()->withErrors(['img' => '画像は必須です'])->withInput();
        }

        // 登録または更新
        Shop::updateOrCreate(['user_id' => Auth::id()], $data);

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
        return view('representative.shop_form', compact('shop'));
    }
}
