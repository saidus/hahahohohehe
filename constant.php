<?php
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}

if(!defined('PS')){
    define('PS', PATH_SEPARATOR);
}


define('BASE_DIR', __DIR__);
define('SOURCE_DIR', BASE_DIR . DS . 'src');
define('LIBRARY_DIR', BASE_DIR . DS . 'lib');
define('APP_DIR', BASE_DIR . DS . 'app');
define('VIEW_DIR', BASE_DIR . DS . 'views');


define('STYLES_URL', BASE_URL . 'asset/styles/');