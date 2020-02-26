<?php
class User {
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');

    }

    public function update($fields = array(), $id = null){

        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }

        if(!$this->_db->update('users', $id, $fields)){
            throw new Exception('There was a problem with updating your username');
        }
            
    }

    #kreiranje usera
    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception ('Whoops! There was a problem');
        }
    }

    #pronalaženje usera i po Id-u ne samo po username
    public function find($user){

        $data = $this->_db->getPassword('users',$user);

        return $data;
    }

    
    public function login($username = null, $password = null){
        
        $user = $this->find($username);

        if($user[0]==$password)
            return true;
        else 
            return false;

    }

    public function logOut(){
        Session::delete($this->_sessionName);
    }
    
    public function data(){
        return $this->_data;
    }
    
    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }

    public function hasPermission($key){
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
        print_r($group->first());

    }
}




?>