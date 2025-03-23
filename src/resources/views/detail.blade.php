@extends('layouts.layout')

@section('title', 'Rese - 店舗詳細')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop-detail">
    <div class="shop-info">
        <a href="{{ route('shops.index') }}" class="back-btn">&lt; 戻る</a>
        <h1>{{ $shop->shop_name }}</h1>
        <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}">
        <p class="tags">#{{ $shop->area }} #{{ $shop->genre }}</p>
        <p class="overview">{{ $shop->overview }}</p>
    </div>

    <div class="reservation-box">
        <h2>予約</h2>

        @auth
        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <label for="date">日付</label>
            <input type="date" id="date" name="date" required>

            <label for="time">時間</label>
            <select id="time" name="time">
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
            </select>

            <label for="number">人数</label>
            <select id="number" name="number">
                <option value="1">1人</option>
                <option value="2">2人</option>
                <option value="3">3人</option>
                <option value="4">4人</option>
                <option value="5">5人</option>
            </select>

            <div class="reservation-summary">
                <p>Shop: {{ $shop->shop_name }}</p>
                <p>Date: <span>{{ old('date') }}</span></p>
                <p>Time: <span>{{ old('time') }}</span></p>
                <p>Number: <span>{{ old('number') }}</span></p>
            </div>

            <button type="submit" class="reserve-btn">予約する</button>
        </form>
        @endauth

        @guest
        <p>予約には<a href="{{ route('login') }}">ログイン</a>が必要です。</p>
        @endguest
    </div>

</div>
@endsection