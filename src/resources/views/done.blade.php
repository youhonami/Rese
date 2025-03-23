@extends('layouts.layout')

@section('title', '予約完了')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done-container">
    <div class="done-box">
        <p class="done-message">ご予約ありがとうございます</p>
        <a href="{{ route('shops.index') }}" class="done-button">戻る</a>
    </div>
</div>
@endsection