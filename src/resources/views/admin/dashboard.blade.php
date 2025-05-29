@extends('layouts.layout')

@section('title', '管理者ダッシュボード')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-dashboard">
    <h2 class="admin-dashboard__title">管理者ダッシュボード</h2>

    @if(session('success'))
    <p class="admin-dashboard__message">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.representatives.create') }}" class="admin-dashboard__button">
        店舗代表者アカウント作成
    </a>
</div>
@endsection