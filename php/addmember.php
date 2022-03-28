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

$request = $database->prepare("INSERT INTO `membres`(`nom`, `prenom`, `roles`, `mdp`, `username`) VALUES (?,?,?,?,?)");
$request->bind_param('ss', $_GET['nom'], $_GET['prenom'], $_GET['role'], $_GET['password'], $_GET['username']);

$request->execute();
// $request->bind_result($userId);
// $request->fetch();
