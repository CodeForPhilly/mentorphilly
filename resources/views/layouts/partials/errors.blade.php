
@if(count($errors))

<div class="row">
	<div class="col-sm-12 alert-danger">

		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>

	</div>
</div>

@endif