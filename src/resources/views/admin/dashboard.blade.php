@extends('layouts.layout')

@section('title', '管理者ダッシュボード')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-dashboard" style="padding: 40px;">
    <h2>管理者ダッシュボード</h2>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('admin.representatives.create') }}" class="btn">店舗代表者アカウント作成</a>
</div>
@endsection