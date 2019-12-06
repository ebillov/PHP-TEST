@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">
                <h4>Login Via Google Account</h4>
                <hr>
                @if(!$is_logged_in)
                <a href="{{ $login_link }}" class="btn btn-light">Login Via Google</a>
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
                <p><b>Name:</b> {{ $name }}</p>
                <p><b>Email Address:</b> {{ $email }}</p>
                <p><b>Reload this page</b> to try a different login service. <a href="{{ app_url('google') }}" class="text-decoration-none">Reload Page</a>.</p>
                @endif
                @if($mailer_info !== null)
                <hr>
                <h4>Email Sent Status:</h4>
                <div class="alert alert-info" role="alert">
                    {{ $mailer_info }}
                </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection