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

$request = $database->prepare("SELECT * FROM transactions");
$request->bind_param('ss', $_GET['password'], $_GET['username']);

$request->execute();
$request->bind_result($userId);
$request->fetch();


if (isset($userId)) {
    echo json_encode(["response" => "success"]);
    session_start();
    $_SESSION['connectedId'] = $userId;
}
else {
    echo json_encode(["response" => "error", "message" => "Nom de compte ou mot de passe incorrect"]);
}