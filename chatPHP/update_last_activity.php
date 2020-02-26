<?php

require_once '../core/init.php';

include('database_connection.php');

$query = "UPDATE users SET last_activity = now() WHERE login_details_id = '".$_SESSION["login_details_id"]."'";

$statement = $connect->prepare($query);

$statement->execute();

?>
