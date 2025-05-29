@extends('layouts.layout')

@section('title', 'メール認証')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="verify">
    <h2 class="verify__title">メールアドレスを確認してください</h2>
    <p class="verify__text">登録メールアドレスに認証用メールが送信されました</p>
    <p class="verify__text">メール内のリンクをクリックして認証を完了してください。</p>
    <p class="verify__text">送信ボタンをクリックすると登録メールアドレスに認証用メールが再送信されます。</p>

    @if (session('status') == 'verification-link-sent')
    <p class="verify__message--success">認証用メールが再送信されました。</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="verify__form">
        @csrf
        <button type="submit" class="verify__button">再送信</button>
    </form>
</div>
@endsection