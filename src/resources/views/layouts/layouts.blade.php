<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/layouts.css')}}"/>
    @yield('css')
    @yield('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="header__logo-box">
                    <img src="{{asset('storage/sample/ロゴ.jpg')}}" alt="" class="header__logo-box-img">
                    <a class="header__logo header-utilities-a" href="/">COACHTECH</a>
                </div>
                <nav class="header-utilities-nav">
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <form action="{{route('search')}}">
                                <input type="text" name="name" onchange="this.form.submit()" placeholder="何をお探しですか？" class="search-input">
                            </form>
                        </li>
                        @if (Auth::check())
                        <li class="header-nav__item">
                            <form class="form" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link header-utilities-a" href="/myPage">マイページ</a>
                        </li>
                        @if(Auth::user()->role > 99)
                        <li class="header-nav__item">
                            <a class="header-nav__link header-utilities-a" href="/management">管理画面</a>
                        </li>
                        @endif
                        @endif
                        @unless (Auth::check())
                        <li class="header-nav__item">
                            <form class="form" action="/login" method="get">
                                <button class="header-nav__button">ログイン</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link header-utilities-a" href="/register">会員登録</a>
                        </li>
                        @endunless
                    </ul>
                </nav>
                <div class="header__sell">
                    <a href="{{route('sell')}}" class="header__sell-a">出品</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>