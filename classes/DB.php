<?php
#PDO konekcija na bazu (MYSQL)
#ovaj način smanjuje mogućnosti od SQL injections
class DB {
#underscore(_) služi kao pokazivač da je privatno
    private static $_instance = null;
    public $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    #mora biti privatna funkcija
    public function __construct() {
        try{
            $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
            
        }catch(PDOException $e){
            die($e->getMessage());
            
        }

        
    }

    #provjerava da li smo konektovani 
    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    #omogućava nam da pripremo sql querije
    public function query($sql, $params = array()) {
        $this-> error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)){
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount(); 
            }else{
                $this->_error = true;
            }
        }

        return $this;

    }

    public function action($action, $table, $where = array()) {
        if(count($where) === 3){
            $operators = array('=', '>' , '<', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} * FROM {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, array($value))-> error()){
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table,$where) {
        #Koristimo * da ne bi konstantno indicirali sta da vratimo 
        return $this->action('SELECT *', $table, $where );

    }
    
    public function getPassword($table,$user) {

        $sql = $this->_pdo->prepare("SELECT password FROM $table WHERE username   ='$user'");
        $sql->execute();
        $usersInfo = $sql->fetch();

        return $usersInfo;

    }

    public function getUsers($user) {

        $sql = $this->_pdo->prepare("SELECT * FROM users WHERE username !='$user'");
        $sql->execute();
        $usersInfo = $sql->fetchAll();
        
        return $usersInfo;

    }

    public function getUserID($user) {

        $sql = $this->_pdo->prepare("SELECT id FROM users WHERE username == '$user'");
        $sql->execute();
        $userID = $sql->fetch   ();
        
        return $userID;

    }


    public function delete($table,$where) {
        #Ista kao i get funkcija samo sto umjesto SELECT koristimo DELETE
        return $this->action('DELETE *', $table, $where );
    }
    
    public function insert($table, $fields = array()){
        $keys = array_keys($fields);
        $values = null; 
        #counter
        $x = 1;

        foreach($fields as $field){
            $values .=  "?";
            if($x < count($fields)){
                $values .= ', ';
            }
            $x++;

        }
        

        $sql = "INSERT INTO users (`" . implode ('`, `', $keys) . "`) VALUES ({$values})";

        if (!$this->query($sql, $fields)->error()){
            return true;

        } 
        return false; 
    }
    
    public function update($table, $id, $fields) {
        $set = ''; 
        $x = 1; 

        foreach($fields as $name => $value){
            $set .= "{$name} = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }

    $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}"; 

    if($this->query($sql, $fields)->error()){
        return true; 
    }

        return false;
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->_results()[0];
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }
}

 
?>