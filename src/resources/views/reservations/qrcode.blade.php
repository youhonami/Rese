@extends('layouts.layout')

@section('title', 'QRコード')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/qr.css') }}">
@endsection

@section('content')
<div class="qr">
    <h2 class="qr__title">予約QRコード</h2>

    <p class="qr__description">以下のQRコードをお店でご提示ください。</p>

    <div class="qr__image">
        {!! $qrCode !!}
    </div>

    <a href="{{ route('mypage') }}" class="qr__link">マイページに戻る</a>
</div>
@endsection