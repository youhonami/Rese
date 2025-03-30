<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Comment;

class ReviewController extends Controller
{
    public function create(Reservation $reservation)
    {
        return view('reviews.create', compact('reservation'));
    }

    public function store(Request $request, Reservation $reservation)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);


        Review::create([
            'user_id' => Auth::id(),
            'reservation_id' => $reservation->id,
            'rating' => $request->rating,
        ]);


        if ($request->filled('comment')) {
            Comment::create([
                'user_id' => Auth::id(),
                'reservation_id' => $reservation->id,
                'comment' => $request->comment,
            ]);
        }

        return redirect()->route('mypage')->with('status', 'レビューを投稿しました。');
    }
}
