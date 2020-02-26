<?php
require_once 'core/init.php';

$user = new User();

if(!$user -> isLoggedIn){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username'=> array(
                'required' => true,
                'min' => 2,
                'max' => 40
            )
        ));

        if($validation->passed()){

            try{    
                $user->update(array(
                    'username' => Input::get('username')
                ));

                Session::flasmsg('home', 'Your username has been updated');
            }catch(Exception $e){
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

<form>
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo escape($user->data()->username); ?>">

        <input type="submit" value="update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </div>
</form>