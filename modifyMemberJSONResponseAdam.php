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

//assign the CustomerId passed from the request to a variable to locate the coresponding customer.
$CustomerId = (int)$data->CustomerId;


$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT * FROM Customer WHERE CustomerId='$CustomerId'";
$results = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($results);

if($row > 0) {
    $cust_array = array();
    //$cust_array['data'] = array();

    extract($row);

    $customer_item = array(
        'CustomerId' => $row['CustomerId'],
        'Name' => $row['Name'],
        'Address' => $row['Address'],
        'City' => $row['City'],
        'State' => $row['State'],
        'Zip' => (int)$row['Zip'],
        'Phone' => (int)$row['Phone'],
        'Email' => $row['Email'],
        'Status' => $row['Status']
    );

    //array_push($cust_array['data'], $customer_item);

    //echo json_encode($customer_item);
    $result = '{"result": "success"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($customer_item);
} else {
    $result = '{"result": "failure"}';
    header('Content-Type: application/json, Access-Control-Allow-Origin : *');
    echo json_encode($result);
    $_SESSION['error'] = $Error;
}
$link->close();