@extends('layouts.layout')

@section('title', '店舗代表者の作成')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin_create.css') }}">
@endsection

@section('content')
<div class="representative-create">
    <h2 class="representative-create__title">店舗代表者アカウント作成</h2>

    @if (session('success'))
    <div class="representative-create__success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.representatives.store') }}" method="POST">
        @csrf

        <div class="representative-create__form-group">
            <label for="name" class="representative-create__label">店舗名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="representative-create__input">
            @error('name')<div class="representative-create__error">{{ $message }}</div>@enderror
        </div>

        <div class="representative-create__form-group">
            <label for="email" class="representative-create__label">メールアドレス</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="representative-create__input">
            @error('email')<div class="representative-create__error">{{ $message }}</div>@enderror
        </div>

        <div class="representative-create__form-group">
            <label for="password" class="representative-create__label">パスワード</label>
            <input type="password" name="password" id="password" class="representative-create__input">
            @error('password')<div class="representative-create__error">{{ $message }}</div>@enderror
        </div>

        <div class="representative-create__form-group">
            <label for="password_confirmation" class="representative-create__label">パスワード確認</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="representative-create__input">
        </div>

        <button type="submit" class="representative-create__button">作成する</button>
    </form>
</div>

@endsection