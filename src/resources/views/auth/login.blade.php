@extends('layouts.layout')

@section('title', 'Login')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-container">
    <div class="login-box">
        <div class="login-header">Login</div>
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            <div class="form-group-wrapper">
                <div class="form-group">
                    <span class="icon">📧</span>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-wrapper">
                <div class="form-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password">
                </div>
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit">ログイン</button>
            </div>
        </form>
    </div>
</div>
@endsection