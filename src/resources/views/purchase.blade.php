@extends('layouts.layouts')

@section('title','purchase')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item shop-wrap">
            <div class="shop-wrap__item">
                <div  class="shop-wrap__item-main">
                    <div class="shop-wrap__item-img">
                        <img src="storage/sample/ドラム式洗濯機.jpg" alt="" class="shop-wrap__item-eyecatch">
                    </div>
                    <div>
                        <p>ドラム式洗濯機</p>
                        <p>￥10,000</p>
                    </div>
                </div>
                <div class="flex__item shop-wrap__item-bottom">
                    <div>支払方法</div>
                    <a href="">変更する</a>
                </div>
                <div class="flex__item  shop-wrap__item-bottom">
                    <div>配達先</div>
                    <a href="/address">変更する</a>
                </div>
            </div>
            <div class="payment">
                <div class="reserve">
                    <div class="payment-box">
                        <div  class="condition">
                            <p>商品代金</p>&emsp;
                            <p>￥10,000</p>
                        </div>
                        <div  class="condition">
                            <p>支払金額</p>&emsp;
                            <p>￥10,000</p>
                        </div>
                        <div  class="condition">
                            <p>支払方法</p>&emsp;
                            <p>コンビニ払い</p>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                @csrf
                <button type="submit" id="button">
                    購入する
                </button>
            </form>
            </div>
        </div>
    </div>


@endsection