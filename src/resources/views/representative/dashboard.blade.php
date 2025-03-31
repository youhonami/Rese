@extends('layouts.layout')

@section('title', '店舗代表者ダッシュボード')

@section('content')
<div style="padding: 40px;">
    <h2>店舗代表者ダッシュボード</h2>
    <p>ここから予約確認・店舗情報の登録や編集が可能です。</p>

    {{-- 予約確認ページへ遷移するボタン --}}
    <div style="margin-top: 20px;">
        <a href="{{ route('representative.reservations.index') }}"
            style="padding: 10px 20px; background-color: #3366ff; color: white; border-radius: 5px; text-decoration: none;">
            予約状況を確認する
        </a>
    </div>
</div>
@endsection