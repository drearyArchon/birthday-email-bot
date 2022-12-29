<?php
class BirthdayPromo{
 
    /** SET UP OBJECT PROPERTIES **/
    private $conn;
    private $table_name = "active_birthday_promo_codes";
 
    public $id;
    public $customer_id;
    public $promo_code;
    public $expiration_date;

    /** CONSTRUCTOR REQUIRES DATABASE CONNECTION TO INITIATE **/
    public function __construct($db){
        $this->conn = $db;

        /** CONSTRUCTOR AUTOMATICALLY GENERATES A RANDOM CODE AND SETS THE PROMO'S EXPIRY DATE **/
        /** THESE CAN BE CHANGED IF NEEDED **/
        $this->promo_code = uniqid();
        $this->expiration_date = date("Y-m-d");
    }

    function createPromo(){
        /** CREATES A NEW PROMO **/

        /** CHECK TO MAKE SURE PROMO DOESN'T ALREADY EXIST **/
        if($this->isAlreadyExist()){
            return false;
        }
        
        /** IF PROMO DOESN'T EXIST, CREATE A NEW ONE **/
        try{
            $query = "INSERT INTO `active_birthday_promo_codes` (`customer_id`, `promo_code`, `expiration_date`) VALUES (:customer_id, :promo_code, :expiration_date)";
        
            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
            $this->promo_code=htmlspecialchars(strip_tags($this->promo_code));
            $this->expiration_date=htmlspecialchars(strip_tags($this->expiration_date));
        
            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":promo_code", $this->promo_code);
            $stmt->bindParam(":expiration_date", $this->expiration_date);

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

    function getPromoByID(){
        /** RETRIEVE PROMO BY ID **/
        try{
            $query = "SELECT * FROM `active_birthday_promo_codes` WHERE `promo_id`=:id";

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

    function getAllPromos(){
        /** GET ALL PROMOS IN DATABASE **/
        try{
            $query = "SELECT * FROM `active_birthday_promo_codes`";

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

    function checkPromo(){
        /** CHECKS A PROMO THROUGH THE FOLLOWING: **/
        /** 1. USER'S ID **/
        /** 2. PROMO CODE **/
        /** 3. EXPIRY DATE **/
        /** THIS MAKES SURE THAT ONLY THE APPROPRIATE USER CAN USE A PROMO CODE, AND ONLY BEFORE THE PROMO EXPIRES **/
        try{
            $query = "SELECT * FROM `active_birthday_promo_codes` WHERE `customer_id`=:customer_id and `promo_code`=:promo_code and `expiration_date` >= curdate()";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
            $this->promo_code=htmlspecialchars(strip_tags($this->promo_code));
        
            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":promo_code", $this->promo_code);

            /** EXECUTE QUERY **/
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
            exit();
        }
    }

    function deletePromo(){
        /** DELETES A PROMO FROM THE DATABASE GIVEN AN ID **/
        /** USED TO REMOVE A PROMO AFTER IT IS USED **/
        try{
            $query = "DELETE FROM `active_birthday_promo_codes` WHERE `promo_id`=:promo_id";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->id=htmlspecialchars(strip_tags($this->id));    

            /** BIND VALUES **/
            $stmt->bindParam(":promo_id", $this->id);

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

    function deleteAllExpiredPromos(){
        /** DELETES ALL PROMOS THAT HAVE EXPIRED **/
        try{
            $query = "DELETE FROM `active_birthday_promo_codes` WHERE `expiration_date` < curdate()";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

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
        /** CHECKS IF THE USER ALREADY HAS A NON-EXPIRED PROMO **/
        try{
            $query = "SELECT * FROM `active_birthday_promo_codes` WHERE `customer_id`=:customer_id and `expiration_date`=:expiration_date";

            /** PREPARE QUERY **/ 
            $stmt = $this->conn->prepare($query);

            /** SANITIZE VALUES **/
            $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
            $this->expiration_date=htmlspecialchars(strip_tags($this->expiration_date));
        
            /** BIND VALUES **/
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":expiration_date", $this->expiration_date);

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