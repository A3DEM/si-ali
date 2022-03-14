<?php
$database = new  mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM membre";
$result = $database->query($sql);
$array = [];
while($row =mysqli_fetch_assoc($result))
{
    $array[] = $row;
}
echo json_encode($array);
