<?php

namespace App\Controllers;

use Jenssegers\Blade\Blade;

use Exception;

class PagesController {

    public function __construct(){
        $this->blade = new Blade(BASE_PATH . 'App\Views', BASE_PATH . 'App\Cache');
    }

    public function index(){

        $data = [
            'title' => 'PHP TEST | Index',
        ];

        //Render the template
        echo $this->blade->render('index', $data);

    }

    //Method to login with Google account
    public function login_google(){

        $data = [
            'title' => 'PHP TEST | Login Via Google',
            'is_logged_in' => false,
            'email' => null,
            'name' => null,
            'login_link' => null
        ];

        // init configuration
        $clientID = '867931384017-e0qpdjism74ct0ababuae92n2ecdpvg2.apps.googleusercontent.com';
        $clientSecret = 'MZ4JsMeNI1VskODy4hmr6t4d';
        $redirectUri = 'http://localhost/PHP-TEST/google/';

        // create Client Request to access Google API
        $client = new \Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        // authenticate code from Google OAuth Flow
        if(isset($_GET['code'])) {

            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // get profile info
            $google_oauth = new \Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();
            $email =  $google_account_info->email;
            $name =  $google_account_info->name;

            $data['is_logged_in'] = true;
            $data['email'] = $email;
            $data['name'] = $name;

        // now you can use this profile info to create account in your website and make user logged in.
        } else {
            $data['login_link'] = $client->createAuthUrl();
        }

        //Render the template
        echo $this->blade->render('google', $data);

    }

}