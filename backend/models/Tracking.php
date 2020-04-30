<?php

class Tracking {
    private $conn;
    private $table_name = "tracking";

    public $id;
    public $product;
    public $release_date;
    public $delivery_date;
    public $origin;
    public $tracking_number;
    public $receiver_name;
    public $receiver_address;
    public $receiver_phone;
    public $destination;
    public $current_location;
    public $shipping_status;
    public $receiver_email;
    public $shipper_name;
    public $shipper_email;
    public $shipper_phone;
    public $weight;

    // constructor with $db as database connection
    public function __construct($db){
            $this->conn = $db;
    }

    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single()
    {
         // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE tracking_num = ?";

            // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind tracking_num of tracking item to be retrieved
        $stmt->bindParam(1, $this->tracking_number);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->tracking_number = $row["tracking_num"];
        $this->release_date = $row["release_date"];
        $this->delivery_date = $row["delivery_date"];
        $this->origin = $row["origin"];
        $this->product = $row["product"];
        $this->receiver_name= $row["receiver_name"];
        $this->receiver_address = $row["receiver_address"];
        $this->current_location = $row["current_location"];
        $this->destination = $row["destination"];
        $this->shipping_status = $row["shipping_status"];
        $this->id = $row["id"];
        $this->receiver_phone = $row["receiver_phone"];
        $this->receiver_email = $row["receiver_email"];
        $this->shipper_name = $row["shipper_name"];
        $this->shipper_email = $row["shipper_email"];
        $this->shipper_phone = $row["shipper_phone"];
        $this->weight = $row["weight"];

    }


    public function create(){
        $sql = 'INSERT INTO tracking (tracking_num, release_date, delivery_date,
        origin, product, weight, receiver_name, receiver_address,receiver_phone,
        receiver_email, shipper_phone, shipper_email, shipper_name,
        current_location, destination, shipping_status) VALUES(
                         :tracking_number,
                         :release_date,
                         :delivery_date,
                         :origin,
                         :product,
                         :weight,
                         :receiver_name,
                         :receiver_address,
                         :receiver_phone,
                         :receiver_email,
                         :shipper_phone,
                         :shipper_email,
                         :shipper_name,
                         :current_location,
                         :destination,
                         :stat)';
        $stmt = $this->conn->prepare($sql);
        $release_date_formatted = date_format(date_create($this->release_date),"Y-m-d H:i:s");
        $estimate_date_formatted = date_format(date_create($this->delivery_date), "Y-m-d H:i:s");

        // sanitize
        $this->tracking_number = htmlspecialchars(strip_tags($this->tracking_number));
        $release_date_formatted  =htmlspecialchars(strip_tags($release_date_formatted ));
        $estimate_date_formatted =htmlspecialchars(strip_tags($estimate_date_formatted));
        $this->origin = htmlspecialchars(strip_tags( $this->origin));
        $this->product = htmlspecialchars(strip_tags($this->product));
        $this->receiver_name= htmlspecialchars(strip_tags($this->receiver_name));
        $this->receiver_address = htmlspecialchars(strip_tags($this->receiver_address));
        $this->current_location = htmlspecialchars(strip_tags($this->current_location));
        $this->destination = htmlspecialchars(strip_tags($this->destination));
        $this->shipping_status = htmlspecialchars(strip_tags( $this->shipping_status));
        $this->receiver_phone = htmlspecialchars(strip_tags($this->receiver_phone));
        $this->shipper_name = htmlspecialchars(strip_tags($this->shipper_name));
        $this->shipper_email = htmlspecialchars(strip_tags($this->shipper_email));
        $this->shipper_phone = htmlspecialchars(strip_tags($this->shipper_phone));
        $this->weight = htmlspecialchars(strip_tags($this->weight));
        $this->receiver_email = htmlspecialchars(strip_tags($this->receiver_email));



    
        // bind values
        $stmt->bindParam(":tracking_number", $this->tracking_number);
        $stmt->bindParam(":release_date", $release_date_formatted);
        $stmt->bindParam(":delivery_date", $estimate_date_formatted);
        $stmt->bindParam(":origin", $this->origin);
        $stmt->bindParam(":product", $this->product);
        $stmt->bindParam(":receiver_name", $this->receiver_name);
        $stmt->bindParam(":receiver_address", $this->receiver_address);
        $stmt->bindParam(":current_location", $this->current_location);
        $stmt->bindParam(":destination", $this->destination);
        $stmt->bindParam(":receiver_phone", $this->receiver_phone);
        $stmt->bindParam(":stat", $this->shipping_status);
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":shipper_name", $this->shipper_name);
        $stmt->bindParam(":shipper_email", $this->shipper_email);
        $stmt->bindParam(":shipper_phone", $this->shipper_phone);
        $stmt->bindParam(":receiver_email", $this->receiver_email);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function update(){

        $sql = 'UPDATE tracking SET 
                         tracking_num=:tracking_number,
                         release_date=:release_date,
                         delivery_date=:delivery_date,
                         origin=:origin,
                         product=:product,
                         weight=:weight,
                         receiver_name=:receiver_name,
                         receiver_address=:receiver_address,
                         current_location=:receiver_phone,
                         receiver_email=:receiver_email,
                         shipper_phone=:shipper_phone,
                         shipper_email=:shipper_email,
                         shipper_name=:shipper_name,
                         current_location=:current_location,
                         destination=:destination,
                         shipping_status=:status WHERE id = :id';



        $stmt = $this->conn->prepare($sql);
        $release_date_formatted = date_format(date_create($this->release_date),"Y-m-d H:i:s");
        $estimate_date_formatted = date_format(date_create($this->delivery_date), "Y-m-d H:i:s");

        // sanitize
        
 // sanitize
 $this->tracking_number = htmlspecialchars(strip_tags($this->tracking_number));
 $release_date_formatted  =htmlspecialchars(strip_tags($release_date_formatted ));
 $estimate_date_formatted =htmlspecialchars(strip_tags($estimate_date_formatted));
 $this->origin = htmlspecialchars(strip_tags( $this->origin));
 $this->product = htmlspecialchars(strip_tags($this->product));
 $this->receiver_name= htmlspecialchars(strip_tags($this->receiver_name));
 $this->receiver_address = htmlspecialchars(strip_tags($this->receiver_address));
 $this->current_location = htmlspecialchars(strip_tags($this->current_location));
 $this->destination = htmlspecialchars(strip_tags($this->destination));
 $this->shipping_status = htmlspecialchars(strip_tags( $this->shipping_status));
 $this->receiver_phone = htmlspecialchars(strip_tags($this->receiver_phone));
 $this->shipper_name = htmlspecialchars(strip_tags($this->shipper_name));
 $this->shipper_email = htmlspecialchars(strip_tags($this->shipper_email));
 $this->shipper_phone = htmlspecialchars(strip_tags($this->shipper_phone));
 $this->weight = htmlspecialchars(strip_tags($this->weight));
 $this->receiver_email = htmlspecialchars(strip_tags($this->receiver_email));




 // bind values
 $stmt->bindParam(":tracking_number", $this->tracking_number);
 $stmt->bindParam(":release_date", $release_date_formatted);
 $stmt->bindParam(":delivery_date", $estimate_date_formatted);
 $stmt->bindParam(":origin", $this->origin);
 $stmt->bindParam(":product", $this->product);
 $stmt->bindParam(":receiver_name", $this->receiver_name);
 $stmt->bindParam(":receiver_address", $this->receiver_address);
 $stmt->bindParam(":current_location", $this->current_location);
 $stmt->bindParam(":destination", $this->destination);
 $stmt->bindParam(":receiver_phone", $this->receiver_phone);
 $stmt->bindParam(":status", $this->shipping_status);
 $stmt->bindParam(":weight", $this->weight);
 $stmt->bindParam(":shipper_name", $this->shipper_name);
 $stmt->bindParam(":shipper_email", $this->shipper_email);
 $stmt->bindParam(":shipper_phone", $this->shipper_phone);
 $stmt->bindParam(":receiver_email", $this->receiver_email);
 $stmt->bindParam(":id", $this->id);

 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    // delete the tracking
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
} 

?>