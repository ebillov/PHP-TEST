@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="container">

        <div class="row mt-5 mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">
                <h4>Login Via Service Providers Below (Demo)</h4>
                <hr>
                <ul class="nav justify-content-center">
                    <li class="nav-item mr-4"><a href="{{ app_url('google') }}" class="btn btn-light">Google Login Demo</a></li>
                    <li class="nav-item"><a href="{{ app_url('facebook') }}" class="btn btn-light">Facebook Login Demo</a></li>
                </ul>
            </div>

            <div class="col-md-3"></div>
        </div>

    </div>

</div>

@endsection