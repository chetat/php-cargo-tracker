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

if ($num > 0){
    // tracking items array
    $trackings_array = array();
    $trackings_array["data"] = array();

    //retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tracking_item = array(
            "id" => $id,
            "product" => $product,
            "release_date" => $release_date,
            "delivery_date" => $delivery_date,
            "origin" =>$origin,
            "tracking_number" => $tracking_number,
            "receiver_name" => $receiver_name,
            "receiver_address" => $receiver_address,
            "receiver_phone" =>$receiver_phone,
            "destination" => $destination,
            "current_location" => $current_location,
            "shipping_status" => $shipping_status,
            "receiver_email" => $receiver_email,
            "shipper_name" =>$shipper_name,
            "shipper_email" =>$shipper_email,
            "shipper_phone" => $shipper_phone,
            "weight" => $weight
        
        );
        array_push($trackings_array["data"], $tracking_item);
    }

    http_response_code(200);

    echo json_encode($trackings_array);
    
}else{
    echo json_encode([]);
}

?>