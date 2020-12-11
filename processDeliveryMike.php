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
$data = json_decode($json);
$OrderId = $data->OrderId;
$resultOfUpdate = TRUE;
$StoreId;
$VendorId;

$query = "SELECT * FROM Orders WHERE OrderId = '$OrderId' AND Status = 'pending'";

$results = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($results);

if($row > 0){
    $StoreId = $row["StoreId"];
    $VendorId = $row["VendorId"];

} else {
    $resultOfUpdate = FALSE;
}

if($resultOfUpdate === TRUE) {
    $query = "UPDATE Orders SET Status='delivered', DateTimeOfFulfilment=CURRENT_TIMESTAMP WHERE OrderId='$OrderId'";
    if(mysqli_query($link, $query)){
        $query = "SELECT * FROM OrderDetail WHERE OrderId = '$OrderId'";
        $results = mysqli_query($link, $query);
        if(mysqli_num_rows($results) > 0) {
            while($row = mysqli_fetch_assoc($results)) {
                $ItemId = (int)$row["ItemId"];
                $QuantityOrdered = (int)$row["QuantityOrdered"];
                
                $query = "SELECT * FROM Inventory WHERE StoreId='$StoreId' AND ItemId='$ItemId'";
                $result = mysqli_query($link, $query);
                $currentRow = mysqli_fetch_assoc($result);
                if($currentRow > 0) {
                    $currentQuantity = (int)$currentRow["QuantityInStock"];
                    $newQuantity = $QuantityOrdered + $currentQuantity;
                    $query = "UPDATE Inventory SET QuantityInStock=$newQuantity WHERE StoreId='$StoreId' AND ItemId='$ItemId'";
                    if(mysqli_query($link, $query)) {
                            continue;
                    } else {
                        $resultOfUpdate = FALSE;
                        break;
                    }
                } else {
                    $query = "INSERT INTO Inventory (StoreId, ItemId, QuantityInStock) 
                    VALUES('$StoreId','$ItemId','$QuantityOrdered')";
                    if(mysqli_query($link, $query)) {
                        continue;
                    } else {
                        $resultOfUpdate = FALSE;
                        break;
                    }
                }
            }
        }
        else {
            $resultOfUpdate = FALSE;
        }
    } else {
        $resultOfUpdate = FALSE;
    }
}





$Error = "Error Inserting Data";

if($resultOfUpdate === TRUE) {
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
} else {
    $result = "{\"result\": \"'$query'\"}";
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();