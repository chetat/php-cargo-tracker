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
    $trackings_array = array();
    $trackings_array["data"] = array();

    //retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $tracking_item = array(
            "id" => $id,
            "content" => $content,
            "shipped_date" => $shipped_date,
            "estimated_date" => $estimated_date,
            "shipment_type" =>$shipment_type,
            "tracking_number" => $tracking_number,
            "receiver_name" => $receiver_name,
            "receiver_address" => $receiver_address,
            "telephone" =>$telephone,
            "destination" => $destination,
            "current_location" => $current_location,
            "status" => $status
        );
        array_push($trackings_array["data"], $tracking_item);
    }

    http_response_code(200);

    echo json_encode($trackings_array);
    
}else{
    echo json_encode([]);
}

?>