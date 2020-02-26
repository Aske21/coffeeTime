<?php
require_once 'core/init.php'; 


if(Input::exists()){
    if(Token::check(Input::get('token'))){

        // echo "I have been run";
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2, 
                'max' => 20,
                #olakšavanje da ne bih morao da pisem query za provjeravanje da li username postoji 
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 8,
            ),
            'password_again' =>array(
                'required' =>true,
                'matches' => 'password',
            ),
        
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50,
            ),
            'lastname' => array(
                'required' => true,
                'min' => 3,
                'max' => 50,
            )    
        ));

        if($validation->passed()){
            $user = new User();

            //  echo $salt = Hash::salt(32);
            //  die();

            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password')),
                    // 'salt' => $salt,
                    'name' => Input::get('name'),
                    'last_name' => Input::get('lastname'),
                    'interestOne' => Input::get('interestOne'),
                    'interestTwo' => Input::get('interestTwo'),
                    'interestThree' => Input::get('interestThree'),
                    'interestFour' => Input::get('interestFour'),
                    'interestFive' => Input::get('interestFive'),
                    'date_joined' => date('Y-m-d H:i:s'),
                ));

                Session::flashmsg('home', 'You have been registered! Log in!');
                Redirect::to('login.php');
            } catch(Exception $e){
                die($e->getMessage());
            }
        }else{
            foreach($validation->errors() as $error){
                echo $error , '<br>';
            }
        }

    }
    
}

?>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/register.css">
    </head>
        <body>
        <form action="" method="post" class="form">
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo escape (Input::get('username'));?>" autocomplete="off">
                </div>

                <div class="field">
                    <label for="password">Type in a password</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="field">
                    <label for="password_again">Retype your password</label>
                    <input type="password" name="password_again" id="password_again">
                </div>

                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo escape (Input::get('name'));?>">
                </div>

                <div class="field">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" value="<?php echo escape (Input::get('lastname'));?>">
                </div>

                <div class="field">
                    <label for="interest">Enter Five of Yours Interests</label>
                    <input type="text" name="interestOne" style="text-align:center;" id="interestOne" placeholder="Interest One">
                    <input type="text" name="interestTwo" style="text-align:center;" id="interestTwo" placeholder="Interest Two">
                    <input type="text" name="interestThree" style="text-align:center;" id="interestThree" placeholder="Interest Three">
                    <input type="text" name="interestFour" style="text-align:center;" id="interestFour" placeholder="Interest Four">
                    <input type="text" name="interestFive" style="text-align:center;" id="interestFive" placeholder="Interest Five">
                </div>

                <div class="submitField">
                    <input type="submit" id="submitbtn" value="Register">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">

            </form>
        </body>
</html>