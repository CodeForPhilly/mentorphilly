@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                   
      

      <div class="row">

        <div class="col-sm-8 blog-main">

            <h1>Add a Mentee</h1>

@include('layouts.partials.errors')

<div class="form-group">
 <form class="form-horizontal" method="POST" action="/storerecipient">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('smsname') ? ' has-error' : '' }}">
                            <label for="smsname" class="col-md-4 control-label">smsname</label>

                                <div class="col-md-6">
                                <input id="smsname" type="text" class="form-control" name="smsname" value="{{ old('smsname') }}" required autofocus>

                                @if ($errors->has('smsname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('smsname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
                            <label for="number" class="col-md-4 control-label">Number</label>

                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control" name="number" value="{{ old('number') }}" required>

                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('channel') ? ' has-error' : '' }}">
                            <label for="channel" class="col-md-4 control-label">channel</label>

                            <div class="col-md-6">
                                <input id="channel" type="text" class="form-control" name="channel" required>

                                @if ($errors->has('channel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('channel') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="channel-confirm" class="col-md-4 control-label">Confirm channel</label>

                            <div class="col-md-6">
                                <input id="channel-confirm" type="channel" class="form-control" smsname="channel_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>

</div> {{-- container --}}

</div> {{-- col --}}
</div> {{-- row --}}

@endsection 




                   


                   

