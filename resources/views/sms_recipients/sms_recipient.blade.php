
								
@foreach($sms_recipients as $sms_recipient)

				<div class="row card card-body">
				<div class="col-sm-12">
								<p>Name: {{$sms_recipient->smsname}}</p>
								<p>Number: {{$sms_recipient->getNumber()}}</p>
								<p>Assigned channel: {{$sms_recipient->channel}}</p>
				</div>
				</div>
@endforeach
