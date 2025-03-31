@extends('layouts.layout')

@section('title', '予約一覧 - 店舗代表者')

@section('content')
<div style="padding: 40px;">
    <h2>予約状況一覧</h2>

    {{-- 戻るボタン --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('representative.dashboard') }}"
            style="display: inline-block; padding: 8px 16px; background-color: #666; color: white; text-decoration: none; border-radius: 5px;">
            ← 戻る
        </a>
    </div>

    @if ($reservations->isEmpty())
    <p>予約はまだありません。</p>
    @else
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>日付</th>
                <th>時間</th>
                <th>人数</th>
                <th>店舗名</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection