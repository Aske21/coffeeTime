<?php
include_once 'core/init.php';
include 'chatPHP/database_connection.php';

if($_SESSION['username']==NULL)
    Redirect::to('login.php');

    
	$user=$_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$user'";
    $statement = $connect->prepare($query);
    $statement->execute();
	$result = $statement->fetchAll();

    
    foreach($result as $row) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['last_name'] = $row['last_name'];
        $sub_query = "INSERT INTO login_details (user_id) VALUES ('".$row['id']."')";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();
    }
    

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My profile</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">    <link href="css/profile.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script src="https://kit.fontawesome.com/a691301a5f.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
</head>
<body>
	
    <nav class="navtop">
        <div class="userinfo">
            <h1>Welcome, <?php echo $_SESSION['username']?></h1>
        </div>
    
        <div class="logout">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">
    <br/>
    <br/>
    
        <div class="table-responsive">
            <h1 style="font-size:24px;font-family: 'Josefin Sans', sans-serif;font-weight: 1000;">Your Info</h1>
            <div id="current_user_details"></div>
            <div id="current_user_details_user_model_details"></div>
        </div>
    </div>

    <br/>   
    <br/>
    <div class="container">
    <br/>
    <br/>
    
    <div class="table-responsive">
        <h1 style="font-size:24px; margin-bottom:20px; font-family: 'Josefin Sans', sans-serif;font-weight: 1000;">All Users</h1>
        <div id="user_details"></div>
        <div id="user_model_details"></div>
    </div>
  </div>

</body>
</html>

<script>  

$(document).ready(function(){

    var lastuser=0;
    fetch_user();
    fetch_current_user();

	setInterval(function(){
        fetch_user();
        fetch_current_user();
        update_last_activity();
	}, 3000);
    
    // console.log(lastuser);

    setInterval(function(){
        fetch_user_chat_history(lastuser);
	}, 100);


    function fetch_user() {
        $.ajax({
        url:"chatPHP/fetch_user.php",
        method:"POST",
        success:function(data){
            $('#user_details').html(data);
        }
        })
    }

    function fetch_current_user() {
        $.ajax({
        url:"chatPHP/fetch_current_user.php",
        method:"POST",
        success:function(data){
            $('#current_user_details').html(data);
        }
        })
    }


    function update_last_activity() {
        $.ajax({
        url:"chatPHP/update_last_activity.php",
        success:function()
        {

        }
        })
    }

    function make_chat_dialog_box(to_user_id, to_user_name) {
        var modal_content = '<div id="user_dialog_'+to_user_id+'" style="rotate(180deg);" class="user_dialog" title="You have chat with '+to_user_name+'">';
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
        
        $('#user_model_details').html(modal_content);

    }


    $(document).on('click', '.start_chat', function(){
        var to_user_id = $(this).data('touserid');
        lastuser = to_user_id;
        var to_user_name = $(this).data('tousername');
        make_chat_dialog_box(to_user_id, to_user_name);
        $("#user_dialog_"+to_user_id).dialog({
        autoOpen:false,
        width:400
        });
        $('#user_dialog_'+to_user_id).dialog('open');
        $('#chat_message_'+to_user_id).emojioneArea({
            pickerPosition:"top",
            toneStyle: "bullet"
        });
        fetch_user_chat_history(to_user_id);
    });


    $(document).on('click keypress', '.send_chat', function(){
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_id).val();
        $.ajax({
            url:"chatPHP/insert_chat.php",
            method:"POST",
            data:{to_user_id:to_user_id, chat_message:chat_message},
            success:function(data) {
                $('#chat_message_'+to_user_id).val('');
                var element = $('#chat_message_'+to_user_id).emojioneArea();
                element[0].emojioneArea.setText('');
                $('#chat_history_'+to_user_id).html(data);
            }
        })

    });


    function fetch_user_chat_history(to_user_id) {
        $.ajax({
            url:"chatPHP/fetch_user_chat_history.php",
            method:"POST",
            data:{to_user_id:to_user_id},
            success:function(data){
                $('#chat_history_'+to_user_id).html(data);
            }
        })
    }


    function update_chat_history_data(){
        $('.chat_history').each(function(){
        var to_user_id = $(this).data('touserid');
        fetch_user_chat_history(to_user_id);
        });
        }

        $(document).on('click', '.ui-button-icon', function(){
            lastuser=0;
            scrollElement=0;
        $('.user_dialog').dialog('destroy').remove();
        });
    
        $(document).on('focus', '.chat_message', function(){
        var is_type = 'yes';
        $.ajax({
        url:"chatPHP/update_is_type_status.php",
        method:"POST",
        data:{is_type:is_type},
        success:function()
        {

        }
        })
    });


    $(document).on('blur', '.chat_message', function(){
        var is_type = 'no';
        $.ajax({
        url:"chatPHP/update_is_type_status.php",
        method:"POST",
        data:{is_type:is_type},
        success:function()
        {
            
        }
        })
    });
    

});  

</script>


