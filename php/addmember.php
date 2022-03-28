<?php
session_start();
if (!isset($_SESSION['connectedId'])) {
    echo json_encode(["response" => "error", "message" => "Aucun compte connecte"]);
    die;
}

if ($_SESSION["role"] !== "ROLE_ADMIN") {
    echo json_encode(["response" => "error", "message" => "NOT_ADMIN"]);
    die;
}


if (
    !isset($_GET["nom"]) || !isset($_GET["prenom"]) || !isset($_GET["password"]) || !isset($_GET["username"]) ||
    !$_GET["nom"] || !$_GET["prenom"] || !$_GET["password"] || !$_GET["username"]
) {
    echo json_encode(["response" => "error", "message" => "EMPTY_INPUT"]);
    die;
}

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$request = $database->prepare("INSERT INTO `membres`(`nom`, `prenom`, `roles`, `mdp`, `username`) VALUES (?,?,'ROLE_MEMBER',?,?)");
$request->bind_param('ssss', $_GET['nom'], $_GET['prenom'], $_GET['password'], $_GET['username']);

if ($request->execute()) {
    echo json_encode(["response" => "success"]);
}
else {
    echo json_encode(["response" => "error"]);
}