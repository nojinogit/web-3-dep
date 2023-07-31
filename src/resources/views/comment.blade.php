@extends('layouts.layouts')

@section('title','comment')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item item-wrap">
            <div class="item-wrap__item">
                <img src="{{asset($item->path)}}" alt="" class="item-wrap__item-eyecatch">
            </div>
            <div class="detail">
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
                                <button type="submit" class="favorite_button">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            @else
                            <form class="favoriteItem storeOrigin{{$item->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="favorite_button">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            @endif
                            <form class="favoriteDelete delete{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit"  class="favorite_button">
                                    <img src="{{ asset('svg/yellow.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                            <form class="favoriteItem store{{$item->id}} none">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="item_id" value="{{$item->id}}">
                                <button type="submit" class="favorite_button">
                                    <img src="{{ asset('svg/clear.svg')}}" alt="お気に入り" class="icon">
                                </button>
                            </form>
                        @endauth
                    </div>
                    <div class="comment">
                        <div><form action="{{route('comment',['id' => $item->id])}}" method="get" name="id">
                            <button class="favorite_button"><img src="{{ asset('svg/fukidasi.svg')}}" alt="コメント" class="icon"></button>
                            </form></div>
                    </div>
                </div>
                <div class="count">
                    <div class="favorite-count">{{$favoriteCount}}</div>
                    <div class="comment-count">{{$commentCount}}</div>
                </div>
                <div class="comment-wrap">
                    <div class="review-main">
                        @foreach($comments as $comment)
                        <div class="review-user">
                            @if($comment->user->path!=null)
                            <div class="review-user-imgbox">
                                <img src="{{asset($comment->user->path)}}" alt="" class="review-user-imgbox-img">
                            </div>
                            @endif
                            @if($comment->user->path==null)
                            <div class="review-user-imgbox">
                                <img src="{{asset('storage/sample/noimage.jpg')}}" alt=""  class="review-user-imgbox-img">
                            </div>
                            @endif
                            <p class="review-user-p">{{$comment->user->name}}</p>
                            <p class="review-user-p">{{$comment->updated_at}}</p>
                        </div>
                        <div class="comment-main">
                            <p class="comment-main-p">{{$comment->comment}}</p>
                        </div>
                        @if(Auth::user()->id==$comment->user_id)
                            <form action="{{route('commentDelete')}}" method="post">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{$comment->id}}" name="id">
                                <input type="hidden" value="{{$comment->item_id}}" name="item_id">
                                <button class="comment-delete">コメントを削除する</button>
                            </form>
                        @endif
                        @endforeach
                    </div>
                </div>
                <!--ペジネーション部分-->
                {!! $comments->withQueryString()->links('pagination::bootstrap-5') !!}
                <!--ペジネーション部分終わり-->
                <div class="comment-post">
                    <p>商品へのコメント</p>
                    <form action="{{route('commentAdd')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <textarea name="comment" id="" cols="20" rows="5" class="textarea"></textarea>
                        <button type="submit" id="button">
                        @authコメントする
                        @elseコメントにはログインが必要です
                        @endauth
                        </button>
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