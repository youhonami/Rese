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
            <div class="form-group">
                <span class="icon">👤</span>
                <input type="text" name="name" placeholder="Username" required>
            </div>

            <div class="form-group">
                <span class="icon">📧</span>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <span class="icon">🔒</span>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-actions">
                <button type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection