@extends('layouts.layouts')

@section('title','payment')

@section('js')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

<h1>Next Action</h1>

<p>{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->account_holder_name }}</p>

@endsection