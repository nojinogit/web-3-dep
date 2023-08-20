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
        <h2>商品検索</h2>
        <form action="{{route('itemSearch')}}" method="get" class="default">
            <div class="main__search--step">
                <table class="table">
                <tr>
                    <th>商品名・タグ名</th>
                </tr>
                <tr>
                        <td><input type="text" name="name"></td>
                        <td><input type="submit" value="検索"></td>
                </tr>
                </table>
            </div>
        </form>
        <form action="{{route('itemSearch')}}" method="get" class="responsive">
            <div class="main__search--step-responsive">
                    <div class="main__search--step-title-responsive">
                        商品名・タグ名
                    </div>
                    <div  class="main__search--step-input-responsive">
                        <input type="text" name="name">
                    </div>
            </div>
            <div class="main__search--submit">
                <input type="submit" value="検索">
            </div>
        </form>
        <h2>送金検索</h2>
        <form action="{{route('proceed')}}" method="get" class="default proceed">
            <div class="main__search--step">
                <table class="table">
                <tr>
                    <th>お名前</th>
                    <th>メールアドレス</th>
                    <th>送金残高</th>
                </tr>
                <tr>
                        <td><input type="text" name="name"></td>
                        <td><input type="email" name="email"></td>
                        <td>
                            <label class="search-checkbox-label"><input type="checkbox" class="onlyPayment">残高有に限る</label>
                        </td>
                        <td><input type="submit" value="検索"></td>
                </tr>
                </table>
            </div>
        </form>
        <form action="{{route('proceed')}}" method="get" class="responsive proceed">
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
                    <div  class="main__search--step-input-responsive">
                        <input type="email" name="email">
                    </div>
                    <div class="main__search--step-title-responsive">
                        送金残高
                    </div>
                    <div  class="main__search--step-input-responsive">
                        <label class="search-checkbox-label"><input type="checkbox" class="onlyPayment">残高有に限る</label>
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
                        @if($account->id==Auth::user()->id)
                        <td><button type="button">自分の削除はできません</button></td>
                        @else
                        <td><button type="submit">アカウントを削除</button></td>
                        @endif
                    </form>
                    @if($account->role==1)
                    <form  method="POST" action="{{route('accountRole')}}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td><button type="submit">管理者権限を<span class="role-put">追加</span>する</button></td>
                    </form>
                    @endif
                    @if($account->role==100)
                    @if($account->id==Auth::user()->id)
                    <td><button type="button">自分の権限設定はできません</button></td>
                    @else
                    <form  method="POST" action="{{route('accountRoleDelete')}}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="id" value="{{$account->id}}">
                        <td><button type="submit">管理者権限を<span class="role-delete">削除</span>する</button></td>
                    </form>
                    @endif
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endisset

    @isset($items)
    <div class="account--table">
        <h2>商品一覧</h2>
        <div>
            <table class="table">
                <tr>
                    <th>商品名</th>
                    <th>出品者</th>
                    <th>購入者</th>
                    <th>売約記録</th>
                    <th>発送記録</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <form  method="get" action="{{route('detail',['id' => $item->id])}}">
                        <td class="item-item">{{$item->name}}</td>
                        <td class="item-item">{{$item->user->name}}</td>
                        <td class="item-item">
                            @unless($item->purchases->isEmpty())
                            @foreach($item->purchases as $purchase)
                            <div class="item-item">{{$purchase->user->name}}</div>
                            @endforeach
                            @endunless
                            @if($item->purchases->isEmpty())
                            <div class="item-item">-</div>
                            @endif
                        </td>
                        <td class="item-item">
                            @unless($item->purchases->isEmpty())
                            @foreach($item->purchases as $purchase)
                            <div class="item-item">{{$purchase->created_at}}</div>
                            @endforeach
                            @endunless
                            @if($item->purchases->isEmpty())
                            <div class="item-item">-</div>
                            @endif
                        </td>
                        <td class="item-item">
                            @unless($item->purchases->isEmpty())
                            @foreach($item->purchases as $purchase)
                            @if($purchase->send)
                            <div class="item-item">{{$purchase->send}}</div>
                            @else
                            <div class="item-item">-</div>
                            @endif
                            @endforeach
                            @endunless
                            @if($item->purchases->isEmpty())
                            <div class="item-item">-</div>
                            @endif
                        </td>
                        <td><button type="submit">商品詳細へ</button></td>
                    </form>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endisset

    @isset($proceedUsers)
    <div class="account--table">
        <h2>アカウント別送金一覧</h2>
        <div>
            <table class="table">
                <tr>
                    <th>お名前</th>
                    <th>送金口座</th>
                    <th>送金残高</th>
                </tr>
                @foreach($proceedUsers as $proceedUser)
                <tr>
                    <form  method="POST" action="{{route('proceedComplete')}}">
                        @method('put')
                        @csrf
                        <input type="hidden" name="user_id" value="{{$proceedUser->id}}">
                        <td class="proceed-item">{{$proceedUser->name}}</td>
                        <td class="proceed-item">{{$proceedUser->bank}} {{$proceedUser->bank_branch}} {{$proceedUser->bank_type}} {{$proceedUser->bank_number}}</td>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($proceedUser->proceeds as $proceed)
                            @unless($proceed->complete)
                            @php
                                $total += $proceed->proceed;
                            @endphp
                            @endunless
                        @endforeach
                        <td class="proceed-total">{{number_format($total)}}円</td>
                        <input type="hidden" name="total" value="{{$total}}">
                        @if($total > 0)
                            <td><button type="submit">送金完了</button></td>
                        @else
                            <td>残高なし</td>
                        @endif
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
                <p><textarea name="main" cols="100" rows="10" id="textarea"></textarea></p>
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

    $(function() {

    var checkboxes = $(".onlyPayment");
    checkboxes.on("change", function() {
    if ($(this).prop("checked")) {
        $(this).closest('form').attr('action',"{{route('proceedOnly')}}");
    } else {
        $(this).closest('form').attr('action',"{{route('proceed')}}");
    }
});


    });
</script>

@endsection