<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS);
//Show errors
//===================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//===================================

//Autoloader
require BASE_PATH.'vendor/autoload.php';

$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);
$route = $app->route;

//Had to define the base url here
function app_url($path = null){

    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];
    
    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath); 
    
    // output: localhost
    $hostName = $_SERVER['HTTP_HOST']; 
    
    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
    
    // return: http://localhost/myproject/
    return $protocol.$hostName.$pathInfo['dirname'] . (($path == null) ? '/' : '/' . $path);
}

//Instatiate controllers
use App\Controllers\PagesController;
$pages = new PagesController();

//Configured routes
$route->get('/', [$pages, 'index']);

//Google Login route
$route->get('/google', [$pages, 'login_google']);

//Facebook Login route
$route->get('/facebook', [$pages, 'login_facebook']);

$route->end();