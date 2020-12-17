<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
session_start();
require 'database.php';
// Takes raw data from the request
$json = file_get_contents('php://input');

$data = json_decode($json);

$OrderId = $data->OrderId;

$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT InventoryItem.ItemId, InventoryItem.Description, Vendor.VendorName FROM Orders, Vendor, InventoryItem WHERE Orders.OrderId = '$OrderId' AND Vendor.VendorID = Orders.VendorId AND InventoryItem.VendorId = Vendor.VendorID AND Orders.Status = 'pending'";
$results = mysqli_query($link, $query);
if(mysqli_num_rows($results) > 0) {
    $all_items = array(array());
    $i = 0;
    while($row = mysqli_fetch_assoc($results)) {
        $item = array();
        extract($row);
        $item = array(
            'ItemId' => $row['ItemId'],
            'Description' => $row['Description'],
            'VendorName' => $row['VendorName']
        );
        $all_items[$i] = $item; 
        $i++;
    }
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($all_items);
} else {
    $result = '{"result": "failure"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();