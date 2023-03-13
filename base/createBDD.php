<?php

$servername = 'localhost';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$servername", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "CREATE DATABASE meteo";

    $db->exec($query);
    echo 'Base de données bien créée !';
    
} catch (PDOException $e) {
    echo "Erreur!" . $e->getMessage();
};
?>