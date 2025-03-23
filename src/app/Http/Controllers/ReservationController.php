<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'time' => 'required',
            'number' => 'required|integer|min:1',
        ]);

        Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return view('done');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        // ログインユーザーの予約か確認
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->delete();

        return redirect()->route('mypage')->with('success', '予約をキャンセルしました');
    }
}
