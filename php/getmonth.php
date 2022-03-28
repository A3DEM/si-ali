<?php

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$value = $database->query("SELECT SUM(montant) AS montant, date FROM `transactions` WHERE type = 'ACHAT' GROUP BY YEAR(date), MONTH(date)");

var_dump($value->fetch_assoc());
// $request->fetch();