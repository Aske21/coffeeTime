<?php

session_start();

#globalna varijabla koja uz pomoću nizova sadrži postavke
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'coffee1'
    ),
    'rememberme' => array(
        'cookie' => 'hash',
        'cookie_expiredate' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

#funkcija koja mi je pomogla da smanjim linije koda jer bi inače morao requirati neke fajlove više puta
#requiram samo fajlove koji mi trebaju i note to self spl(standard php library)
spl_autoload_register(function($class){
    require_once __DIR__.'/../classes/' . $class . '.php';
});

require_once __DIR__.'/../functions/sanitize.php';


?>