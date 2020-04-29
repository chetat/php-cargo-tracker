<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once '../config/database.php';
include_once '../models/Tracking.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$tracking = new Tracking($db);

// Query trackings

$stmt = $tracking->read();
$num = $stmt->rowCount();

if ($sum > 0){
    // tracking items array
    
}

?>