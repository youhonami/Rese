@extends('layouts.layout')

@section('title', 'Rese - マイページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="reservation-section">
        <h2>予約状況</h2>
        @foreach ($reservations as $index => $reservation)
        <div class="reservation-card">
            <div class="card-header">
                <span class="icon">⏰</span>
                <span class="title">予約{{ $index + 1 }}</span>
                <div class="card-actions">

                    {{-- QRコード表示ページへのリンク --}}
                    <a href="{{ route('reservations.qrcode', $reservation->id) }}" class="qr-btn">QRコード</a>

                    {{-- 編集アイコン --}}
                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="edit-btn">予約変更</a>

                    {{-- キャンセルボタン --}}
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('この予約をキャンセルしますか？');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cancel-btn">キャンセル</button>
                    </form>
                </div>
            </div>
            <ul>
                <li>Shop: {{ $reservation->shop->shop_name }}</li>
                <li>Date: {{ $reservation->date }}</li>
                <li>Time: {{ $reservation->time }}</li>
                <li>Number: {{ $reservation->number }}人</li>
            </ul>
        </div>
        @endforeach
    </div>

    <div class="favorite-section">
        <h2>{{ $user->name }}さん</h2>
        <h3>お気に入り店舗</h3>
        <div class="shop-container">
            @foreach ($favorites as $shop)
            <div class="shop-card">
                <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}">
                <div class="shop-info">
                    <h2>{{ $shop->shop_name }}</h2>
                    <p>#{{ $shop->area }} #{{ $shop->genre }}</p>
                    <div class="shop-footer">
                        <a href="{{ route('shops.detail', ['shop' => $shop->id]) }}" class="btn">詳しくみる</a>
                        <button type="button" class="heart-btn" data-shop-id="{{ $shop->id }}">
                            {{ Auth::user()->favorites->contains($shop->id) ? '❤️' : '♡' }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
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
@endsection