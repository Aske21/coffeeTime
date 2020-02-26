<?php
require_once 'core/init.php';

$user = new User();
$user->logOut();
session_destroy();
Redirect::to('index.html');


?>