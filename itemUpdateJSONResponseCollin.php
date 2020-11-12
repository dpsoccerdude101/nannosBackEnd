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

//Assign all the vendor attributes sent over to variables to be put into the database.
$IID = (int)$data->ItemId;
$Des = $data->Description;
$Size = $data->Size;
$Div = $data->Division;
$Dep = $data->Department;
$Category = $data->Category;
$ItemCost = (double)$data->ItemCost;
$ItemRetail = (double)$data->ItemRetail;
$IFN = $data->ImageFileName;

$Error = "Error updating vendor Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to upate the desired Vendor.
$query = "UPDATE InventoryItem SET Description='$Des',Size='$Size',Division='$Div',Department='$Dep',Category='$Category',ItemCost='$ItemCost',ItemRetail='$ItemRetail',ImageFileName='$IFN' WHERE ItemID='$IID'";


if($link->query($query) === TRUE) {
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