@extends('layouts.layout')

@section('title', 'Rese - 飲食店一覧')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="shop-index">
    @foreach ($shops as $shop)
    <div class="shop-index__card">
        <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}" class="shop-index__image">
        <div class="shop-index__info">
            <h2 class="shop-index__info-title">{{ $shop->shop_name }}</h2>
            <p class="shop-index__info-tags">
                #{{ optional($shop->area)->name ?? '未設定' }} #{{ optional($shop->genre)->name ?? '未設定' }}
            </p>
            <div class="shop-index__footer">
                <a href="{{ route('shops.detail', ['shop' => $shop->id]) }}" class="shop-index__btn">詳しくみる</a>
                @auth
                @if (Auth::user()->role === 'user')
                <button class="shop-index__heart" data-shop-id="{{ $shop->id }}">
                    {{ Auth::user()->favorites->contains($shop->id) ? '❤️' : '♡' }}
                </button>
                @else
                <span class="shop-index__heart--disabled">♡</span>
                @endif
                @endauth
                @guest
                <span class="shop-index__heart--disabled">♡</span>
                @endguest
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.shop-index__heart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const shopId = this.dataset.shopId;
                const isLiked = this.textContent.trim() === '❤️';

                fetch(`/favorites/${shopId}`, {
                        method: isLiked ? 'DELETE' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            shop_id: shopId
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            this.textContent = isLiked ? '♡' : '❤️';
                        } else {
                            alert('エラーが発生しました');
                        }
                    });
            });
        });
    });
</script>
@endsection