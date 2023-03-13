<?php
$servername = "localhost";
$database = "meteo";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE `users`(
                        idUser INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        pseudo VARCHAR (100) NOT NULL COLLATE utf8mb4_general_ci,
                        email VARCHAR (100) NOT NULL COLLATE utf8mb4_general_ci,
                        pass VARCHAR (100) NOT NULL COLLATE utf8mb4_general_ci,
                        dateInscrit TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";

    $db->exec($sql);
    echo 'La table "users" est bien créée !';
} catch (PDOException $e) {
    echo "erreur de connexion:" . $e->getMessage();
};
?>

<!-------------------------- Ajout de la table " statut " ------------------------------->
<?php
try {
    $db = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "ALTER TABLE `users`
                ADD statut VARCHAR (100) NOT NULL DEFAULT 'Membre' ";

    $db->exec($sql);
    echo 'La colonne "dateInscrit" a été ajoutée !';
} catch (PDOException $e) {
    echo "erreur de connexion:" . $e->getMessage();
};
?>