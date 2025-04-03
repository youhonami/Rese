@extends('layouts.layout')

@section('title', '店舗情報作成・編集')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shop_form.css') }}">
@endsection

@section('content')
<div class="shop-form-container">
    <h2>店舗情報の{{ isset($shop) && $shop->exists ? '編集' : '作成' }}</h2>

    @if(session('success'))
    <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ isset($shop) && $shop->exists ? route('representative.shops.update', $shop->id) : route('representative.shops.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @if(isset($shop) && $shop->exists)
        @method('PUT')
        @endif

        <div class="form-group">
            <label for="shop_name">店舗名</label>
            <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name', $shop->shop_name ?? '') }}">
            @error('shop_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="area">エリア</label>
            <input type="text" name="area" id="area" value="{{ old('area', $shop->area ?? '') }}">
            @error('area') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="genre">ジャンル</label>
            <input type="text" name="genre" id="genre" value="{{ old('genre', $shop->genre ?? '') }}">
            @error('genre') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="overview">概要</label>
            <textarea name="overview" id="overview" rows="4">{{ old('overview', $shop->overview ?? '') }}</textarea>
            @error('overview') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="img">画像</label>
            <input type="file" name="img" id="img">
            @error('img') <div class="error">{{ $message }}</div> @enderror

            @if(isset($shop->img))
            <p class="current-img-label">現在の画像：</p>
            <img src="{{ asset('storage/' . $shop->img) }}" alt="現在の店舗画像" class="current-img">
            @endif

        </div>

        <button type="submit" class="submit-btn">
            {{ isset($shop) && $shop->exists ? '更新する' : '登録する' }}
        </button>
    </form>
</div>
@endsection