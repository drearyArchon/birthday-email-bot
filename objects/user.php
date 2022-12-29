<?php
class User{
 
    /** SET UP OBJECT PROPERTIES **/
    private $conn;
    private $table_name = "customers";
 
    public $id;
    public $name;
    public $birthday;
    public $age;
    public $email;
    public $phone_num;
    public $verified;

    /** CONSTRUCTOR REQUIRES DATABASE CONNECTION TO INITIATE **/
    public function __construct($db){
        $this->conn = $db;
    }

    function createUser(){
        /** REGISTERS A NEW USER **/
        /** NEWLY CREATED USERS ARE NOT VERIFIED AND CANNOT RECIEVE BIRTHDAY PROMOS UNTIL THEY HAVE BEEN VERIFIED **/
    
        /** CHECK TO MAKE SURE PROMO DOESN'T ALREADY EXIST **/
        if($this->isAlreadyExist()){
            return false;
        }
        
        /** IF USER DOESN'T EXIST, CREATE A NEW ONE **/
        try{
            $query = "INSERT INTO `customers` (`name`, `birthday_date`, `age`, `email`, `phone_number`) VALUES (:name, :birthday_date, :age, :email, :phone_number)";
    
            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);
        
            /** SANITIZE VALUES **/
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->birthday_date=htmlspecialchars(strip_tags($this->birthday_date));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
        
            /** BIND VALUES **/
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":birthday_date", $this->birthday_date);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone_number", $this->phone_number);    

            /** EXECUTE QUERY **/
            if($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
    }

    function getUserByID(){
        /** RETRIEVE USER BY ID **/
        try{
            $query = "SELECT * FROM `customers` WHERE `customer_id`=:id";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->id=htmlspecialchars(strip_tags($this->id));

            /** BIND VALUES **/
            $stmt->bindParam(":id", $this->id);

            /** EXECUTE QUERY **/
            $stmt->execute();
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
        return $stmt;
    }

    function getAllUsers(){
        /** GET ALL USERS IN DATABASE **/
        try{
            $query = "SELECT * FROM `customers`";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** EXECUTE QUERY **/
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
        return $stmt;
    }

    function getVerifiedUsersByBirthdayDate($date){
        /** GET ALL USERS WHO ARE BOTH VERIFIED AND WHOSE BIRTHDAY IS ON THE GIVEN DATE **/
        try{
            $query = "SELECT * FROM `customers` WHERE DAY(`birthday_date`) = DAY(:date) AND MONTH(`birthday_date`) = MONTH(:date) AND `verified` = 1";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $date=htmlspecialchars(strip_tags($date));

            /** BIND VALUES **/
            $stmt->bindParam(":date", $date);

            /** EXECUTE QUERY **/
            $stmt->execute();
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
        return $stmt;
    }

    function verifyUserByID(){
        /** VERIFIES A USER, MAKING THEM ABLE TO RECIEVE BIRTHDAY PROMOS **/
        try{
            $query = "UPDATE `customers` SET `verified`=1 WHERE `customer_id`=:id";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);
            
            /** SANITIZE VALUES **/
            $this->id=htmlspecialchars(strip_tags($this->id));    

            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->id);

            /** EXECUTE QUERY **/
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
    }

    function deleteUser(){
        try{
            $query = "DELETE FROM `customers` WHERE `customer_id`=:id";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->id=htmlspecialchars(strip_tags($this->id));    

            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->id);

            /** EXECUTE QUERY **/
            if($stmt->execute()){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
    }
    
    function isAlreadyExist(){
        /** CHECKS IF A USER ACCOUNT ALREADY EXISTS **/
        try{
            $query = "SELECT * FROM `customers` WHERE `customer_id`=:customer_id and `name`=:name";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));

            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":name", $this->name);

            /** EXECUTE QUERY **/
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
    }
}
?>