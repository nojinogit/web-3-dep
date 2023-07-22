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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a class="header__logo" href="/">
                    COACHTECH
                </a>
                <nav>
                    <ul class="header-nav">
                        <li class="header-nav__item">
                            <form action="">
                                <input type="text" onchange="this.form.submit()" placeholder="何をお探しですか？">
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
                            <a class="header-nav__link" href="/myPage">マイページ</a>
                        </li>
                        @endif
                        @unless (Auth::check())
                        <li class="header-nav__item">
                            <form class="form" action="/login" method="get">
                                <button class="header-nav__button">ログイン</button>
                            </form>
                        </li>
                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/register">会員登録</a>
                        </li>
                        @endunless
                    </ul>
                </nav>
                <div class="header__sell">
                    <a href="{{route('sell')}}">出品</a>
                </div>
            </div>
        </div>
    </header>
    <main>
    @yield('content')
    </main>
</body>
</html>