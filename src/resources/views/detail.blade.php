@extends('layouts.layouts')

@section('title','detail')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item item-wrap">
            <div class="item-wrap__item">
                <img src="{{asset($item->path)}}" alt="" class="item-wrap__item-eyecatch">
                @unless($item->purchases->isEmpty())
                @foreach($item->purchases as $purchase)
                @if($purchase->payment!==null && $purchase->deposited!==null && $purchase->send!==null)
                <div class="soldStatus end">発送済</div>
                @endif
                @if($purchase->payment!==null && $purchase->deposited!==null && $purchase->send==null)
                <div class="soldStatus send">発送待ち</div>
                @endif
                @if($purchase->payment!==null && $purchase->deposited==null && $purchase->send==null)
                <div class="soldStatus">入金待ち</div>
                @endif
                @endforeach
                @endunless
            </div>
            <div class="detail">
                <h1 class="detail__h1">{{$item->name}}</h1>
                <p class="p">{{$item->brand}}</p>
                <p class="p">￥{{ number_format($item->price) }}</p>
                <div class="favorite__comment">
                    <div class="favorite">
                        @auth
                            @php
                            $favorite=0;
                            if(!empty(App\Models\Favorite::where('user_id',Auth::user()->id)->where('item_id',$item->id)->first())){
                            $favorite++;
                            }
                            @endphp
                            @if($favorite==1)
                            <form class="favoriteDelete deleteOrigin{{$item->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit"  class="button">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            @else
                            <form class="favoriteItem storeOrigin{{$item->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="button">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            @endif
                            <form class="favoriteDelete delete{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="button">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            <form class="favoriteItem store{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="button">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                        @endauth
                        @guest
                            <button type="button" class="button">
                                <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                            </button>
                        @endguest
                    </div>
                    <div class="comment">
                        <div><form action="{{route('comment',['id' => $item->id])}}" method="get" name="id">
                            <button class="button"><img src="{{ asset('svg/fukidasi.svg')}}" alt="コメント" class="icon"></button>
                            </form></div>
                    </div>
                </div>
                <div class="count">
                    <div class="favorite-count">{{$favoriteCount}}</div>
                    <div class="comment-count">{{$commentCount}}</div>
                </div>
                @unless($item->purchases->isEmpty())
                    <div class="soldOut-message">
                            この商品は売約済みです
                    </div>
                @else
                @if (Auth::check())
                    @if(Auth::user()->id==$item->user_id)
                    <form action="{{route('withdraw',['id' => $item->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="decision-button">
                            出品を取り消す
                        </button>
                    </form>
                    @else
                    <form action="{{route('purchase',['id' => $item->id])}}" method="get">
                        <button type="submit" class="decision-button">
                            @auth購入する
                            @else購入にはログインが必要です
                            @endauth
                        </button>
                    </form>
                    @endif
                @endif
                @endunless
                <h2  class="detail__h2">商品説明</h2>
                <p class="p">{{$item->explanation}}</p>
                <h2 class="detail__h2">商品の情報</h2>
                <div class="category">
                    <p class="p">カテゴリー</p>&emsp;
                    @foreach($item->categories as $category)
                    <div class="category-inner">
                        <p class="category-inner-p p">{{$category->category}}</p>
                    </div>
                    @endforeach
                </div>
                <div  class="condition">
                    <p class="p">商品の状態</p>&emsp;
                    <p class="p">{{$item->condition}}</p>
                </div>
                @if (Auth::check())
                @unless($item->purchases->isEmpty())
                @foreach($item->purchases as $purchase)
                @if(Auth::user()->id==$item->user_id && $purchase->payment!==null && $purchase->deposited!==null && $purchase->send==null)
                    <div class="send-area">
                        <div class="send-box">
                            <p>発送先</p>
                            <p>郵便番号：{{$purchase->postcode}}</p>
                            <p>住所：{{$purchase->address}}</p>
                            <p>建物：{{$purchase->building}}</p>
                            <p>氏名：{{$purchase->user->name}}</p>
                            <p>速やかな発送のご協力を宜しくお願い致します。</p>
                            <form action="{{route('send')}}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="send-button">発送完了</button>
                            </form>
                        </div>
                    </div>
                @endif
                @endforeach
                @foreach($item->purchases as $purchase)
                @if(Auth::user()->id==$item->user_id && $purchase->payment!==null && $purchase->deposited!==null && $purchase->send!==null)
                    <div class="send-area">
                        <div class="send-box">
                            発送先<br><br>
                            郵便番号：{{$purchase->postcode}}<br>
                            住所：{{$purchase->address}}<br>
                            建物：{{$purchase->building}}<br>
                            氏名：{{$purchase->user->name}}<br>
                            <br>
                            <div class="thanks-message">
                                    発送ありがとうございました。
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
                @endunless
                @endif
            </div>
        </div>
    </div>
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.favoriteDelete').on('submit', function(event){
            event.preventDefault();
            const user_id=$(this).find('input[name="user_id"]').val();
            const item_id=$(this).find('input[name="item_id"]').val();
            $.ajax({
                url: "{{ route('favoriteDelete') }}",
                method: "delete",
                data: {user_id:user_id,item_id:item_id},
                dataType: "json",
            }).done(function(res){
                $('.deleteOrigin'+res.item_id).addClass('none');
                $('.delete'+res.item_id).addClass('none');
                $('.store'+res.item_id).removeClass('none');
                var favoriteCount = parseInt($('.favorite-count').text());
                $('.favorite-count').text(favoriteCount - 1);
                }).faile(function(){
                alert('通信の失敗をしました');
            });
        });

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.favoriteItem').on('submit', function(event){
            event.preventDefault();
            const user_id=$(this).find('input[name="user_id"]').val();
            const item_id=$(this).find('input[name="item_id"]').val();
            $.ajax({
                url: "{{ route('favoriteStore') }}",
                method: "POST",
                data: {user_id:user_id,item_id:item_id},
                dataType: "json",
            }).done(function(res){
                $('.storeOrigin'+res.item_id).addClass('none');
                $('.store'+res.item_id).addClass('none');
                $('.delete'+res.item_id).removeClass('none');
                var favoriteCount = parseInt($('.favorite-count').text());
                $('.favorite-count').text(favoriteCount + 1);
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>

@endsection