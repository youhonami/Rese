<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request, Shop $shop)
    {
        Auth::user()->favorites()->attach($shop->id);
        return back();
    }

    public function destroy($shopId)
    {
        $user = auth()->user();
        $user->favorites()->detach($shopId);

        return response()->json(['message' => 'いいねを解除しました']);
    }
}
