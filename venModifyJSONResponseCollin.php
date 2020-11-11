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

//assign the vendorID passed from the request to a variable to locate the prospective vendor.
$VendorID = (int)$data->VendorID;


$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT * FROM Vendor WHERE VendorID='$VendorID'";
$results = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($results);

if($row > 0) {
    $vendor_array = array();
    //$vendor_array['data'] = array();

    extract($row);

    $vendor_item = array(
        'VendorID' => $row['VendorID'],
        'VendorName' => $row['VendorName'],
        'Address' => $row['Address'],
        'City' => $row['City'],
        'State' => $row['State'],
        'ZIP' => (int)$row['ZIP'],
        'Phone' => (int)$row['Phone'],
        'ContactPersonName' => $row['ContactPersonName'],
        'Password' => $row['Password'],
        'Status' => $row['Status']
    );

    //array_push($vendor_array['data'], $vendor_item);

    //echo json_encode($vendor_item);
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($vendor_item);
} else {
    $result = '{"result": "failure"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();