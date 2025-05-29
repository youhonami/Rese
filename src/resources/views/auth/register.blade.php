@extends('layouts.layout')

@section('title', 'Registration')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register">
    <div class="register__box">
        <div class="register__header">Registration</div>
        <form method="POST" action="{{ route('register') }}" class="register__form">
            @csrf
            <div class="register__form-group-wrapper">
                <div class="register__form-group">
                    <span class="register__icon">👤</span>
                    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" class="register__input">
                </div>
                @error('name')
                <div class="register__error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="register__form-group-wrapper">
                <div class="register__form-group">
                    <span class="register__icon">📧</span>
                    <input type="text" name="email" placeholder="Email" value="{{ old('email') }}" class="register__input">
                </div>
                @error('email')
                <div class="register__error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="register__form-group-wrapper">
                <div class="register__form-group">
                    <span class="register__icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" class="register__input">
                </div>
                @error('password')
                <div class="register__error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="register__actions">
                <button type="submit" class="register__button">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection