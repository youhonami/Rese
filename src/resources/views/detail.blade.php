@extends('layouts.layout')

@section('title', 'Rese - 店舗詳細')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="shop-detail">
    <div class="shop-detail__info">
        <a href="{{ route('shops.index') }}" class="shop-detail__back">&lt; 戻る</a>
        <h1>{{ $shop->shop_name }}</h1>
        <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}">
        <p class="shop-detail__tags">
            #{{ $shop->area->name ?? '未設定' }} #{{ $shop->genre->name ?? '未設定' }}
        </p>
        <p class="shop-detail__overview">{{ $shop->overview }}</p>

        @if(isset($reviews) && $reviews->isNotEmpty())
        <div class="shop-detail__review-list">
            <h3 class="shop-detail__review-title">レビュー一覧</h3>
            @foreach ($reviews as $r)
            <div class="shop-detail__review-item">
                <p class="shop-detail__review-user">{{ $r->user->name ?? '匿名' }}</p>
                <p class="shop-detail__stars">評価: {{ str_repeat('⭐', $r->review->rating) }}</p>
                @if($r->comment)
                <p class="shop-detail__review-comment">コメント: {{ $r->comment->comment }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="shop-detail__no-review">この店舗にはまだレビューがありません。</p>
        @endif
    </div>

    <div class="shop-detail__form">
        <h2 class="shop-detail__form-title">予約</h2>

        @auth
        @if (Auth::user()->role === 'user')
        <form action="{{ route('reservations.store') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            @error('shop_id')<div class="shop-detail__error">{{ $message }}</div>@enderror

            <label for="date">日付</label>
            <input type="date" id="date" name="date" value="{{ old('date') }}"
                min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
            @error('date')<div class="shop-detail__error">{{ $message }}</div>@enderror

            <label for="time">時間</label>
            <select id="time" name="time">
                <option value="" disabled {{ old('time') ? '' : 'selected' }}>時間を選択してください</option>
                @foreach(['17:00', '18:00', '19:00', '20:00', '21:00'] as $time)
                <option value="{{ $time }}" {{ old('time') == $time ? 'selected' : '' }}>{{ $time }}</option>
                @endforeach
            </select>
            @error('time')<div class="shop-detail__error">{{ $message }}</div>@enderror

            <label for="number">人数</label>
            <select id="number" name="number">
                <option value="" disabled {{ old('number') ? '' : 'selected' }}>人数を選択してください</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('number') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                    @endfor
            </select>
            @error('number')<div class="shop-detail__error">{{ $message }}</div>@enderror

            <div class="shop-detail__summary">
                <p>Shop: {{ $shop->shop_name }}</p>
                <p>Date: <span id="summary-date">{{ old('date') ?? '未選択' }}</span></p>
                <p>Time: <span id="summary-time">{{ old('time') ?? '未選択' }}</span></p>
                <p>Number: <span id="summary-number">{{ old('number') ? old('number') . '人' : '未選択' }}</span></p>
            </div>

            <button type="submit" class="shop-detail__submit">予約する</button>
        </form>
        @elseif (Auth::user()->role === 'representative')
        <p class="shop-detail__error">店舗代表者は予約できません。</p>
        @else
        <p class="shop-detail__error">管理者アカウントでは予約できません。</p>
        @endif
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