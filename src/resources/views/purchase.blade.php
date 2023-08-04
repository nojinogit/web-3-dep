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
                        <p class="p">￥{{$item->price}}</p>
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
                <div class="flex__item  item-wrap__item-bottom">
                    <div>配達先</div>
                    <form action="{{route('address',['id' => $item->id])}}">
                        <button type="submit" class="address-update">変更する</button>
                    </form>
                </div>
                <div class="flex__item">
                    <p class="p">〒{{$user->postcode}}</p>
                    <p class="p">{{$user->address}}</p>
                    <p class="p">{{$user->building}}</p>
                    <p class="p">{{$user->name}}様</p>
                </div>
            </div>
            <div class="payment">
                <div class="payment-area">
                    <div class="payment-box">
                        <div  class="condition">
                            <p class="p">商品代金</p>&emsp;
                            <p class="p">￥{{$item->price}}</p>
                        </div>
                        <div  class="condition">
                            <p class="p">支払金額</p>&emsp;
                            <p class="p">￥{{$item->price}}</p>
                        </div>
                        <div  class="condition">
                            <p class="p">支払方法</p>&emsp;
                            <p id="payment-method-display" class="p">銀行振込</p>
                        </div>
                    </div>
                </div>
                <form action="{{route('bankTransfer')}}" method="post" class="transfer">
                @csrf
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="item_id" value="{{$item->id}}">
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
                            @if (session('error'))
                            <div class="alert alert-danger">
                            {{ session('error') }}
                            </div>
                            @endif
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

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="コンビニ払い"){
        $('form').attr('action',"{{route('konbini')}}");
        $('.credit').addClass('none');
        $('.transfer').removeClass('none');
    }
    });

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="銀行振込"){
        $('form').attr('action',"{{route('bankTransfer')}}");
        $('.credit').addClass('none');
        $('.transfer').removeClass('none');
    }
    });

    $('#payment-method').on('change',function(){
    var value=$(this).val();
    if(value=="クレジットカード"){
        $('.credit').removeClass('none');
        $('.transfer').addClass('none');
    }
    });
    });
</script>

@endsection