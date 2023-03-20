<?php
$titre = "Déconnexion espace membre";

include "../accueil/header.php";
include "../accueil/navbar.php";
include "../accueil/titre.php";

?>
<?php
session_start();

//Déconnxeion de la base de données
$db = null;

//Supprimer la session si elle existe
if (!isset($_SESSION["user"])) {
unset($_SESSION["user"]);
    header("Location: formConnexion.php");
    die();
}
header("Location: formConnexion.php");
?>


