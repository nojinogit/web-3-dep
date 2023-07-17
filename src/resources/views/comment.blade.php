@extends('layouts.layouts')

@section('title','comment')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item shop-wrap">
            <div class="shop-wrap__item">
                <img src="storage/sample/ドラム式洗濯機.jpg" alt="" class="shop-wrap__item-eyecatch">
            </div>
            <div class="reserve">
                <h1>ドラム式洗濯機</h1>
                <p>パナソニック</p>
                <p>￥10,000</p>
                <div>
                    <a href="">★</a>
                    <a href="">💭</a>
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
                    <form action="">
                        @csrf
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                        <button type="submit" id="button">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection