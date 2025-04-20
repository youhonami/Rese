<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMailRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    /**
     * メール送信フォームを表示
     */
    public function form(User $user)
    {
        return view('representative.mail.form', compact('user'));
    }

    /**
     * メールを送信
     */
    public function send(SendMailRequest $request)
    {
        $validated = $request->validated();
        $representative = Auth::user();

        Mail::raw($validated['message'], function ($mail) use ($validated, $representative) {
            $mail->to($validated['to'])
                ->from($representative->email, $representative->name)
                ->subject($validated['subject']);
        });

        return redirect()->route('representative.reservations.index')->with('status', 'メールを送信しました。');
    }
}
