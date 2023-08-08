@component('mail::message')
{{$purchase_data->user->name}}さん<br>
{{$purchase_data->item->name}}が{{$purchase_data->item->user->name}}さんより発送されました。<br>
受け取りをよろしくお願いします。
@endcomponent