<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../../formulaires/formConnexion.php");
    die();
}

$titre = "Espace administrateur";

include "../../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">
<?php
include "../../accueil/navbar.php";
include "../../accueil/titre.php";
include "../bienvenu.php";
?>

<h2 class="text-center pb-4 mx-4">Que souhaitez-vous gérer?</h2>

<?php
echo "<div class='container my-2 pb-5 bg-light'>
                <div class='col-md-12 text-center'>
                    <button type='button' class='btn btn-success'><a class='text-white' href='voirInscrits.php'>Voir les inscrits</a></button>
                    <button type='button' class='btn btn-warning'><a href='gererActu.php'>Gérer l'actualité</a></button>
                    <button type='button' class='btn btn-primary'><a href='/boitemail/recusAdmin.php' class='text-white'>Ma messagerie</a></button>
                    <button type='button' class='btn btn-danger'><a class='text-white' href='profilAdmin.php'>Modifier mon profil</a></button>
                </div>
            </div>";
?>

<?php
include "../../accueil/footer.php";
?>