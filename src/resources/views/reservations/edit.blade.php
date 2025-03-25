@extends('layouts.layout')

@section('title', 'Rese - 予約変更')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop-detail">
    <div class="shop-info">
        <a href="{{ route('mypage') }}" class="back-btn">&lt; 戻る</a>
        <h1>{{ $reservation->shop->shop_name }}</h1>
        <img src="{{ asset('storage/' . $reservation->shop->img) }}" alt="{{ $reservation->shop->shop_name }}">
        <p class="tags">#{{ $reservation->shop->area }} #{{ $reservation->shop->genre }}</p>
        <p class="overview">{{ $reservation->shop->overview }}</p>
    </div>

    <div class="reservation-box">
        <h2>予約変更</h2>

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="shop_id" value="{{ $reservation->shop->id }}">

            <label for="date">日付</label>
            <input type="date" id="date" name="date" value="{{ old('date', $reservation->date) }}" required>
            @error('date')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="time">時間</label>
            <select id="time" name="time" required>
                <option value="" disabled>時間を選択してください</option>
                @foreach (['17:00','18:00','19:00','20:00','21:00'] as $time)
                <option value="{{ $time }}" {{ old('time', $reservation->time) == $time ? 'selected' : '' }}>{{ $time }}</option>
                @endforeach
            </select>
            @error('time')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="number">人数</label>
            <select id="number" name="number" required>
                <option value="" disabled>人数を選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('number', $reservation->number) == $i ? 'selected' : '' }}>{{ $i }}人</option>
                    @endfor
            </select>
            @error('number')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <button type="submit" class="reserve-btn">変更を保存</button>
        </form>
    </div>
</div>
@endsection