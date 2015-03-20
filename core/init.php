<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 2/23/2015
 * Time: 3:48 PM
 */

session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host'      => '127.0.0.1',
        'username'  => 'general',
        'password'  => 'general',
        'db'        => 'login_oop'
    ),
    'remember'  => array(
        'cookie_name'   => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name'  => 'user',
        'token_name'    => 'token'
    )
);

spl_autoload_register(function($class){
   require_once 'classes/'.$class.'.php';
});

require_once 'functions/sanitize.php';
require_once 'functions/general.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
    $hash = Cookie::get(Config::get('remember/cookie_name'));

    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

