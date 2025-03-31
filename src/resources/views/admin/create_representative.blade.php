@extends('layouts.layout')

@section('title', '店舗代表者の作成')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
@endsection

@section('content')
<div class="representative-create-container">
    <h2>店舗代表者アカウント作成</h2>

    @if (session('success'))
    <div class="success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.representatives.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">店舗名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}">
            @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
            @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <button type="submit">作成する</button>
    </form>
</div>
@endsection