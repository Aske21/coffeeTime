<?php

include('database_connection.php');

$query = "SELECT * FROM users WHERE id='".$_SESSION['user_id']."'";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped" style="text-align:center;font-family:Josefin Sans;">
 <tr>
    <td bgcolor="#333";"><font color="white">Name</td>
    <td bgcolor="#333";"><font color="white">Last Name</td>
    <td bgcolor="#333";"><font color="white">Interest One</td>
    <td bgcolor="#333";"><font color="white">Interest Two</td>
    <td bgcolor="#333";"><font color="white">Interest Three</td>
    <td bgcolor="#333";"><font color="white">Interest Four</td>
    <td bgcolor="#333";"><font color="white">Interest Five</td>
 </tr>
';

foreach($result as $row) {
 $status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($row['id'], $connect);
 if($user_last_activity > $current_timestamp)
 {
  $status = '<span class="label label-success">Online</span>';
 }
 else
 {
  $status = '<span class="label label-danger" style="font-weight:500; padding:5px;">Offline</span>';
 }
 
 $output .= '
 <tr>
    <td>'.$row['name'].'</td>
    <td>'.$row['last_name'].'</td>
    <td>'.$row['interestOne'].'</td>
    <td>'.$row['interestTwo'].'</td>
    <td>'.$row['interestThree'].'</td>
    <td>'.$row['interestFour'].'</td>
    <td>'.$row['interestFive'].'</td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;

?>
