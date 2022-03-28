<?php

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$data = $database->query("SELECT SUM(montant) AS montant, date FROM `transactions` WHERE type = 'ACHAT' GROUP BY YEAR(date), MONTH(date)");
$final_value = [];
while ($value = $data->fetch_assoc()) {
    $final_value[] = $value;
};
echo json_encode($final_value);
// $request->fetch();