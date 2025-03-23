@extends('layouts.layout')

@section('title', '会員登録完了')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-wrapper">
    <div class="thanks-card">
        <p class="message">会員登録ありがとうございます</p>
        <a href="{{ route('login') }}" class="login-btn">ログインする</a>
    </div>
</div>
@endsection