@extends('layouts.layout')

@section('title', 'Rese - マイページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <h1 class="mypage__title">{{ $user->name }}さんのマイページ</h1>

    <div class="mypage__container">
        <section class="mypage__section mypage__section--reservations">
            <h2 class="mypage__section-title">予約状況</h2>

            @foreach ($reservations as $index => $reservation)
            @php
            $reservationDateTime = \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time);
            $isPast = now()->greaterThanOrEqualTo($reservationDateTime);
            @endphp
            <div class="mypage__reservation-card">
                <div class="mypage__card-header">
                    <span class="mypage__icon">⏰</span>
                    <span class="mypage__card-title">予約{{ $index + 1 }}</span>
                    <div class="mypage__card-actions">
                        <a href="{{ route('reservations.qrcode', $reservation->id) }}" class="mypage__btn mypage__btn--qr">QR</a>

                        @if ($isPast)
                        <span class="mypage__btn mypage__btn--disabled">変更不可</span>
                        @else
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="mypage__btn mypage__btn--edit">予約変更</a>
                        @endif

                        @if (!$isPast && !$reservation->is_paid)
                        <a href="{{ route('payment.checkout', ['reservation_id' => $reservation->id]) }}" class="mypage__btn mypage__btn--pay">事前決済</a>
                        @elseif($reservation->is_paid)
                        <span class="mypage__badge mypage__badge--paid">支払済み</span>
                        @elseif ($isPast)
                        <span class="mypage__btn mypage__btn--disabled">決済不可</span>
                        @endif

                        @if (!$reservation->review)
                        <a href="{{ route('reviews.create', $reservation->id) }}"
                            class="mypage__btn mypage__btn--review"
                            data-review-time="{{ $reservationDateTime->format('Y-m-d H:i') }}">
                            評価する
                        </a>
                        @else
                        <span class="mypage__badge mypage__badge--reviewed">評価済み</span>
                        @endif

                        @if ($isPast)
                        <span class="mypage__btn mypage__btn--disabled">来店済み</span>
                        @else
                        <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('この予約をキャンセルしますか？');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mypage__btn mypage__btn--cancel">キャンセル</button>
                        </form>
                        @endif
                    </div>
                </div>
                <ul class="mypage__reservation-info">
                    <li>Shop: {{ $reservation->shop->shop_name }}</li>
                    <li>Date: {{ $reservation->date }}</li>
                    <li>Time: {{ $reservation->time }}</li>
                    <li>Number: {{ $reservation->number }}人</li>
                </ul>
            </div>
            @endforeach
        </section>

        <section class="mypage__section mypage__section--favorites">
            <h2 class="mypage__section-title">お気に入り店舗</h2>

            <div class="mypage__shop-list">
                @foreach ($favorites as $shop)
                <div class="mypage__shop-card">
                    <img src="{{ asset('storage/' . $shop->img) }}" alt="{{ $shop->shop_name }}" class="mypage__shop-img">
                    <div class="mypage__shop-info">
                        <h3 class="mypage__shop-name">{{ $shop->shop_name }}</h3>
                        <p class="mypage__shop-tags">
                            #{{ optional($shop->area)->name ?? '未設定' }} #{{ optional($shop->genre)->name ?? '未設定' }}
                        </p>
                        <div class="mypage__shop-footer">
                            <a href="{{ route('shops.detail', ['shop' => $shop->id]) }}" class="mypage__btn mypage__btn--detail">詳しくみる</a>
                            <button type="button" class="mypage__btn mypage__btn--heart" data-shop-id="{{ $shop->id }}">
                                {{ Auth::user()->favorites->contains($shop->id) ? '❤️' : '♡' }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

<!-- 評価モーダル -->
<div id="reviewModal" class="modal">
    <div class="modal__content">
        <h3 class="modal__title">評価機能のご案内</h3>
        <p id="reviewModalMessage" class="modal__text"></p>
        <button onclick="closeReviewModal()" class="modal__btn">OK</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.mypage__btn--review').forEach(button => {
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

        document.querySelectorAll('.mypage__btn--heart').forEach(button => {
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