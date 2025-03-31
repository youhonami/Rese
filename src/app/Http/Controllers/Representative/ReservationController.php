<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;


class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('shop', 'user')
            ->whereHas('shop', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'asc')
            ->get();

        return view('representative.reservations.index', compact('reservations'));
    }
}
