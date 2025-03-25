<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {


        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 登録処理（例）
        Reservation::create([
            'user_id' => auth()->id(),
            'shop_id' => $validated['shop_id'],
            'date'    => $validated['date'],
            'time'    => $validated['time'],
            'number'  => $validated['number'],
        ]);

        return redirect()->route('done');
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
