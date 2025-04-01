<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class RepresentativeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $shop = Shop::where('user_id', $user->id)->first();

        return view('representative.dashboard', compact('shop'));
    }
}
