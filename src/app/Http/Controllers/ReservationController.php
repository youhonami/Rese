<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();

        Reservation::create([
            'user_id' => auth()->id(),
            'shop_id' => $validated['shop_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'number' => $validated['number'],
        ]);

        return redirect()->route('done');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->delete();

        return redirect()->route('mypage')->with('success', '予約をキャンセルしました');
    }

    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|in:17:00,18:00,19:00,20:00,21:00',
            'number' => 'required|integer|min:1|max:5',
        ]);

        $reservation->update($request->only('date', 'time', 'number'));

        return redirect()->route('mypage')->with('status', '予約を更新しました');
    }
}
