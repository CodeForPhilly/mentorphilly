@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Mentees</div>
                <div class="card-body">
      

		@include('sms_recipients.sms_recipient')

				</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
