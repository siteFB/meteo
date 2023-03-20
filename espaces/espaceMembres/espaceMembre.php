<?php
session_start();
//si l'utilisateur n'est pas connecté il n'aura pas accès au site
if (!isset($_SESSION["user"])) {
    header("Location: ../../formulaires/formConnexion.php");
    die();
}

$titre = "Espace membre";

include "../../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">
<?php
include "../../accueil/navbar.php";
include "../../accueil/titre.php";
include "../bienvenu.php";
?>
<h2 class="text-center mt-2 mb-5">Que souhaitez-vous faire?</h2>

<?php
echo "<div class='container my-2 pb-5 bg-light'>
                <div class='col-md-12 text-center'>
                    <button type='button' class='btn btn-success'><a class='text-white' href='../consulterMeteo.php'>Consulter la météo</a></button>
                    <button type='button' class='btn btn-primary'><a href='/boitemail/recusMembre.php' class='text-white'>Ma messagerie</a></button>
                    <button type='button' class='btn btn-warning'><a href='profilMembre.php'>Modifier mon profil</a></button>
                </div>
            </div>";
?>

<?php
include "../../accueil/footer.php";
?>