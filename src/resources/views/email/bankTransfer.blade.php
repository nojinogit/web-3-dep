@component('mail::message')
{{$user->name}}さん<br>
以下の口座に{{$item->price}}円を5日以内にご入金ください。<br>
<br>
銀行名：{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->bank_name }}<br>
支店名：{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->branch_name }}<br>
口座種別：{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->account_type }}<br>
口座番号：{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->account_number }}<br>
名義：{{ $nextAction->display_bank_transfer_instructions->financial_addresses[0]->zengin->account_holder_name }}<br>
<br>
宜しくお願い致します。
@endcomponent