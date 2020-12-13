<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
session_start();
require 'database.php';
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

$ItemId = (int)$data->ItemId;
$StartDate = $data->StartDate;
$EndDate = $data->EndDate;

$new_start_date = date('Y-m-d', strtotime($StartDate));
$new_end_date = date('Y-m-d', strtotime($EndDate));

$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT CustomerPurchase.ItemId, RetailStore.StoreName, Customer.Name
FROM CustomerPurchase, RetailStore, Customer
WHERE CustomerPurchase.ItemId = '$ItemId' 
AND RetailStore.StoreId = CustomerPurchase.StoreId
AND CustomerPurchase.CustomerId = Customer.CustomerId
AND CustomerPurchase.DateTimeOfPurchase > '$new_start_date'
AND CustomerPurchase.DateTimeOfPurchase < '$new_end_date'";


$results = mysqli_query($link, $query);
if(mysqli_num_rows($results) > 0) {
    $all_items = array(array());
    $i = 0;
    while($row = mysqli_fetch_assoc($results)) {
        $item = array();
        extract($row);
        $item = array(
            'ItemId' => $row['ItemId'],
            'StoreName' => $row['StoreName'],
            'CustomerName' => $row['Name']
        );
        $all_items[$i] = $item; 
        $i++;
    }
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($all_items);
} else {
    $result = '{"result": "none"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();