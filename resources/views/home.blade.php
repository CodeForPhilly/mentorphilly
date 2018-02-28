@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>
                <div class="card-body">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('sms_saved'))
                        <div class="alert alert-success">
                            {{ session('sms_saved') }}
                        </div>
                    @endif

                    
                    <p><a href="/createrecipient"><button type="button" class="btn btn-primary">Add a mentee</button></a></p>

                     <p><a href="/index"><button type="button" class="btn btn-primary">All Mentees</button></a></p>

                </div>
            
        </div>
        </div>
    </div>
</div>
@endsection
