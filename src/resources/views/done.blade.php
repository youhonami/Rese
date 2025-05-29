@extends('layouts.layout')

@section('title', '予約完了')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="reservation-done">
    <div class="reservation-done__box">
        <p class="reservation-done__message">ご予約ありがとうございます</p>
        <a href="{{ route('shops.index') }}" class="reservation-done__button">戻る</a>
    </div>
</div>
@endsection