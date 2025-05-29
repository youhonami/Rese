@extends('layouts.layout')

@section('title', '店舗情報作成・編集')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/shop_form.css') }}">
@endsection

@section('content')
<div class="shop-form">
    <h2 class="shop-form__title">店舗情報の{{ isset($shop) && $shop->exists ? '編集' : '作成' }}</h2>

    @if(session('success'))
    <p class="shop-form__message--success">{{ session('success') }}</p>
    @endif

    <form action="{{ isset($shop) && $shop->exists ? route('representative.shops.update', $shop->id) : route('representative.shops.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @if(isset($shop) && $shop->exists)
        @method('PUT')
        @endif

        <div class="shop-form__group">
            <label for="shop_name" class="shop-form__label">店舗名</label>
            <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name', $shop->shop_name ?? '') }}" class="shop-form__input">
            @error('shop_name') <div class="shop-form__error">{{ $message }}</div> @enderror
        </div>

        <div class="shop-form__group">
            <label for="area_id" class="shop-form__label">エリア</label>
            <select name="area_id" id="area_id" class="shop-form__input">
                <option value="">選択してください</option>
                @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ old('area_id', $shop->area_id ?? '') == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
                @endforeach
            </select>
            @error('area_id') <div class="shop-form__error">{{ $message }}</div> @enderror
        </div>

        <div class="shop-form__group">
            <label for="genre_id" class="shop-form__label">ジャンル</label>
            <select name="genre_id" id="genre_id" class="shop-form__input">
                <option value="">選択してください</option>
                @foreach($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id', $shop->genre_id ?? '') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
                @endforeach
            </select>
            @error('genre_id') <div class="shop-form__error">{{ $message }}</div> @enderror
        </div>

        <div class="shop-form__group">
            <label for="overview" class="shop-form__label">概要</label>
            <textarea name="overview" id="overview" rows="4" class="shop-form__textarea">{{ old('overview', $shop->overview ?? '') }}</textarea>
            @error('overview') <div class="shop-form__error">{{ $message }}</div> @enderror
        </div>

        <div class="shop-form__group">
            <label for="img" class="shop-form__label">画像</label>
            <input type="file" name="img" id="img" class="shop-form__file">
            @error('img') <div class="shop-form__error">{{ $message }}</div> @enderror

            @if(!empty($shop->img))
            <p class="shop-form__preview-label">現在の画像：</p>
            <img src="{{ asset('storage/' . $shop->img) }}" alt="現在の店舗画像" class="shop-form__current-img">
            @endif
        </div>

        <button type="submit" class="shop-form__submit">
            {{ isset($shop) && $shop->exists ? '更新する' : '登録する' }}
        </button>
    </form>
</div>
@endsection