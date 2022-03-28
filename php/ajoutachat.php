<?php
session_start();
if (!isset($_SESSION['connectedId'])) {
    echo json_encode(["response" => "error", "message" => "Aucun compte connecte"]);
    die;
}

echo json_encode(["response" => "success", "data" => [
    "role" => $_SESSION["role"]
]]);

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$request = $database->prepare("INSERT INTO `transactions`(`id_membre`, `date`, `montant`, `type`) VALUES (?,?,?,'ACHAT')");
$request->bind_param('ss', $_GET['id_membre'], $_GET['date'], $_GET['montant']);

$request->execute();
// $request->bind_result($userId);
// $request->fetch();
