<?php
class Database{

    /** SET UP OBJECT PROPERTIES **/
    /** CREDENTIALS ARE SET UP FOR TESTING PURPOSES **/
    /** CREDENTIALS SHOULD BE CHANGED TO FIT PRODUCTION VERSION **/
    private $host = "localhost";
    private $db_name = "sayakaya_db";
    private $username = "birthday_bot";
    private $password = "happybirthday";
    public $conn;

    /** CONSTRUCTOR SEtS UP DATABASE CONNECTION TO INITIATE **/
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql: host=". $this->host .";dbname=". $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
 
        return $this->conn;
    }
    public function closeConnection(){
        $this->conn = null;
    }
}
?>