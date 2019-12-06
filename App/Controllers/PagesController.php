<?php

namespace App\Controllers;

use Jenssegers\Blade\Blade;

use Exception;
use App\Classes\Mailer;

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
            'login_link' => null,
            'mailer_info' => null,
        ];

        // init configuration
        $clientID = getenv('GOOGLE_ID');
        $clientSecret = getenv('GOOGLE_SECRET');
        $redirectUri = getenv('GOOGLE_AUTH_REDIRECT');

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

            //Begin email notification
            $mailer = new Mailer($email, $name, 'Google Account');
            $data['mailer_info'] = $mailer->notify();

        // now you can use this profile info to create account in your website and make user logged in.
        } else {
            $data['login_link'] = $client->createAuthUrl();
        }

        //Render the template
        echo $this->blade->render('google', $data);

    }

    //Method to login with Facebook account
    public function login_facebook(){

        $data = [
            'title' => 'PHP TEST | Login Via Facebook',
            'is_logged_in' => false,
            'email' => null,
            'name' => null,
            'photo' => null,
            'login_link' => null,
            'mailer_info' => null,
            'is_notified' => false,
        ];

        //Begin session
        session_start();

        $fb = new \Facebook\Facebook([
            'app_id' => getenv('FACEBOOK_APP_ID'),
            'app_secret' => getenv('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
        ]);

        $helper = $fb->getRedirectLoginHelper();

        // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
        //   $helper = $fb->getRedirectLoginHelper();
        //   $helper = $fb->getJavaScriptHelper();
        //   $helper = $fb->getCanvasHelper();
        //   $helper = $fb->getPageTabHelper();

        try {

            if(isset($_SESSION['facebook_access_token'])) {
                $accessToken = $_SESSION['facebook_access_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        //Check access token
        if(isset($accessToken)) {

            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {

                // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                // OAuth 2.0 client handler
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // setting default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

            }

            //This means that we are now logged-in and is redirected
            if(isset($_GET['code'])) {
                if(!isset($_SESSION['is_logged_in_fb'])){
                    $_SESSION['is_logged_in_fb'] = true;
                }
                $data['is_notified'] = true;
            }

            /**
             * Getting basic info about user
             */
            try {
                
                //Get profile info
                $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
                $profile = $profile_request->getGraphUser();
                $fbfullname = $profile->getProperty('name');
                $fbemail = $profile->getProperty('email');

                //Get profile photo
                $requestPicture = $fb->get('/me/picture?redirect=false&height=200'); //getting user picture
                $picture = $requestPicture->getGraphUser();

                //Save the user nformation in session variable
                $_SESSION['fb_name'] = $fbfullname;
                $_SESSION['fb_email'] = $fbemail;
                $_SESSION['fb_photo'] = $picture;

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                // redirecting user back to app login page
                header('Location: ' . app_url('facebook'));
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

        }

        //Define the login url
        $data['login_link'] = $helper->getLoginUrl('http://localhost/php-test/facebook', ['email']);

        //Define the variables
        $data['name'] = (isset($_SESSION['fb_name']) ? $_SESSION['fb_name'] : null );
        $data['email'] = (isset($_SESSION['fb_email']) ? $_SESSION['fb_email'] : null );
        $data['photo'] = (isset($_SESSION['fb_photo']) ? $_SESSION['fb_photo'] : null );
        $data['is_logged_in'] = (isset($_SESSION['is_logged_in_fb']) ? $_SESSION['is_logged_in_fb'] : false );

        //Begin email notification
        if($data['is_notified']){
            $mailer = new Mailer($data['email'], $data['name'], 'Facebook Account');
            $data['mailer_info'] = $mailer->notify();
        }

        /**
         * For logging out
         */
        if(isset($_GET['logout'])){
            $url = 'https://www.facebook.com/logout.php?next=' . getenv('FACEBOOK_APP_REDIRECT') . '&access_token='. (isset($_SESSION['facebook_access_token']) ? $_SESSION['facebook_access_token'] : '');
            session_destroy();
            header('Location: ' . $url);
        }

        //Render the template
        echo $this->blade->render('facebook', $data);

    }

}