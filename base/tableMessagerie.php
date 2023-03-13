<?php
$servername = "localhost";
$database = "meteo";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE `messagerie`(
            idMessagerie INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_expediteur INT(11) NOT NULL,
            id_destinataire INT(11) NOT NULL,
            titreMessage VARCHAR (20) NOT NULL,
            mesage TEXT (100) NOT NULL, 
            dateMess TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
   
    $db->exec($sql);
    echo 'La table "messagerie" est bien créée !';
}

catch (PDOException $e) {
    echo "erreur de connexion:" . $e->getMessage();
};
?>