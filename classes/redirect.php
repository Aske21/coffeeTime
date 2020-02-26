<?php
#lakse je imati redirect classu nego pisati header funckiju
class Redirect{
    public static function to($location = null){
        if($location){
            if(is_numeric($location)){
                switch($location){
                    case 404:
                        header('HTTP 1.0 404 Not Found Error');
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }       
    }
}


?>