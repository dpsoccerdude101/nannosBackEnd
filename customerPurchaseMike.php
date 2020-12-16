<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
session_start();
require 'database.php';
// Takes raw data from the request
$json = file_get_contents('php://input');

$data = json_decode($json);
$StoreId = $data->StoreId;
$CustomerId = $data->CustomerId;
$ItemId = $data->ItemId;
$QuantityPurchased = (int)$data->QuantityPurchased;
$ResultOfCustomerPurchase = TRUE;
$quantity;

$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = "SELECT StoreId, ItemId, QuantityInStock FROM Inventory 
WHERE StoreId = '$StoreId' 
AND ItemId = '$ItemId'";

$results = mysqli_query($link, $query);
if(mysqli_num_rows($results) > 0) {
    $row = mysqli_fetch_assoc($results);
    $quantity = (int)$row["QuantityInStock"];
    if ($quantity - $QuantityPurchased >= 0) {
        $QuantityInStock = $quantity - $QuantityPurchased;
        $query = "UPDATE Inventory SET QuantityInStock='$QuantityInStock' WHERE StoreId='$StoreId' AND ItemId='$ItemId'";
        if($link->query($query) === TRUE) {
            $query = "INSERT INTO CustomerPurchase (CustomerId, ItemId, StoreId, QuantityPurchased, DateTimeOfPurchase) 
            VALUES('$CustomerId', '$ItemId', '$StoreId', '$QuantityPurchased', CURRENT_TIMESTAMP)";
            if($link->query($query) === TRUE){
                $ResultOfCustomerPurchase = TRUE;
            } else {
                $ResultOfCustomerPurchase = FALSE;
            }
        } else {
            $ResultOfCustomerPurchase = FALSE;
        }
    }
    else {
        $ResultOfCustomerPurchase = FALSE;
    }
} else {
    $ResultOfCustomerPurchase = FALSE;
}

if($ResultOfCustomerPurchase === TRUE) {
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
} else {
    $result = '{"result": "failure"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}