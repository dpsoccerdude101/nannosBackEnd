<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}
session_start();
require 'database.php';
// Takes raw data from the request
$json = file_get_contents('php://input');

$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT * FROM InventoryItem WHERE 1";
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
            'Size' => $row['Size'],
            'Division' => $row['Division'],
            'Department' => $row['Department'],
            'Category' => $row['Category'],
            'ItemCost' => $row['ItemCost'],
            'ItemRetail' => $row['ItemRetail'],
            'ImageFileName' => $row['ImageFileName'],
            'VendorId' => $row['VendorId'],
           'Status' => $row['Status']
        );
        $all_items[$i] = $item; 
        $i++;
    }
    //array_push($vendor_array['data'], $vendor_item);

    //echo json_encode($vendor_item);
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