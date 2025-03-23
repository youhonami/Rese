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
    <input type="checkbox" id="menu-toggle" class="menu-toggle">


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
            <li><a href="{{ route('mypage') }}">Mypage</a></li>
            @else
            <li><a href="{{ route('register') }}">Registration</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
            @endauth
        </ul>
    </div>

    <header>
        <div class="logo">
            <label for="menu-toggle" class="menu-icon">&#9776;</label>
            <a href="{{ route('shops.index') }}">Rese</a>
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