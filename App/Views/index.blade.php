@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="container">

        <div class="row mt-5 mb-4">
            <div class="col-12 text-center">
                <h3>Simple PHP TEST</h3>
                <h6 class="font-italic">Created by <a href="https://www.upwork.com/o/profiles/users/_~018e8957ede634f5bb/" class="font-weight-bold" target="_blank">Virson Ebillo</a></h6>
            </div>
        </div>
        <div class="row mt-5 mb-4">
            <div class="col-md-3"></div>

            <div class="col-md-6 text-center">

                <h4>Login Via Service Providers Below (Demo)</h4>
                <hr>
                <ul class="nav justify-content-center">
                    <li class="nav-item mr-4"><a href="{{ app_url('google') }}" class="btn btn-light">Google Login Demo</a></li>
                    <li class="nav-item"><a href="{{ app_url('facebook') }}" class="btn btn-light">Facebook Login Demo</a></li>
                </ul>
                <hr>
                <div class="alert alert-info mt-4" role="alert">
                    Purposely <b>did not</b> implemented the <b>Login Via LinkedIn</b> feature because I don't have a LinkedIn account yet.
                </div>

            </div>

            <div class="col-md-3"></div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8 text-center">
                <h4>Cron Job Demo</h4>
                <hr>
                <div class="text-left">
                    <p>Write a CRON job that will fetch all customer orders for the day with these specifications:</p>
                    <p>Send to :  director@companyname.com</p>
                    <p>Subject line:  Customer Orders as of {varDate}</p>
                    <p>Email body contains</p>
                    <p>Qty | Unit Price | Description| Amount</p>
                    <p>Total Amount (footer)</p>
                </div>
                <hr>
                <h4>Code Demo Screenshot</h4>
                <div class="alert alert-info mt-4" role="alert">
                    I don't have any working databse to fetch the query from. I just code this one for reference on how both the cron job and the file to be used for cron will look like. <b>You can also find this file</b> in the root folder with a filename: <b>fetch-orders.php</b>
                </div>
                <p>Please refer to the code screenshot below:</p>
                <div class="text-center">
                    <img class="img-fluid" src="{{ app_url('App/Assets/images/code.png') }}"/>
                </div>
            </div>

            <div class="col-md-2"></div>
        </div>

    </div>

</div>

@endsection