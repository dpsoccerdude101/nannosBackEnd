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

$Name = $data->Name;
$Address = $data->Address;
$City = $data->City;
$State = $data->State;
$Zip = (int)$data->Zip;
$Phone = $data->Phone;
$Email = $data->Email;
$Status = "Active";

$Error = "Error Inserting Data";


$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$query = "INSERT INTO Customer (Name, Address, City, State, Zip, Phone, Email, Status) 
VALUES('$Name', '$Address', '$City', '$State', '$Zip', '$Phone', '$Email', '$Status')";

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
