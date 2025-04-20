@extends('layouts.layout')

@section('title', 'メール送信')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mail_form.css') }}">
@endsection

@section('content')
<div class="mail-form-container">
    <h2>利用者へメール送信</h2>
    <form action="{{ route('representative.mail.send') }}" method="POST">
        @csrf
        <input type="hidden" name="to" value="{{ $user->email }}">

        <div>
            <label>件名</label>
            <input type="text" name="subject" value="{{ old('subject') }}">
            @error('subject')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>本文</label>
            <textarea name="message" rows="6">{{ old('message') }}</textarea>
            @error('message')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">送信する</button>
    </form>
</div>
@endsection