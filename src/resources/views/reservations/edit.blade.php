@extends('layouts.layout')

@section('title', 'Rese - 予約変更')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop-detail">
    <div class="shop-detail__info">
        <a href="{{ route('mypage') }}" class="shop-detail__back">&lt; 戻る</a>
        <h1>{{ $reservation->shop->shop_name }}</h1>
        <img src="{{ asset('storage/' . $reservation->shop->img) }}" alt="{{ $reservation->shop->shop_name }}">
        <p class="shop-detail__tags">
            #{{ optional($reservation->shop->area)->name ?? '未設定' }}
            #{{ optional($reservation->shop->genre)->name ?? '未設定' }}
        </p>
        <p class="shop-detail__overview">{{ $reservation->shop->overview }}</p>
    </div>

    <div class="shop-detail__form">
        <h2 class="shop-detail__form-title">予約変更</h2>

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="shop_id" value="{{ $reservation->shop->id }}">

            <label for="date">日付</label>
            <input type="date" id="date" name="date" value="{{ old('date', $reservation->date) }}" required>
            @error('date')
            <div class="shop-detail__error">{{ $message }}</div>
            @enderror

            <label for="time">時間</label>
            <select id="time" name="time" required>
                <option value="" disabled>時間を選択してください</option>
                @foreach (['17:00','18:00','19:00','20:00','21:00'] as $time)
                <option value="{{ $time }}" {{ old('time', $reservation->time) == $time ? 'selected' : '' }}>{{ $time }}</option>
                @endforeach
            </select>
            @error('time')
            <div class="shop-detail__error">{{ $message }}</div>
            @enderror

            <label for="number">人数</label>
            <select id="number" name="number" required>
                <option value="" disabled>人数を選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('number', $reservation->number) == $i ? 'selected' : '' }}>{{ $i }}人</option>
                    @endfor
            </select>
            @error('number')
            <div class="shop-detail__error">{{ $message }}</div>
            @enderror

            <button type="submit" class="shop-detail__submit">変更を保存</button>
        </form>
    </div>
</div>
@endsection