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
    <input type="checkbox" id="menu-toggle" class="menu__toggle"
        {{ Route::currentRouteName() === 'verification.notice' ? 'disabled' : '' }}>

    @if (Route::currentRouteName() !== 'verification.notice')
    <div class="menu__modal">
        <label for="menu-toggle" class="menu__close">✕</label>
        <ul class="menu__list">
            <li class="menu__item"><a href="{{ route('shops.index') }}" class="menu__link">Home</a></li>

            @auth
            @php $role = Auth::user()->role; @endphp

            <li class="menu__item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="menu__logout-btn">Logout</button>
                </form>
            </li>

            @if ($role === 'user')
            <li class="menu__item"><a href="{{ route('mypage') }}" class="menu__link">Mypage</a></li>
            @elseif ($role === 'representative')
            <li class="menu__item"><a href="{{ route('representative.dashboard') }}" class="menu__link">店舗代表者ページ</a></li>
            @elseif ($role === 'admin')
            <li class="menu__item"><a href="{{ route('admin.dashboard') }}" class="menu__link">管理者ページ</a></li>
            @endif
            @endauth

            @guest
            <li class="menu__item"><a href="{{ route('register') }}" class="menu__link">Registration</a></li>
            <li class="menu__item"><a href="{{ route('login') }}" class="menu__link">Login</a></li>
            @endguest
        </ul>
    </div>
    @endif

    <header class="header">
        <div class="header__logo">
            @if (Route::currentRouteName() !== 'verification.notice')
            <label for="menu-toggle" class="header__menu-icon">&#9776;</label>
            @endif

            @if (Route::currentRouteName() === 'verification.notice')
            <span class="header__logo-disabled">Rese</span>
            @else
            <a href="{{ route('shops.index') }}" class="header__logo-link">Rese</a>
            @endif
        </div>

        @if (Route::currentRouteName() === 'shops.index')
        <div class="header__filter">
            <form id="filter-form" action="{{ route('shops.index') }}" method="GET">
                <select name="area">
                    <option value="">All area</option>
                    @foreach ($areas ?? [] as $area)
                    <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                    @endforeach
                </select>

                <select name="genre">
                    <option value="">All genre</option>
                    @foreach ($genres ?? [] as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
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

    @if (Route::currentRouteName() === 'shops.index')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filter-form');
            const area = form.querySelector('[name="area"]');
            const genre = form.querySelector('[name="genre"]');
            const keyword = form.querySelector('[name="keyword"]');

            area.addEventListener('change', () => form.submit());
            genre.addEventListener('change', () => form.submit());
            keyword.addEventListener('input', debounce(() => form.submit(), 500));

            function debounce(callback, delay) {
                let timeout;
                return function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(callback, delay);
                };
            }
        });
    </script>
    @endif
</body>

</html>