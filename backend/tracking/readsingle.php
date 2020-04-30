<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../config/database.php';
include_once '../models/Tracking.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$tracking = new Tracking($db);

// Query tracking number
$tracking->tracking_number = isset($_GET['tracking_number']) ? $_GET['tracking_number'] : die();

$tracking->read_single();
if ($tracking->id != null){
    // tracking items array
    $tracking_item = array(
        "id" => $tracking->id,
        "content" => $tracking->content,
        "shipped_date" => $tracking->shipped_date,
        "estimated_date" => $tracking->estimated_date,
        "shipment_type" =>$tracking->shipment_type,
        "tracking_number" => $tracking->tracking_number,
        "receiver_name" => $tracking->receiver_name,
        "receiver_address" => $tracking->receiver_address,
        "telephone" =>$tracking->telephone,
        "destination" => $tracking->destination,
        "current_location" => $tracking->current_location,
        "status" => $tracking->status
    );
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($tracking_item);

    
    }else{
        http_response_code(404);
        echo json_encode(array("message" => "Tracking item not found"));
}

?>