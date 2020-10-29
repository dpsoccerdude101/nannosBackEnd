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

$VendorCode = (int)$data->VendorCode;
$VendorName = $data->VendorName;
$Address = $data->Address;
$City = $data->City;
$State = $data->State;
$Zip = (int)$data->Zip;
$Phone = (int)$data->Phone;
$ContactName = $data->ContactName;
$Password = $data->Password;
$Status = "Active";

$Error = "Error Inserting Data";


$link = new mysqli("localhost", "root", "xXT@jyY2yg3P", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = "INSERT INTO Vendor (VendorCode, VendorName, Address, City, State, Zip, Phone, ContactName, Password, Status) 
VALUES('$VendorCode', '$VendorName', '$Address', '$City', '$State', '$Zip', '$Phone', '$ContactName', '$Password', '$Status')";

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
