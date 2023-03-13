<?php
session_start();
require_once('../base/connexionBDD.php');

$sql = 'SELECT * FROM `ephemeride`';
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('../base/deconnexionBDD.php');
?>

<?php
$titre = "Espace membre consulter la météo";
include "../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MÉTÉO 58</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation" onclick="myFunction()">
            <span class="navbar-toggler-icon red"></span>
        </button>
        <div class="container" id="contenerNav">
            <div class="d-flex justify-content-center">
                    <!-------------------------- Gérer les accès de navigation selon la connexion Éphéméride------------------------------->
                <ul class="nav nav-pills">
                    <?php if (!isset($_SESSION["user"])) : ?>
                        <li class="nav-item"><a href="../formulaires/formConnexion.php" class="nav-link text-white">Se connecter</a></li>
                        <li class="nav-item"><a href="../../accueil/index.php" class="nav-link text-white">S'inscrire</a></li>
                    <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) : ?>
                        <li class="nav-item"><a href="../espaces/consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                        <li class="nav-item"><a href="../espaces/espaceMembres/profilMembre.php" class="nav-link text-white">Profil</a></li>
                        <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                    <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) : ?>
                        <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                        <li class="nav-item"><a href="../espaces/espaceAdminister/profilAdmin.php" class="nav-link text-white">Profil</a></li>
                        <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav me-auto mb-2">
                <?php if (!isset($_SESSION["user"])) : ?>
                    <li class="nav-item"><a href="../formulaires/formConnexion.php" class="nav-link text-white">Se connecter</a></li>
                    <li class="nav-item"><a href="../../accueil/index.php" class="nav-link text-white">S'inscrire</a></li>
                <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) : ?>
                    <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                    <li class="nav-item"><a href="../espaces/espaceMembres/profilMembre.php" class="nav-link text-white">Profil</a></li>
                    <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) : ?>
                    <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                    <li class="nav-item"><a href="../espaces/espaceAdminister/profilAdmin.php" class="nav-link text-white">Profil</a></li>
                    <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php
include "../accueil/titre.php";
include "bienvenu.php";
?>

<!------------------------------------ Redirection selon le statut ---------------------------->
<span class="d-flex justify-content-end mx-5">
    <?php
    if (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) {
        echo "
        <div>
            <button type='button' class='btn btn-success'><a class='text-white' href='../espaces/espaceMembres/espaceMembre.php'>Retour</a></button>
        </div>
               ";
    } else {

        if (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) {
            echo "
            <div>
                <button type='button' class='btn btn-success'><a class='text-white' href='../espaces/espaceAdminister/espaceAdmin.php'>Retour</a></button>
            </div>
                   ";
        }
    }
    ?>
</span>

<h2 class="display-5 fw-bold text-center mb-5 mt-5">Éphéméride</h2>
<div class="container">
    <div class="row mb-5">
        <?php
        foreach ($result as $ephemeride) {
        ?>
            <div class="col-md-4 mb-5">
                <div class="card col h-100">
                    <img src="/images/<?php echo $ephemeride['imgTemps'] ?>" class="card-img-top h-100">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $ephemeride['titre'] ?></h3>
                        <p class="card-text"><?php echo $ephemeride['topo'] ?></p>
                        <button type="button" class="btn btn-primary" style="float:left;"><a class="text-white" href="details.php?idEphemeride=<?php echo $ephemeride['idEphemeride'] ?>">Consulter</a></button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include "../accueil/footer.php";
?>