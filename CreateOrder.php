<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
session_start();
require 'database.php';

$link = mysqli_connect("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error);
}
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);
$VendorId = $data[0]["VendorId"];
$StoreId = $data[0]["StoreId"];
date_default_timezone_set('America/New_York');
$date = date('m/d/Y h:i:s a', time());
$last_id;
$resultOfInsert = TRUE;
$query = "INSERT INTO Orders (VendorId, StoreId, DateTimeOfOrder, Status) 
VALUES('$VendorId', '$StoreId', CURRENT_TIMESTAMP, 'pending')";
if(mysqli_query($link, $query)){
    $last_id = mysqli_insert_id($link);
}
else {
    $resultOfInsert = FALSE;
}

if ($resultOfInsert != FALSE) {
    foreach($data as $key => $value) {
        $ItemId = $value["ItemId"];
        $quantity = $value["quantity"];
        $query = "INSERT INTO OrderDetail (OrderId, ItemId, QuantityOrdered) 
        VALUES('$last_id', '$ItemId', '$quantity')";
        if(mysqli_query($link, $query)){
            $resultOfInsert = TRUE;
            continue;
        }
        else {
            $resultOfInsert = FALSE;
            break;
        }
    }
}

$Error = "Error Inserting Data";

if($resultOfInsert === TRUE) {
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
} else {
    $result = '{"result": "failure"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();