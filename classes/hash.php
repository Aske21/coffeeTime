<?php
#generisanje hashing algoritma
#salt omogućava veću sigurnost u hashing procesu jer uz dodatni hash dodaje random set karaktera uz hashovani password 
class Hash{
    public static function make($string){
        return hash('md5', $string );

    }

    // public static function salt($length){
    //     return mcrypt_create_iv($length);

    // }

    public static function unique() {
        return self::make(uniqid());
    }
}


?>