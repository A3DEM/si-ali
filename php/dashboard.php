<?php
session_start();
if (!isset($_SESSION['connectedId'])) {
    echo json_encode(["response" => "error", "message" => "Aucun compte connecte"]);
    die;
}

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$data = $database->query("SELECT id, nom, prenom FROM membres");
$final_data = [];
while ($member = $data->fetch_assoc()) {
    $member['transactions'] = [];
    $id = $member['id'];
    $data2 = $database->query("SELECT * FROM transactions WHERE id_membre = $id");
    while ($transactions = $data2->fetch_assoc()) {
        $member['transactions'][] = $transactions;
    }
    $final_data[] = $member;
}

$data = $database->query("SELECT * FROM data");

$response = [
    "response" => "success",
    "data" => [
        "role" => $_SESSION["role"],
        "members" => $final_data
    ]
];

while ($response2 = $data->fetch_assoc()) {
    $response["data"][$response2["nom"]] = $response2["valeur"];
}

echo json_encode($response);

