<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:remind';
    protected $description = '予約当日のユーザーにリマインダーメールを送信する';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $reservations = Reservation::where('date', $today)->with('user', 'shop')->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
        }

        $this->info('リマインダーを送信しました');
    }
}
