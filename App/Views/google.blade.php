@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">
                <h1>Login Via Google Account</h1>
                <hr>
                @if(!$is_logged_in)
                <a href="{{ $login_link }}" class="btn btn-light">Google Login</a>
                @endif
                <hr>
                <a href="{{ app_url() }}" class="text-decoration-none">Back to Home</a>
            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row text-center">
            <div class="col-12">
                @if($is_logged_in)
                <p>You are now logged in with your <b>Google Account</b>. The details of your account are shown below:</p>
                <p>An email was also sent with the provided email address below:</p>
                <p><b>Name:</b> {{ $name }}<b>Email Address:</b> {{ $email }}</p>
                <p><b>Reload this page</b> to try a different login service. <a href="{{ app_url('google') }}" class="text-decoration-none">Reload Page</a>.</p>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection