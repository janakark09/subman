<?php
include "../includes/db-con.php";

$pieces = $_POST['pieces'];
$duration = $_POST['duration'];
$qty = $_POST['qty'];

if(!$pieces || !$duration || !$qty){
    echo json_encode([]);
    exit;
}

$setsRequired = $qty / $pieces;
$requiredDaily = $setsRequired / $duration;

$sql = "SELECT vendorID, vendor 
        FROM vendors 
        WHERE dailyCapacity >= '$requiredDaily'
        ORDER BY dailyCapacity ASC";

$res = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($res)){
    $data[] = $row;
}

echo json_encode($data);
?>