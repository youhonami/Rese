@extends('layouts.layout')

@section('title', 'Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="login__box">
        <div class="login__header">Login</div>
        <form method="POST" action="{{ route('login') }}" class="login__form" novalidate>
            @csrf

            <div class="login__form-group-wrapper">
                <div class="login__form-group">
                    <span class="login__icon">📧</span>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="login__input">
                </div>
                @error('email')
                <div class="login__error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="login__form-group-wrapper">
                <div class="login__form-group">
                    <span class="login__icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" class="login__input">
                </div>
                @error('password')
                <div class="login__error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="login__actions">
                <button type="submit" class="login__button">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection