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

$ItemId = $data->ItemId;
$VendorId = (int)$data->VendorId;
$Category = $data->Category;

$Error = "Error Inserting Data";

//Make a connection to the database.
$link = new mysqli("localhost", "root", "SsSMUeVf2nzj", "nannos_foods");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

//Run the query to find the vendor that you are looking for.
$query = "SELECT RetailStore.StoreName, ReturnToVendorDetail.ItemId, ReturnToVendor.DateTimeOfReturn, ReturnToVendorDetail.QuantityReturned FROM ReturnToVendor LEFT JOIN ReturnToVendorDetail ON ReturnToVendor.ReturnToVendorId = ReturnToVendorDetail.ReturnToVendorId LEFT JOIN RetailStore ON ReturnToVendor.StoreId = RetailStore.StoreId LEFT JOIN InventoryItem ON ReturnToVendorDetail.ItemId = InventoryItem.ItemId WHERE ReturnToVendor.VendorId = $VendorId ";

$count = 0;
if(isset($ItemId)) {
    while ($count<count($ItemId)) {
        if ($count == 0) {
            $query .= "AND ( ReturnToVendorDetail.ItemId = '$ItemId[$count]' ";
        } else {
            $query .= "OR ReturnToVendorDetail.ItemId = '$ItemId[$count]' ";
        }
        $count++;
    }
}
/*foreach ($ItemId as $selectedOption) {
    if ($count == 0) {
        $query .= "AND ( ReturnToVendorDetail.ItemId = '$selectedOption' ";
    } else {
        $query .= "OR ReturnToVendorDetail.ItemId = '$selectedOption' ";
    }
    $count++;
} */
if($count > 0) {
    $query .= ") ";
}

$count = 0;
foreach ($Category as $selectedOption) {
    if ($count == 0) {
        $query .= "AND ( InventoryItem.Category = '$selectedOption' ";
    } else {
        $query .= "OR InventoryItem.Category = '$selectedOption' ";
    }
    $count++;
}
if($count > 0) {
    $query .= ") ";
}

$results = mysqli_query($link, $query);
if(mysqli_num_rows($results) > 0) {
    $all_items = array(array());
    $i = 0;
    while($row = mysqli_fetch_assoc($results)) {
        $item = array();
        extract($row);
        $item = array(
            'StoreName' => $row['StoreName'],
            'ItemId' => $row['ItemId'],
            'DateTimeOfReturn' => $row['DateTimeOfReturn'],
            'QuantityReturned' => $row['QuantityReturned']
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