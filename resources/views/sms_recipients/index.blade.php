@extends('layouts.master')

@section('content')




	
@foreach($sms_recipients as $sms_recipient)
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	
		@include('sms_recipients.sms_recipient')
</div>
</div>
@endforeach


@endsection