<?php
require_once 'core/init.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' =>true),
            'password' => array('required' =>true)
        ));

        if($validation->passed()){
            //log user in
            $user = new User();
            $login = $user->login(Input::get('username'), Hash::make(Input::get('password')));

            if($login){
                $_SESSION['username']=Input::get('username');
                Redirect::to('profile.php');    
            } else{
                echo "<p class='label label-danger'>Sorry, logging in failed.</p><br><br>";
            }
        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

?>



<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/form.css">
    </head>
        <body>
        <div class="login-page">
            <div class="form">
            <form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" autocomplete="off">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" id="submitBtn" value="Log in">
</form>
            </div>
        </div>
        </body>
</html>