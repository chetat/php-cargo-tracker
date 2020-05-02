<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../models/Tracking.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare Tracking object
    $tracking = new Tracking($db);
    
    // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of tracking to be updated
    $tracking->id = $data->id;
  
    // set tracking property values
    $tracking->release_date = $data->release_date;
    $tracking->delivery_date = $data->delivery_date;
    $tracking->origin = $data->origin;
    $tracking->product = $data->product;
    $tracking->tracking_number = $data->tracking_number;
    $tracking->receiver_name = $data->receiver_name;
    $tracking->receiver_address = $data->receiver_address;
    $tracking->receiver_phone = $data->receiver_phone;
    $tracking->destination = $data->destination;
    $tracking->current_location = $data->current_location;
    $tracking->receiver_email = $data->receiver_email;
    $tracking->shipper_name = $data->shipper_name;
    $tracking->shipper_email = $data->shipper_email;
    $tracking->shipper_phone = $data->shipper_phone;
    $tracking->weight = $data->weight;
    $tracking->shipping_status = $data->status;


  
// update the product
if($tracking->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => $tracking));
}
  
// if unable to update the product, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(500);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update Tracking."));
}
?>