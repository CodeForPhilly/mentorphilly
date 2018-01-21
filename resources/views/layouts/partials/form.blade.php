@extends('layouts.baremaster')


@section('content')



      <div class="container">

      <div class="row">

        <div class="col-sm-8 blog-main">

        	<h1>Enter number</h1>

@include('layouts.partials.errors')

<div class="form-group">
<form method="POST" action="/newnumber">

{{-- include csrf field in all of our forms for authentication --}}
	 {{ csrf_field() }}


  <div class="form-group">
    <label for="number">Number: </label>
    <input type="text" class="form-control" id="number" name="number" required >
  </div>




<div class="form-group">

  <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>

</div> {{-- container --}}

</div> {{-- col --}}
</div> {{-- row --}}

@endsection 