@extends('layouts.layout')

@section('title', 'QRコード')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/qr.css') }}">
@endsection

@section('content')
<div class="qr-page">
    <h2>予約QRコード</h2>

    <p>以下のQRコードをお店でご提示ください。</p>

    <div class="qr-image">
        {!! $qrCode !!}
    </div>

    <a href="{{ route('mypage') }}" class="btn">マイページに戻る</a>
</div>
@endsection