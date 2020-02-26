<?php

include('database_connection.php');

$query = "SELECT * FROM users WHERE id != '".$_SESSION['user_id']."' ";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped" style="text-align:center;font-family:Josefin Sans;">
 <tr>
    <td bgcolor="#333";"><font color="white">Username</td>
    <td bgcolor="#333";"><font color="white">Name</td>
    <td bgcolor="#333";"><font color="white">Last Name</td>
    <td bgcolor="#333";"><font color="white">Interest One</td>
    <td bgcolor="#333";"><font color="white">Interest Two</td>
    <td bgcolor="#333";"><font color="white">Interest Three</td>
    <td bgcolor="#333";"><font color="white">Interest Four</td>
    <td bgcolor="#333";"><font color="white">Interest Five</td>
    <td bgcolor="#333";"><font color="white">Status</td>
    <td bgcolor="#333";"><font color="white">Action</td>
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
    <td>'.$row['username'].' '.count_unseen_message($row['id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['id'], $connect).'</td>
    <td>'.$row['name'].'</td>
    <td>'.$row['last_name'].'</td>
    <td>'.$row['interestOne'].'</td>
    <td>'.$row['interestTwo'].'</td>
    <td>'.$row['interestThree'].'</td>
    <td>'.$row['interestFour'].'</td>
    <td>'.$row['interestFive'].'</td>
    <td>'.$status.'</td>
    <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;

?>
