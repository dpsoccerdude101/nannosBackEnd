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

$Description=$data->Description;
$Size=$data->Size;
$Division=$data->Division;
$Department=$data->Department;
$Category=$data->Category;
$ItemCost=$data->ItemCost;
$ItemRetail=$data->ItemRetail;
$ImageFileName=$data->ImageFileName;
$VenId=(int)$data->VenId;

$Error = "Error Inserting Data";


$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = "INSERT INTO InventoryItem (Description, Size, Division, Department, Category, ItemCost, ItemRetail, ImageFileName, VendorId) 
VALUES('$Description', '$Size', '$Division', '$Department', '$Category', '$ItemCost', '$ItemRetail', '$ImageFileName', '$VenId')";


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
