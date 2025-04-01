@extends('layouts.layout')

@section('title', '店舗代表者ダッシュボード')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/representative_dashboard.css') }}">
@endsection

@section('content')
<div class="representative-dashboard">
    <h2>店舗代表者ダッシュボード</h2>

    {{-- 店舗名を表示 --}}
    @if ($shop)
    <p class="shop-name">店舗名：{{ $shop->shop_name }}</p>
    @else
    <p class="shop-name" style="color: red;">※ 店舗情報が未登録です。</p>
    @endif

    <p>ここから予約確認・店舗情報の登録や編集が可能です。</p>

    <a href="{{ route('representative.reservations.index') }}" class="btn">
        予約状況を確認する
    </a>

    <a href="#" class="btn" style="margin-top: 20px;">
        店舗情報を作成・更新する
    </a>
</div>
@endsection