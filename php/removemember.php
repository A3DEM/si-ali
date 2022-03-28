<?php

$database = new mysqli("localhost", "root", "", "si_cotisations");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$delete = $database->query("DELETE FROM `membres` WHERE id =");

var_dump($delete->fetch_assoc());
