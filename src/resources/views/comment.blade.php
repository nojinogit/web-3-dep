@extends('layouts.layouts')

@section('title','comment')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css')}}">
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
                <div>
                    <div class="review-main">
                        <div class="review-user">
                            <div class="review-user-img">
                                <img src="storage/sample/ドラム式洗濯機.jpg" alt="">
                            </div>
                            <p>洗濯機おじさん</p>
                            <p>2023年7月15日</p>
                        </div>
                        <div class="comment-main">
                            <p>コメント本文</p>
                        </div>
                    </div>
                </div>
                <div class="comment-post">
                    <p>商品へのコメント</p>
                    <form action="{{route('commentAdd')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <textarea name="comment" id="" cols="30" rows="10"></textarea>
                        <button type="submit" id="button">コメントを送信する</button>
                    </form>
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
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>

@endsection