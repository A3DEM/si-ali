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


if (!isset($_GET["date"]) || !isset($_GET["prix"]) || !$_GET["date"] || !$_GET["prix"]) {
    echo json_encode(["response" => "error", "message" => "EMPTY_INPUT"]);
    die;
}

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$date = DateTime::createFromFormat("d/m/Y", $_GET["date"]);
if (!$date) {
    echo json_encode(["response" => "error", "message" => "BAD_DATE"]);
    die;
}
$date = $date->format("Y-m-d");

$request = $database->prepare("INSERT INTO `transactions`(`id_membre`, `date`, `montant`, `type`) VALUES (?,?,?,'COTISATION')");
$request->bind_param('sss', $_GET['id'], $date, $_GET['prix']);

if ($request->execute()) {
    echo json_encode(["response" => "success"]);
}
else {
    echo json_encode(["response" => "error"]);
}

$request = $database->prepare("SELECT valeur FROM data WHERE nom = 'solde'");
$request->execute();
$request->bind_result($solde);
$request->fetch();

$solde += intval($_GET["prix"]);


// Cette requête ne fonctionne pas sur le site mais fonctionne sur phpMyAdmin 
$request = $database->query("UPDATE `data` SET `valeur` = 100 WHERE nom = 'solde'");