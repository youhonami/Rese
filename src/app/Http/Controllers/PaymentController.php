<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $reservationId = $request->query('reservation_id');
        $reservation = \App\Models\Reservation::findOrFail($reservationId);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => 1000,
                    'product_data' => [
                        'name' => '予約：' . $reservation->shop->shop_name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['reservation_id' => $reservation->id]),
            'cancel_url' => route('mypage'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // 支払成功後の処理
        $reservation = \App\Models\Reservation::find($request->query('reservation_id'));
        if ($reservation) {
            $reservation->is_paid = true;
            $reservation->save();
        }

        return redirect()->route('mypage')->with('status', 'お支払いが完了しました');
    }
}
