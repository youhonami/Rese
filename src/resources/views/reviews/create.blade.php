@extends('layouts.layout')

@section('title', '評価する')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review">
    {{-- 左側：店舗情報 --}}
    <div class="review__shop">
        <h2 class="review__shop-title">{{ $reservation->shop->shop_name }}</h2>
        <img src="{{ asset('storage/' . $reservation->shop->img) }}" alt="{{ $reservation->shop->shop_name }}" class="review__shop-img">
        <p class="review__tags">
            #{{ optional($reservation->shop->area)->name ?? '未設定' }}
            #{{ optional($reservation->shop->genre)->name ?? '未設定' }}
        </p>
        <p class="review__overview">{{ $reservation->shop->overview }}</p>
    </div>

    {{-- 右側：評価フォーム --}}
    <div class="review__form-box">
        <h3 class="review__form-title">店舗を評価する</h3>

        <form action="{{ route('reviews.store', $reservation->id) }}" method="POST">
            @csrf

            <label class="review__form-label">評価（1〜5）</label>
            <div class="review__rating">
                @for ($i = 5; $i >= 1; $i--)
                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}">
                <label for="star{{ $i }}">★</label>
                @endfor
            </div>
            @error('rating')
            <div class="review__error">{{ $message }}</div>
            @enderror

            <label class="review__form-label">コメント</label>
            <textarea name="comment" class="review__textarea" placeholder="任意でコメントを入力">{{ old('comment') }}</textarea>
            @error('comment')
            <div class="review__error">{{ $message }}</div>
            @enderror

            <div class="review__btn-group">
                <button type="submit" class="review__btn">送信</button>
                <a href="{{ route('mypage') }}" class="review__btn review__btn--back">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection