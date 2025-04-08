@extends('layouts.layout')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection
@section('title', 'メール認証')

@section('content')
<div class="verify-container">
    <h2>メールアドレスを確認してください</h2>
    <p>送信ボタンをクリックすると登録メールアドレスに認証用メールが送信されます。</p>
    <p>メール内のリンクをクリックして認証を完了してください。</p>

    @if (session('status') == 'verification-link-sent')
    <p class="success-message">認証用メールが送信されました。</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">送信</button>
    </form>
</div>
@endsection