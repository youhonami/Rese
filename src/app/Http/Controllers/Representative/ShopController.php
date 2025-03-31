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
        ]);

        $data['user_id'] = Auth::id();

        Shop::updateOrCreate(['user_id' => Auth::id()], $data);

        return redirect()->route('representative.shop.edit')->with('success', '店舗情報を保存しました');
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
}
