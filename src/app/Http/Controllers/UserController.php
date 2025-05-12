<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $reservations = $user->reservations()->with('shop')->get();
        $favorites = $user->favorites;

        return view('mypage', compact('user', 'reservations', 'favorites'));
    }
}
