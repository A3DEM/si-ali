<?php
require __DIR__ . '/functions.php';

if ($_GET["username"] === '' || $_GET["password"] === '') {
    echo json_encode(["response" => "error", "message" => "Veuillez remplir les deux champs"]);
    die;
}

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$request = $database->prepare("SELECT id FROM membres WHERE mdp=? AND username=?");
$request->bind_param('ss', $_GET['password'], $_GET['username']);

$request->execute();
$request->bind_result($userId);
$request->fetch();
if (isset($userId)) {
    if (session_start()) {
        $_SESSION['connectedId'] = $id;
    };
    echo json_encode(["response" => "success"]);
}
