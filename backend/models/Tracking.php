<?php

class Tracking {
    private $conn;
    private $table_name = "tracking";

    public $id;
    public $content;
    public $shipped_date;
    public $estimated_date;
    public $shipment_type;
    public $tracking_number;
    public $receiver_name;
    public $receiver_address;
    public $telephone;
    public $destination;
    public $current_location;
    public $status;

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
        $this->shipped_date = $row["shipped_date"];
        $this->estimated_date = $row["estimated_date"];
        $this->shipment_type = $row["shipment_type"];
        $this->content = $row["content"];
        $this->receiver_name= $row["receiver_name"];
        $this->receiver_address = $row["receiver_address"];
        $this->current_location = $row["current_location"];
        $this->destination = $row["destination"];
        $this->status = $row["status"];
        $this->id = $row["id"];
        $this->telephone = $row["telephone"];
    }


    public function create(){
        $sql = 'INSERT INTO tracking (tracking_num, shipped_date, estimated_date,
        shipment_type, content, receiver_name, receiver_address,
        current_location, destination, telephone, status) VALUES(
                         :tracking_number,
                         :shipped_date,
                         :estimated_date,
                         :shipment_type,
                         :content,
                         :receiver_name,
                         :receiver_address,
                         :current_location,
                         :destination,
                         :telephone,
                         :stat)';
        $stmt = $this->conn->prepare($sql);
        $shipped_date_formatted = date_format(date_create($this->shipped_date),"Y-m-d H:i:s");
        $estimate_date_formatted = date_format(date_create($this->estimated_date), "Y-m-d H:i:s");

        // sanitize
        $this->tracking_number = htmlspecialchars(strip_tags($this->tracking_number));
        $shipped_date_formatted  =htmlspecialchars(strip_tags($shipped_date_formatted ));
        $estimate_date_formatted =htmlspecialchars(strip_tags($estimate_date_formatted));
        $this->shipment_type = htmlspecialchars(strip_tags( $this->shipment_type));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->receiver_name= htmlspecialchars(strip_tags($this->receiver_name));
        $this->receiver_address = htmlspecialchars(strip_tags($this->receiver_address));
        $this->current_location = htmlspecialchars(strip_tags($this->current_location));
        $this->destination = htmlspecialchars(strip_tags($this->destination));
        $this->status = htmlspecialchars(strip_tags( $this->status));
        $this->telephone = htmlspecialchars(strip_tags($this->telephone));


    
        // bind values
        $stmt->bindParam(":tracking_number", $this->tracking_number);
        $stmt->bindParam(":shipped_date", $shipped_date_formatted);
        $stmt->bindParam(":estimated_date", $estimate_date_formatted);
        $stmt->bindParam(":shipment_type", $this->shipment_type);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":receiver_name", $this->receiver_name);
        $stmt->bindParam(":receiver_address", $this->receiver_address);
        $stmt->bindParam(":current_location", $this->current_location);
        $stmt->bindParam(":destination", $this->destination);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":stat", $this->status);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
} 

?>