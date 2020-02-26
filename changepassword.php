<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
       
        $validate = new Validate();
        $validation = $validate->check($_POST,array(
            'current_password' =>array(
                'required' => true,
                'min' => 6,
            ),
            'new_password' =>array(

            ),
        ));
    }
}


?>