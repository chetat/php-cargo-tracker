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
}

?>