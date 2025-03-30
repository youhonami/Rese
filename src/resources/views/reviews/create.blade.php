@extends('layouts.layout')

@section('title', '評価する')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review-page">
    {{-- 左側：店舗情報 --}}
    <div class="shop-info">
        <h2>{{ $reservation->shop->shop_name }}</h2>
        <img src="{{ asset('storage/' . $reservation->shop->img) }}" alt="{{ $reservation->shop->shop_name }}">
        <p class="tags">#{{ $reservation->shop->area }} #{{ $reservation->shop->genre }}</p>
        <p class="overview">{{ $reservation->shop->overview }}</p>
    </div>

    {{-- 右側：評価フォーム --}}
    <div class="review-form-box">
        <h3>店舗を評価する</h3>

        <form action="{{ route('reviews.store', $reservation->id) }}" method="POST">
            @csrf

            <label>評価（1〜5）</label>
            <div class="star-rating">
                @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                <label for="star{{ $i }}">★</label>
                @endfor
            </div>
            @error('rating')<div class="error">{{ $message }}</div>@enderror

            <label>コメント</label>
            <textarea name="comment" rows="4" placeholder="任意でコメントを入力">{{ old('comment') }}</textarea>
            @error('comment')<div class="error">{{ $message }}</div>@enderror

            <div class="btn-group">
                <button type="submit" class="btn">送信</button>
                <a href="{{ route('mypage') }}" class="btn back-btn">戻る</a>
            </div>
        </form>

    </div>
</div>
@endsection