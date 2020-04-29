<?php
include 'config.php';

$connection = connect_to_db();
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->shipped_date) &&
   !empty($data->estimated_date) &&
   !empty($data->shipment_type) &&
   !empty($data->content) &&
   !empty($data->tracking_number) &&
   !empty($data->receiver_name) &&
   !empty($data->receiver_address) &&
   !empty($data->telephone) &&
   !empty($data->destination) &&
   !empty($data->current_location) &&
   !empty($data->status)){



   }










   ){
 
   
   $stmt = $pdo->prepare('INSERT INTO tracking VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
   
   $stmt.execute([
         $tracking_number,
         $shipped_date, $estimated_date,
         $shipment_type, $content,
         $receiver_name, $receiver_address,
         $current_location, $destination,
         $telephone, $status  ]);
      http_response_code(200);

   echo json_encode(
         array("success" => "create with success"));
}

?>