@extends('layouts.layouts')

@section('title','management')

@section('css')
<link rel="stylesheet" href="{{ asset('css/management.css')}}">
@endsection

@section('content')

<main class="main">
    <div>
        <h1>
            アカウント管理
        </h1>
    </div>
    <div class="main__search">
        <h2>アカウント検索</h2>
        <form action="{{route('account')}}" method="get" class="default">
            <div class="main__search--step">
                <table class="table">
                <tr>
                    <th>お名前</th>
                    <th>メールアドレス</th>
                    <th>権限</th>
                </tr>
                <tr>
                        <td><input type="text" name="name"></td>
                        <td><input type="email" name="email"></td>
                        <td>
                            <select value="権限を選択してください" name="role">
                            <option value="">全権限</option>
                            <option value="100">管理者</option>
                            <option value="1">一般ユーザ</option>
                        </select>
                        </td>
                        <td><input type="submit" value="検索"></td>
                </tr>
                </table>
            </div>
        </form>
        <form action="{{route('account')}}" method="get" class="responsive">
            <div class="main__search--step-responsive">
                    <div class="main__search--step-title-responsive">
                        お名前
                    </div>
                    <div  class="main__search--step-input-responsive">
                        <input type="text" name="name">
                    </div>
                    <div class="main__search--step-title-responsive">
                        メールアドレス
                    </div>
                    <div class="main__search--step-input-responsive">
                        <input type="email" name="email">
                    </div>
                    <div class="main__search--step-title-responsive">
                        権限
                    </div>
                    <div class="main__search--step-input-responsive">
                        <select value="権限を選択してください" name="role">
                            <option value="">全権限</option>
                            <option value="100">管理者</option>
                            <option value="1">一般ユーザ</option>
                        </select>
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
    </div>

    @isset($accounts)
    <div class="account--table">
        <h2>アカウント一覧（メールアドレスをクリックにてメールフォーム開きます）</h2>
        <div>
            <table class="table">
                <tr>
                    <th>お名前</th>
                    <th>メールアドレス</th>
                    <th>権限</th>
                </tr>
                @foreach($accounts as $account)
                <tr>
                    <form  method="POST" action="{{route('accountDelete')}}">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td class="account-name">{{$account->name}}</td>
                        <td class="account-email">{{$account->email}}</td>
                        <td>
                            @if($account->role==100)
                            管理者
                            @elseif($account->role==1)
                            一般ユーザ
                            @endif
                        </td>
                        <td><button type="submit">アカウントを削除</button></td>
                    </form>
                    <form  method="POST" action="{{route('accountRole')}}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td><button type="submit">管理者権限を追加する</button></td>
                    </form>
                    <form  method="POST" action="{{route('accountRoleDelete')}}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td><button type="submit">管理者権限を削除する</button></td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endisset

    <div class="main__add--table none">
        <h2>メール送信</h2>
        @if (count($errors) > 0)
                <ul class="error">
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
                </ul>
                @endif
            <div id="time"></div>
                @if(session('message'))
                <div class="message">
                    <div class="message__success">
                        <p class="message__success--p" id="session">{{session('message')}}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="mail-area">
            <form  method="POST" action="{{route('contactMail')}}" >
                @csrf
                <p>名前</p>
                <p><input type="text" name="name" class="name"></p>
                <p>メールアドレス</p>
                <p><input type="email" name="email" class="email"></p>
                <p>タイトル</p>
                <p><input type="text" name="title"></p>
                <p>本文</p>
                <p><textarea name="main" cols="100" rows="10"></textarea></p>
                <p><button type="submit">送信</button></p>
            </form>
        </div>
    </div>

</main>
<script>
    $(function() {
    $('.account-email').on('click',function(){
    $('.main__add--table').removeClass('none');
    $('.email').val($(this).text());
    var name = $(this).siblings('.account-name').text();
    $('.name').val(name);
    });
    });
</script>

@endsection