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
        <form action="{{ route('reservations.store') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            @error('shop_id')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="date">日付</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required>
            @error('date')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="time">時間</label>
            <select id="time" name="time" required>
                <option value="" disabled {{ old('time') ? '' : 'selected' }}>時間を選択してください</option>
                <option value="17:00" {{ old('time') == '17:00' ? 'selected' : '' }}>17:00</option>
                <option value="18:00" {{ old('time') == '18:00' ? 'selected' : '' }}>18:00</option>
                <option value="19:00" {{ old('time') == '19:00' ? 'selected' : '' }}>19:00</option>
                <option value="20:00" {{ old('time') == '20:00' ? 'selected' : '' }}>20:00</option>
                <option value="21:00" {{ old('time') == '21:00' ? 'selected' : '' }}>21:00</option>
            </select>
            @error('time')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="number">人数</label>
            <select id="number" name="number" required>
                <option value="" disabled {{ old('number') ? '' : 'selected' }}>人数を選択してください</option>
                <option value="1" {{ old('number') == '1' ? 'selected' : '' }}>1人</option>
                <option value="2" {{ old('number') == '2' ? 'selected' : '' }}>2人</option>
                <option value="3" {{ old('number') == '3' ? 'selected' : '' }}>3人</option>
                <option value="4" {{ old('number') == '4' ? 'selected' : '' }}>4人</option>
                <option value="5" {{ old('number') == '5' ? 'selected' : '' }}>5人</option>
            </select>
            @error('number')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="reservation-summary">
                <p>Shop: {{ $shop->shop_name }}</p>
                <p>Date: <span id="summary-date">{{ old('date') ?? '未選択' }}</span></p>
                <p>Time: <span id="summary-time">{{ old('time') ?? '未選択' }}</span></p>
                <p>Number: <span id="summary-number">{{ old('number') ? old('number') . '人' : '未選択' }}</span></p>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');
        const numberSelect = document.getElementById('number');

        const summaryDate = document.getElementById('summary-date');
        const summaryTime = document.getElementById('summary-time');
        const summaryNumber = document.getElementById('summary-number');

        if (dateInput) {
            dateInput.addEventListener('input', function() {
                summaryDate.textContent = this.value || '未選択';
            });
        }

        if (timeSelect) {
            timeSelect.addEventListener('change', function() {
                summaryTime.textContent = this.value || '未選択';
            });
        }

        if (numberSelect) {
            numberSelect.addEventListener('change', function() {
                summaryNumber.textContent = this.value ? `${this.value}人` : '未選択';
            });
        }
    });
</script>
@endsection