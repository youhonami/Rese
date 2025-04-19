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
        @php
        $reservationDateTime = \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time);
        $isPast = now()->greaterThanOrEqualTo($reservationDateTime);
        @endphp
        <div class="reservation-card">
            <div class="card-header">
                <span class="icon">⏰</span>
                <span class="title">予約{{ $index + 1 }}</span>
                <div class="card-actions">
                    <a href="{{ route('reservations.qrcode', $reservation->id) }}" class="qr-btn">QR</a>

                    @if ($isPast)
                    <span class="edit-disabled">変更不可</span>
                    @else
                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="edit-btn">予約変更</a>
                    @endif

                    @if (!$isPast && !$reservation->is_paid)
                    <a href="{{ route('payment.checkout', ['reservation_id' => $reservation->id]) }}" class="pay-btn">
                        事前決済
                    </a>
                    @elseif($reservation->is_paid)
                    <span class="paid-badge">支払済み</span>
                    @elseif ($isPast)
                    <span class="pay-disabled">決済不可</span>
                    @endif

                    @if (!$reservation->review)
                    <a href="{{ route('reviews.create', $reservation->id) }}"
                        class="review-btn"
                        data-review-time="{{ $reservationDateTime->format('Y-m-d H:i') }}">
                        評価する
                    </a>
                    @else
                    <span class="review-completed">評価済み</span>
                    @endif

                    @if ($isPast)
                    <span class="cancel-disabled">来店済み</span>
                    @else
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('この予約をキャンセルしますか？');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cancel-btn">キャンセル</button>
                    </form>
                    @endif
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

<div id="reviewModal" class="custom-modal">
    <div class="modal-content">
        <h3>評価機能のご案内</h3>
        <p id="reviewModalMessage"></p>
        <button onclick="closeReviewModal()">OK</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.review-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const dateTimeStr = this.dataset.reviewTime;
                const reservationDate = new Date(dateTimeStr.replace(/-/g, '/'));
                const now = new Date();

                if (now < reservationDate) {
                    e.preventDefault();
                    document.getElementById('reviewModalMessage').textContent = `評価は ${dateTimeStr} 以降に可能です`;
                    document.getElementById('reviewModal').style.display = 'flex';
                }
            });
        });

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
                }).then(response => {
                    if (response.ok) {
                        this.textContent = isLiked ? '♡' : '❤️';
                    } else {
                        alert('エラーが発生しました');
                    }
                });
            });
        });
    });

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }
</script>
@endsection