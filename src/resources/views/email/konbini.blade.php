@component('mail::message')
{{$user->name}}さん<br>
{{$item->price}}円をコンビニ決済にて5日以内にご入金ください。<br>
こちらのURLより支払手順をご確認下さい{{ $nextAction->konbini_display_details->hosted_voucher_url }}<br>
<br>
宜しくお願い致します。
@endcomponent