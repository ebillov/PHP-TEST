@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6">
                <h1 class="text-center">Login Via Google Account</h1>
                <hr>
                @if(!$is_logged_in)
                <a href="{{ $login_link }}" class="btn btn-light">Google Login</a>
                @endif
            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row text-center">
            <div class="col-12">
            </div>
        </div>

    </div>

</div>

@endsection