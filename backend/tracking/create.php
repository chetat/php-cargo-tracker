<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
// instantiate Tracking object
include_once '../models/Tracking.php';

$database = new Database();
$db = $database->getConnection();

$tracking = new Tracking($db);

function generateRandomString($length = 3) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$first_seq = generateRandomString();
$second_int = rand(0, 10000);
$third_seq = generateRandomString();
$data = json_decode(file_get_contents("php://input"));
//Check requests body not empty
if(!empty($data->release_date) &&
   !empty($data->delivery_date) &&
   !empty($data->origin) &&
   !empty($data->product) &&
   !empty($data->receiver_name) &&
   !empty($data->receiver_address) &&
   !empty($data->receiver_phone) &&
   !empty($data->destination) &&
   !empty($data->current_location) &&
   !empty($data->receiver_email) &&
   !empty($data->shipper_name) &&
   !empty($data->shipper_email) &&
   !empty($data->shipper_phone) &&
   !empty($data->weight) &&
   !empty($data->status)){


    $track_generated_number = $first_seq."-".$second_int.$third_seq;

    //Set tacking object properties
    $tracking->release_date = $data->release_date;
    $tracking->delivery_date = $data->delivery_date;
    $tracking->origin = $data->origin;
    $tracking->product = $data->product;
    $tracking->tracking_number = $track_generated_number;
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
    
    $t_id = $tracking->create();
    if($t_id){
        $tracking->id = $t_id;
        http_response_code(201);
        echo json_encode(
            array("success" => "create with success",
                  "data" => $tracking));
    }else{
        http_response_code(500);
        echo json_encode(
            array("success" => "Failed to create Tracking"));
    }

   
   }else{
        // set response code - 400 bad request
        http_response_code(400);
    
        // tell the user
        echo json_encode(array("message" => "Bad Request"));
    }
?>

   