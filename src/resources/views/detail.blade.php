@extends('layouts.layouts')

@section('title','detail')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
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
                    <a href="/comment">💭</a>
                </div>
                <form action="" method="post">
                    @csrf
                    <button type="submit" id="button">
                        @auth購入する
                        @else購入にはログインが必要です
                        @endauth
                    </button>
                </form>
                <h2>商品説明</h2>
                <p>カラー：グレー</p>
                <h2>商品の情報</h2>
                <div  class="category">
                    <p>カテゴリー</p>&emsp;
                    <div class="category-inner">
                        <p>洋服</p>
                    </div>
                    <div class="category-inner">
                        <p>メンズ</p>
                    </div>
                </div>
                <div  class="condition">
                    <p>商品の状態</p>&emsp;
                    <p>新品</p>
                </div>
            </div>
        </div>
    </div>


@endsection