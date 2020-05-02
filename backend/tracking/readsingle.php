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
            "product" => $tracking->product,
            "release_date" => $tracking->release_date,
            "delivery_date" => $tracking->delivery_date,
            "origin" =>$tracking->origin,
            "tracking_number" => $tracking->tracking_number,
            "receiver_name" => $tracking->receiver_name,
            "receiver_address" => $tracking->receiver_address,
            "receiver_phone" =>$tracking->receiver_phone,
            "destination" => $tracking->destination,
            "current_location" => $tracking->current_location,
            "shipping_status" => $tracking->shipping_status,
            "receiver_email" => $tracking->receiver_email,
            "shipper_name" =>$tracking->shipper_name,
            "shipper_email" =>$tracking->shipper_email,
            "shipper_phone" => $tracking->shipper_phone,
            "weight" => $tracking->weight
    );
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode(array("data" => $tracking_item));

    
    }else{
        http_response_code(404);
        echo json_encode(array("message" => "Tracking item not found"));
}

?>