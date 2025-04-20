@extends('layouts.layout')

@section('title', '予約一覧 - 店舗代表者')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/representative_reservations.css') }}">
@endsection

@section('content')
<div class="reservation-container">
    <h2>予約状況一覧</h2>

    {{-- 戻るボタン --}}
    <a href="{{ route('representative.dashboard') }}" class="back-button">← 戻る</a>

    @if ($reservations->isEmpty())
    <p class="no-reservation">予約はまだありません。</p>
    @else
    <table class="reservation-table">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>日付</th>
                <th>時間</th>
                <th>人数</th>
                <th>店舗名</th>
                <th>支払い</th>
                <th>メール</th> {{-- 追加 --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->date }}</td>
                <td>{{ $reservation->time }}</td>
                <td>{{ $reservation->number }}人</td>
                <td>{{ $reservation->shop->shop_name }}</td>
                <td>
                    @if ($reservation->is_paid)
                    <span class="paid-label">支払済み</span>
                    @else
                    <span class="unpaid-label">未払い</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('representative.mail.form', ['user' => $reservation->user->id]) }}" class="mail-btn">
                        利用者にメール
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    @endif
</div>
@endsection