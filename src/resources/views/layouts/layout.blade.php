<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sanitize.css">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @yield('styles')
</head>

<body>
    {{-- ハンバーガーアイコンのトグルは verify ページでは無効化 --}}
    <input type="checkbox" id="menu-toggle" class="menu-toggle"
        {{ Route::currentRouteName() === 'verification.notice' ? 'disabled' : '' }}>

    {{-- verify ページではメニューを非表示 --}}
    @if (Route::currentRouteName() !== 'verification.notice')
    <div class="menu-modal">
        <label for="menu-toggle" class="close-btn">✕</label>
        <ul>
            <li><a href="{{ route('shops.index') }}">Home</a></li>

            @auth
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="link-btn">Logout</button>
                </form>
            </li>

            @if (Auth::user()->role === 'user')
            <li><a href="{{ route('mypage') }}">Mypage</a></li>
            @endif

            @if (Auth::user()->role === 'representative')
            <li><a href="{{ route('representative.dashboard') }}">店舗代表者ページ</a></li>
            @endif

            @if (Auth::user()->role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}">管理者ページ</a></li>
            @endif
            @else
            <li><a href="{{ route('register') }}">Registration</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
        </ul>
    </div>
    @endif

    <header>
        <div class="logo">
            {{-- verify ページではアイコンを表示しない --}}
            @if (Route::currentRouteName() !== 'verification.notice')
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            @endif

            {{-- ロゴリンク：verify ページではクリック無効にして見た目は維持 --}}
            @if (Route::currentRouteName() === 'verification.notice')
            <span class="logo-disabled">Rese</span>
            @else
            <a href="{{ route('shops.index') }}">Rese</a>
            @endif
        </div>

        {{-- 以下は index ページだけに表示 --}}
        @if (Route::currentRouteName() === 'shops.index')
        <div class="filter">
            <form action="{{ route('shops.index') }}" method="GET">
                <select name="area">
                    <option value="">All area</option>
                    @foreach ($areas ?? [] as $area)
                    <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>
                        {{ $area }}
                    </option>
                    @endforeach
                </select>

                <select name="genre">
                    <option value="">All genre</option>
                    @foreach ($genres ?? [] as $genre)
                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                        {{ $genre }}
                    </option>
                    @endforeach
                </select>

                <input type="text" name="keyword" placeholder="Search ..." value="{{ request('keyword') }}">
            </form>
        </div>
        @endif
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>