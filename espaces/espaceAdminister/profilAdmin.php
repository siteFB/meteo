<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../../formulaires/formConnexion.php");
    exit;
}

$titre = "Espace administrateur/Modifier le profil";
$gererTitre = "Modifier mon profil";

include "../../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">

<?php
include "../../accueil/navbar.php";
include "../../accueil/titre.php";
include "../bienvenu.php";
include "../gererTitre.php";
?>


<div class="container mt-4 mb-5">
    <div class="text-center darken-grey-text mb-4">
        <table class="table">
            <tbody>
                <tr class="table-warning">
                    <th scope="row">Mon pseudo</th>
                    <td><?php echo $_SESSION["user"]['pseudo'] ?></td>
                    <td>Modifier</td>
                </tr>
                <tr class="table-success">
                    <th scope="row">Mon e-mail</th>
                    <td><?php echo $_SESSION["user"]['email'] ?></td>
                    <td>Modifier</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
include "../../accueil/footer.php";
?>