@extends('layouts.layouts')

@section('title','index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <div class="container">
        @isset($recommendations)
        <div class="recommendations">
            {{$recommendations}}
        </div>
        @endisset
        <div class="item-button">
            <form action="{{route('recommendation')}}"><button class="item-button-inner">おすすめ</button></form>
            @auth
            <form action="{{route('myList',['id' => Auth::user()->id])}}" method="get"><button  class="item-button-inner">マイリスト</button></form>
            @endauth
        </div>
        <div class="flex__item item-wrap">
            @foreach($items as $item)
            <div class="item-wrap__item">
                <img src="{{asset($item->path)}}" class="item-wrap__item-eyecatch">
                @unless($item->purchases->isEmpty())
                <div class="soldOut">売約済</div>
                @endunless
                <div class="item-wrap__item-content">
                    <div class="item-wrap__item-top">
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
                                    <button type="submit" class="icon-button">
                                        <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                    </button>
                                </form>
                                @else
                                <form class="favoriteItem storeOrigin{{$item->id}}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="item_id" value="{{$item->id}}">
                                    <button type="submit"  class="icon-button">
                                        <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                    </button>
                                </form>
                                @endif
                                <form class="favoriteDelete delete{{$item->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="item_id" value="{{$item->id}}">
                                    <button type="submit"  class="icon-button">
                                        <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                    </button>
                                </form>
                                <form class="favoriteItem store{{$item->id}} none">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="item_id" value="{{$item->id}}">
                                    <button type="submit"  class="icon-button">
                                        <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                    </button>
                                </form>
                        @endauth
                        </div>
                    </div>
                    <div>
                        <p class="item-wrap__item-content-tag">￥{{$item->price}}</p>
                    </div>
                    <div>
                        @foreach($item->categories as $category)
                        <p class="item-wrap__item-content-tag">#{{$category->category}}</p>
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
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>
@endsection