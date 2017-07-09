<?php
// start session
session_start();

// load config and constants
require_once(__DIR__. DIRECTORY_SEPARATOR . 'config.php');
require_once(__DIR__. DIRECTORY_SEPARATOR . 'constant.php');

// set error reporting level
if(ENVIRONMENT == 'local'){
    error_reporting(E_ALL);
    ini_set('display_errors', true);
}else{
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', false);
}

date_default_timezone_set(TIME_ZONE);

// load all helpers
require_once(SOURCE_DIR . DS . 'helpers' . DS . 'view.php');
require_once(SOURCE_DIR . DS . 'helpers' . DS . 'helper.php');
//require_once(implode(DS, [SOURCE_DIR, 'helpers', 'view.php']))''

$uri = trim($_SERVER['REQUEST_URI'], '/');
$cookieLifetime = time() + 604800; // aproximately 1 week;
setcookie('last_seen', time(), $cookieLifetime, '/');
setcookie('last_url', $uri, $cookieLifetime, '/');

$routes = require(APP_DIR . DS . 'routes.php');
$request = [
    'method' => strtolower($_SERVER['REQUEST_METHOD']),
    'uri' => $uri,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
    'data' => /**/$_REQUEST, //*/ $_GET + $_POST
];

/** @todo: resolve controller and method from request */

try{
    require APP_DIR . DS . 'controllers'. DS .'AuthController.php';
    switch($uri){
        case 'login':
            login($request);
            break;
        case 'register';
            register($request);
            break;
        case 'forgot-password':
            forgotPassword($request);
            break;
        default:
            throw new Exception(404);
    }
}catch(Exception $e){
    $code = $e->getMessage();
    switch ($code){
        case 404:
            header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
            break;
        case 403:
            header($_SERVER['SERVER_PROTOCOL'] . " 403 Forbiden");
            break;
    }

    $errorView = VIEW_DIR . DS . 'errors' . DS . "{$code}.phtml";
    if(file_exists($errorView)){
        require $errorView;
    }
}