@extends('layouts.layout')

@section('title', '店舗情報の管理')

@section('content')
<div class="container" style="max-width: 600px; margin: 40px auto;">
    <h2>店舗情報の登録・編集</h2>

    @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('representative.shop.store') }}" method="POST">
        @csrf
        <div>
            <label>店舗名</label>
            <input type="text" name="shop_name" value="{{ old('shop_name', $shop->shop_name) }}" required>
        </div>
        <div>
            <label>エリア</label>
            <input type="text" name="area" value="{{ old('area', $shop->area) }}" required>
        </div>
        <div>
            <label>ジャンル</label>
            <input type="text" name="genre" value="{{ old('genre', $shop->genre) }}" required>
        </div>
        <div>
            <label>概要</label>
            <textarea name="overview" required>{{ old('overview', $shop->overview) }}</textarea>
        </div>
        <button type="submit" style="margin-top: 15px;">保存する</button>
    </form>
</div>
@endsection