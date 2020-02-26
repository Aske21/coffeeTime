<?php
class Input{
    public static function exists($type = 'post'){
        switch($type){
            case 'post':
            #if not true -> false
                return (!empty($_POST)) ? true : false; 
            break;
            case 'get' :
                return (!empty($_GET)) ? true : false; 
            break; 
            default:
                return false; 
            break;
        }   
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        } else if(isset($_GET[$item])){
            return $_GET[$item]; 
        }
        # uzimamo u obzir da mora biti ispunjeno inace mora vratiti empty string
        return ''; 
    }
}


?> 