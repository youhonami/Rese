@extends('layouts.layout')

@section('title', 'Rese - 飲食店一覧')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="shop-container">
    @foreach ($shops as $shop)
    <div class="shop-card">
        <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}">
        <div class="shop-info">
            <h2>{{ $shop->shop_name }}</h2>
            <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
            <div class="shop-footer">
                <a href="{{ route('shops.detail', ['shop' => $shop->id]) }}" class="btn">詳しくみる</a>
                @auth
                <button class="heart-btn" data-shop-id="{{ $shop->id }}">
                    {{ Auth::user()->favorites->contains($shop->id) ? '❤️' : '♡' }}
                </button>
                @endauth

                @guest
                <span class="heart-disabled">♡</span>
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
        document.querySelectorAll('.heart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const shopId = this.dataset.shopId;
                const isLiked = this.textContent.trim() === '❤️';
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/favorites/${shopId}`, {
                        method: isLiked ? 'DELETE' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: isLiked ? null : JSON.stringify({
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const area = document.querySelector('[name="area"]');
        const genre = document.querySelector('[name="genre"]');
        const keyword = document.querySelector('[name="keyword"]');
        const container = document.querySelector('.shop-container');

        function fetchShops() {
            const params = new URLSearchParams({
                area: area.value,
                genre: genre.value,
                keyword: keyword.value
            });

            fetch(`/api/shops/search?${params}`)
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = '';
                    if (data.length === 0) {
                        container.innerHTML = '<p>該当する店舗がありません。</p>';
                        return;
                    }

                    data.forEach(shop => {
                        const heartIcon = shop.is_favorite ? '❤️' : '♡';
                        const shopCard = `
        <div class="shop-card">
            <img src="/storage/${shop.img}" alt="${shop.shop_name}">
            <div class="shop-info">
                <h2>${shop.shop_name}</h2>
                <p>#${shop.area} #${shop.genre}</p>
                <div class="shop-footer">
                    <a href="/detail/${shop.id}" class="btn">詳しくみる</a>
                    <button class="heart-btn" data-shop-id="${shop.id}">${heartIcon}</button>
                </div>
            </div>
        </div>
    `;
                        container.insertAdjacentHTML('beforeend', shopCard);
                    });
                })
                .catch(err => {
                    console.error('検索エラー:', err);
                });
        }

        area.addEventListener('change', fetchShops);
        genre.addEventListener('change', fetchShops);
        keyword.addEventListener('input', fetchShops);
    });
</script>
@endsection