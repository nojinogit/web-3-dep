@extends('layouts.layouts')

@section('title','index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="item-button">
            <form action="/"><button>おすすめ</button></form>
            @auth
            <form action="{{route('myList',['id' => Auth::user()->id])}}" method="get"><button>マイリスト</button></form>
            @endauth
        </div>
        <div class="flex__item shop-wrap">
            @foreach($items as $item)
            <div class="shop-wrap__item">
                <img src="{{asset($item->path)}}" class="shop-wrap__item-eyecatch">
                <div class="shop-wrap__item-content">
                    <div class="shop-wrap__item-top">
                        <div>
                            <form action="{{route('detail',['id' => $item->id])}}" method="get" name="id">
                            <button class="detail">{{$item->name}}</button>
                            </form>
                        </div>
                        <div>
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
                    </div>
                    
                    <div>
                        <p class="shop-wrap__item-content-tag">￥{{$item->price}}</p>
                    </div>
                    <div>
                        @foreach($item->categories as $category)
                        <p class="shop-wrap__item-content-tag">#{{$category->category}}</p>
                        @endforeach
                    </div>
                    
                </div>
            </div>
            @endforeach
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