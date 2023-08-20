@component('mail::message')
{{$user->name}}さん<br>
本日売上金の{{number_format($total)}}円の振込処理が完了しました。<br>
今後もご利用をお待ちしております。
@endcomponent