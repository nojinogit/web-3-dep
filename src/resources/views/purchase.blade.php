@extends('layouts.layouts')

@section('title','purchase')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
    <div class="container">
        <div class="flex__item item-wrap">
            <div class="item-wrap__item">
                <div class="item-wrap__item-main">
                    <div class="item-wrap__item-img">
                        <img src="{{asset($item->path)}}" alt="" class="item-wrap__item-eyecatch">
                    </div>
                    <div class="name__price-box">
                        <h1>{{$item->name}}</h1>
                        <p class="p-bold">￥{{$item->price}}</p>
                    </div>
                </div>
                <div class="flex__item item-wrap__item-bottom">
                    <div>支払方法</div>
                    <select name="" id="payment-method">
                        <option value="銀行振込">銀行振込</option>
                        <option value="クレジットカード">クレジットカード</option>
                        <option value="コンビニ払い">コンビニ払い</option>
                    </select>
                </div>
                @isset ($card_info)
                <div class="creditHistory none">
                    <input type="checkbox" id="reuse">
                    <label class="creditHistory-label">以前使ったクレジットカードを利用する</label>
                    <p>カードの種類: {{ $card_info->brand }}</p>
                    <p>カード番号: **** **** **** {{ $card_info->last4 }}</p>
                    <p>有効期限: {{ $card_info->exp_year }}年{{ $card_info->exp_month }}月</p>
                </div>
                @endisset
                <div class="flex__item point">
                    <div>ポイントを利用する　残高 {{$user->point}} ポイント</div>
                    <input type="number" class="point-input" id="point" min="0" max="{{$user->point}}" default="0">
                </div>
                <div class="flex__item  item-wrap__item-bottom">
                    <div>配達先</div>
                    <form action="{{route('address',['id' => $item->id])}}" method="get">
                        <button type="submit" class="address-update">変更する</button>
                    </form>
                </div>
                <div class="flex__item">
                    <p class="p-bold">〒{{$user->postcode}}</p>
                    <p class="p-bold">{{$user->address}}</p>
                    <p class="p-bold">{{$user->building}}</p>
                    <p class="p-bold">{{$user->name}}様</p>
                </div>
            </div>
            <div class="payment">
                <div class="payment-area">
                    <div class="payment-box">
                        <div  class="condition">
                            <p class="p-bold">商品代金</p>&emsp;
                            <p class="p-bold">￥{{$item->price}}</p>
                        </div>
                        <div  class="condition">
                            <p class="p-bold">利用ポイント</p>&emsp;
                            <p class="p-bold"><label id="use-point">0</label> ポイント</p>
                        </div>
                        <div  class="condition">
                            <p class="p-bold">支払金額</p>&emsp;
                            <p class="p-bold">￥<label id="total">{{$item->price}}</label></p>
                        </div>
                        <div  class="condition">
                            <p class="p-bold">獲得ポイント</p>&emsp;
                            <p class="p-bold"><label id="get-point">{{$item->price*0.01}}</label> ポイント</p>
                        </div>
                        <div  class="condition">
                            <p class="p-bold">支払方法</p>&emsp;
                            <p id="payment-method-display" class="p-bold">銀行振込</p>
                        </div>
                    </div>
                </div>
                <form action="{{route('bankTransfer')}}" method="post" class="transfer" id="transfer">
                @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="item_id" value="{{$item->id}}">
                    <input type="hidden" name="cash" value="{{$item->price}}" class="cash">
                    <input type="hidden" name="usePoint" value="0" class="use-point">
                    <input type="hidden" name="getPoint" value="{{floor($item->price*0.01)}}" class="get-point">
                    <input type="hidden" name="postcode" value="{{$user->postcode}}">
                    <input type="hidden" name="address" value="{{$user->address}}">
                    <input type="hidden" name="building" value="{{$user->building}}">
                    <input type="hidden" name="payment" id="payment-method-input" value="銀行振込">
                    <button type="submit" id="button">
                        購入する
                    </button>
                </form>
                <form action="{{route('credit')}}" method="post" class="credit none" id="setup-form">
                @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="item_id" value="{{$item->id}}">
                    <input type="hidden" name="cash" value="{{$item->price}}" class="cash">
                    <input type="hidden" name="usePoint" value="0" class="use-point">
                    <input type="hidden" name="getPoint" value="{{floor($item->price*0.01)}}" class="get-point">
                    <input type="hidden" name="postcode" value="{{$user->postcode}}">
                    <input type="hidden" name="address" value="{{$user->address}}">
                    <input type="hidden" name="building" value="{{$user->building}}">
                    <input type="hidden" name="payment" value="クレジットカード">
                    <div  class="none credit">
                        <input id="card-holder-name" type="text" placeholder="カード名義人" name="card-holder-name"/>
                        <div id="card-element"></div>
                    </div>
                    <button type="submit" id="card-button">
                        購入する
                    </button>
                </form>
                <form action="{{route('creditReuse')}}" method="post" class="creditReuse none" id="setup-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="item_id" value="{{$item->id}}">
                    <input type="hidden" name="cash" value="{{$item->price}}" class="cash">
                    <input type="hidden" name="usePoint" value="0" class="use-point">
                    <input type="hidden" name="getPoint" value="{{floor($item->price*0.01)}}" class="get-point">
                    <input type="hidden" name="postcode" value="{{$user->postcode}}">
                    <input type="hidden" name="address" value="{{$user->address}}">
                    <input type="hidden" name="building" value="{{$user->building}}">
                    <input type="hidden" name="payment" value="クレジットカード">
                    <button type="submit" id="card-button-Reuse">
                        購入する
                    </button>
                </form>
                <div class="form__error">
                @error('postcode')
                {{ $message }}
                @enderror
                </div>
                <div class="form__error">
                @error('address')
                {{ $message }}
                @enderror
                </div>
                <div class="form__error">
                @error('usePoint')
                {{ $message }}
                @enderror
                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
    const stripe = Stripe('<?php echo config('stripe.stripe_public_key'); ?>');
    const elements = stripe.elements();
    const cardElement = elements.create('card', {hidePostalCode: true,});
    cardElement.mount('#card-element');

    const cardButton = document.getElementById('card-button');

    cardButton.addEventListener('click', async (e) => {
    e.preventDefault();
    const { token, error } = await stripe.createToken(cardElement);

    if (error) {
        alert(error.message);
        return;
    }

    const form = document.getElementById('setup-form');
    const hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    form.submit();
    });
    </script>
    <script>
    $(function() {
    $('#payment-method').on('change',function(){
    $('#payment-method-display').text($(this).val());
    $('#payment-method-input').val($(this).val());
    });

    $('#point').on('input',function(){
    var value=$(this).val();
        $('#use-point').text(value);
        $('.use-point').val(value);
    });

    $('#point').on('input', function() {
        var point = parseInt($(this).val());
        var price = parseInt('{{$item->price}}');
        var total = price - point;
        var get = Math.floor(total * 0.01);
        $('#total').text(total);
        $('#get-point').text(get);
        $('.cash').val(total);
        $('.get-point').val(get);
    });

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="コンビニ払い"){
        $('#transfer').attr('action',"{{route('konbini')}}");
        $('.credit').addClass('none');
        $('.creditHistory').addClass('none');
        $('.transfer').removeClass('none');
    }
    });

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="銀行振込"){
        $('#transfer').attr('action',"{{route('bankTransfer')}}");
        $('.credit').addClass('none');
        $('.creditHistory').addClass('none');
        $('.transfer').removeClass('none');
    }
    });

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="クレジットカード"){
        $('.credit').removeClass('none');
        $('.creditHistory').removeClass('none');
        $('.transfer').addClass('none');
    }
    });

    var checkbox = $("#reuse");
    checkbox.on("change", function() {
    if (checkbox.prop("checked")) {
        $('.credit').addClass('none');
        $('.creditReuse').removeClass('none');
    } else {
        $('.credit').removeClass('none');
        $('.creditReuse').addClass('none');
    }
    });


    });
</script>

@endsection