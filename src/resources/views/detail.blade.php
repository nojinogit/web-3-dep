@extends('layouts.layouts')

@section('title','detail')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item shop-wrap">
            <div class="shop-wrap__item">
                <img src="{{asset($item->path)}}" alt="" class="shop-wrap__item-eyecatch">
            </div>
            <div class="reserve">
                <h1>{{$item->name}}</h1>
                <p>{{$item->brand}}</p>
                <p>￥{{$item->price}}</p>
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
                                <button type="submit">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="heart">
                                </button>
                            </form>
                            @else
                            <form class="favoriteStore storeOrigin{{$item->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="heart">
                                </button>
                            </form>
                            @endif
                            <form class="favoriteDelete delete{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="heart">
                                </button>
                            </form>
                            <form class="favoriteStore store{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="heart">
                                </button>
                            </form>
                        @endauth
                    </div>
                    <div class="comment">
                        <div><form action="{{route('comment',['id' => $item->id])}}" method="get" name="id">
                            <button><img src="{{ asset('svg/fukidasi.svg')}}" alt="コメント" class="heart"></button>
                            </form></div>
                    </div>
                </div>
                <div class="count">
                    <div class="favorite-count">{{$favoriteCount}}</div>
                    <div class="comment-count">{{$commentCount}}</div>
                </div>
                <form action="{{route('purchase',['id' => $item->id])}}" method="get">
                    <button type="submit" id="button">
                        @auth購入する
                        @else購入にはログインが必要です
                        @endauth
                    </button>
                </form>
                <h2>商品説明</h2>
                <p>{{$item->explanation}}</p>
                <h2>商品の情報</h2>
                <div  class="category">
                    <p>カテゴリー</p>&emsp;
                    @foreach($item->categories as $category)
                    <div class="category-inner">
                        <p>{{$category->category}}</p>
                    </div>
                    @endforeach
                </div>
                <div  class="condition">
                    <p>商品の状態</p>&emsp;
                    <p>{{$item->condition}}</p>
                </div>
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
        $('.favoriteStore').on('submit', function(event){
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