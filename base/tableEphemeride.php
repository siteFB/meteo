<?php
$servername = "localhost";
$database = "meteo";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE `ephemeride`(
            idEphemeride INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            imgTemps BLOB  (200) NOT NULL ,
            titre VARCHAR (100) NOT NULL COLLATE utf8mb4_general_ci,
            topo VARCHAR (100) NOT NULL COLLATE utf8mb4_general_ci)";
   
    $db->exec($sql);
    echo 'La table "ephemeride" est bien créée !';
}

catch (PDOException $e) {
    echo "erreur de connexion:" . $e->getMessage();
};
?>