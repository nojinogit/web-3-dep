<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="responsive">
                            <span class="nav_toggle">
                                <i></i>
                                <i></i>
                                <i></i>
                            </span>
                            @auth
                            <nav class="nav">
                                <ul class="nav_menu_ul">
                                    <li class="nav_menu_li">
                                        <form class="form" action="/logout" method="post">
                                        @csrf
                                        <a href="#" onclick="this.closest('form').submit();return false;" class="logout">ログアウト</a>
                                        </form>
                                    </li>
                                    <li class="nav_menu_li"><a href="/myPage" class="nav_menu_li-a">マイページ</a></li>
                                    @if(Auth::user()->role > 99)
                                    <li class="nav_menu_li"><a href="/management" class="nav_menu_li-a">管理画面</a></li>
                                    @endif
                                    <li class="nav_menu_li"><a href="{{route('sell')}}" class="nav_menu_li-a">出品</a></li>
                                </ul>
                            </nav>
                            @else
                            <nav class="nav">
                                <ul class="nav_menu_ul">
                                    <li class="nav_menu_li"><a href="/login">ログイン</a></li>
                                    <li class="nav_menu_li"><a href="/register">会員登録</a></li>
                                    <li class="nav_menu_li"><a href="{{route('sell')}}">出品</a></li>
                                </ul>
                            </nav>
                            @endauth
                        </div>
                <nav class="header-utilities-nav">
                    <ul class="header-nav">
                        <li  class="search-checkbox"><label class="search-checkbox-label"><input type="checkbox">売約済みを含める</label></li>
                        <li class="header-nav__item">
                            <form action="{{route('search')}}" method="get" id="search">
                                <input type="text" name="name" onchange="this.form.submit()" placeholder="何をお探しですか？" class="search-input">
                            </form>
                        </li>
                        @if (Auth::check())
                        <li class="header-nav__item default">
                            <form class="form" action="/logout" method="post">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                        <li class="header-nav__item default">
                            <a class="header-nav__link header-utilities-a" href="/myPage">マイページ</a>
                        </li>
                        @if(Auth::user()->role > 99)
                        <li class="header-nav__item default">
                            <a class="header-nav__link header-utilities-a" href="/management">管理画面</a>
                        </li>
                        @endif
                        @endif
                        @unless (Auth::check())
                        <li class="header-nav__item default">
                            <form class="form" action="/login" method="get">
                                <button class="header-nav__button">ログイン</button>
                            </form>
                        </li>
                        <li class="header-nav__item default">
                            <a class="header-nav__link header-utilities-a" href="/register">会員登録</a>
                        </li>
                        @endunless
                        <li>
                            <div class="header__sell default"><a href="{{route('sell')}}" class="header__sell-a">出品</a></div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
    @yield('content')
    </main>
    <script>
    $(function() {

    var checkbox = $("input[type='checkbox']");
    checkbox.on("change", function() {
    if (checkbox.prop("checked")) {
        $('#search').attr('action',"{{route('searchAll')}}");
    } else {
        $('#search').attr('action',"{{route('search')}}");
    }
    });

    $(".nav_toggle").on("click", function () {
    $(".nav_toggle, .nav").toggleClass("show");
    });

    });
</script>
</body>
</html>