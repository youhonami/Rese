<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function edit()
    {
        $shop = Shop::firstOrNew(['user_id' => Auth::id()]);
        return view('representative.shop_form', compact('shop'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_name' => 'required|string|max:255',
            'area' => 'required|string',
            'genre' => 'required|string',
            'overview' => 'required|string',
            'img' => 'nullable|image|max:2048',
        ]);

        // ユーザーIDを追加
        $data['user_id'] = Auth::id();

        // 画像アップロード処理
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('shops-img', 'public');
            $data['img'] = $path;
        }

        // 店舗情報を保存（user_idで一意に更新 or 作成）
        Shop::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()->route('representative.dashboard')->with('success', '店舗情報を保存しました');
    }



    public function update(Request $request)
    {
        return $this->store($request);
    }

    public function index()
    {
        $user = Auth::user();
        $shop = Shop::where('user_id', $user->id)->first();

        return view('representative.dashboard', compact('shop'));
    }

    public function form()
    {
        $shop = auth()->user()->shop;

        return view('representative.shop_form', compact('shop'));
    }
}
