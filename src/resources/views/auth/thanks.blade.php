@extends('layouts.layout')

@section('title', '会員登録完了')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
    <div class="thanks__card">
        <p class="thanks__message">会員登録ありがとうございます</p>
        <a href="{{ route('login') }}" class="thanks__button">ログインする</a>
    </div>
</div>
@endsection