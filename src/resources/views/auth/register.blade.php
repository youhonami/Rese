@extends('layouts.layout')

@section('title', 'Registration')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <div class="register-box">
        <div class="register-header">Registration</div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group-wrapper">
                <div class="form-group">
                    <span class="icon">👤</span>
                    <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
                </div>
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-wrapper">
                <div class="form-group">
                    <span class="icon">📧</span>
                    <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
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
                <button type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection