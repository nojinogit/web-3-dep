@extends('layouts.layouts')

@section('title','myPage')

@section('css')
<link rel="stylesheet" href="{{ asset('css/myPage.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="profile">
            <div class="profile-img">
                <img src="storage/sample/ビール.jpg" alt="">
            </div>
            <p>ビールおぢさん</p>
            <div class="profile-update">
                <a href="/profile">プロフィールの編集</a>
            </div>
        </div>
        <div class="merchandise-button">
            <button>出品した商品</button>
            <button>購入した商品</button>
        </div>
        <div class="flex__item shop-wrap">
            <div class="shop-wrap__item">
                <img src="storage/sample/ドラム式洗濯機.jpg" class="shop-wrap__item-eyecatch">
                <div class="shop-wrap__item-content">
                    <form action="/detail" method="get" name="id">
                        <button class="detail">ドラム式洗濯機</button>
                    </form>
                    <div>
                        <p class="shop-wrap__item-content-tag">￥10,000</p>
                    </div>
                    <div>
                        <p class="shop-wrap__item-content-tag">#</p>
                    </div>
                    <div class="shop-wrap__item-bottom">
                        @auth
                                @php
                                $favorite=0;
                                if(!empty(App\Models\Favorite::where('user_id',Auth::user()->id)->where('shop_id',$shop->id)->first())){
                                    $favorite++;
                                }
                                @endphp
                                @if($favorite==1)
                                <form class="favoriteDelete deleteOrigin{{$shop->id}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/red.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                @else
                                <form class="favoriteStore storeOrigin{{$shop->id}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/glay.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                @endif
                                <form class="favoriteDelete delete{{$shop->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/red.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                                <form class="favoriteStore store{{$shop->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->id}}">
                                    <button type="submit">
                                        <img src="{{ asset('svg/glay.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                        @endauth
                    </div>
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
            const shop_id=$(this).find('input[name="shop_id"]').val();
            $.ajax({
                url: "",
                method: "delete",
                data: {user_id:user_id,shop_id:shop_id},
                dataType: "json",
            }).done(function(res){
                $('.deleteOrigin'+res.shop_id).addClass('none');
                $('.delete'+res.shop_id).addClass('none');
                $('.store'+res.shop_id).removeClass('none');
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
            const shop_id=$(this).find('input[name="shop_id"]').val();
            $.ajax({
                url: "",
                method: "POST",
                data: {user_id:user_id,shop_id:shop_id},
                dataType: "json",
            }).done(function(res){
                $('.storeOrigin'+res.shop_id).addClass('none');
                $('.store'+res.shop_id).addClass('none');
                $('.delete'+res.shop_id).removeClass('none');
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>
@endsection