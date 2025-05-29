@extends('layouts.layout')

@section('title', 'メール送信')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mail_form.css') }}">
@endsection

@section('content')
<div class="mail-form">
    <h2 class="mail-form__title">利用者へメール送信</h2>

    <form action="{{ route('representative.mail.send') }}" method="POST">
        @csrf
        <input type="hidden" name="to" value="{{ $user->email }}">

        <div class="mail-form__group">
            <label class="mail-form__label">件名</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="mail-form__input">
            @error('subject')
            <p class="mail-form__message mail-form__message--error">{{ $message }}</p>
            @enderror
        </div>

        <div class="mail-form__group">
            <label class="mail-form__label">本文</label>
            <textarea name="message" rows="6" class="mail-form__textarea">{{ old('message') }}</textarea>
            @error('message')
            <p class="mail-form__message mail-form__message--error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mail-form__button">送信する</button>
    </form>
</div>
@endsection