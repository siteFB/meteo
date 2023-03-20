<?php
$titre = "Connexion";

include "../accueil/header.php";
?>
<nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MÉTÉO 58</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation" onclick="myFunction()">
            <span class="navbar-toggler-icon red"></span>
        </button>
        <div class="container" id="contenerNav">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills">
                    <!-------------------------- Rediriger au formulaire d'inscription ------------------------------->
                    <?php if (!isset($_SESSION["user"])) : ?>
                        <li class="nav-item"><a href="../formulaires/formConnexion.php" class="nav-link text-white">Se connecter</a></li>
                        <li class="nav-item"><a href="../accueil/index.php#inscription" class="nav-link text-white">S'inscrire</a></li>
                    <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) : ?>
                        <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                        <li class="nav-item"><a href="../espaceMembres/profilMembre.php" class="nav-link text-white">Profil</a></li>
                        <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                    <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) : ?>
                        <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                        <li class="nav-item"><a href="profilAdmin.php" class="nav-link text-white">Profil</a></li>
                        <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav me-auto mb-2">
                <?php if (!isset($_SESSION["user"])) : ?>
                    <li class="nav-item"><a href="../formulaires/formConnexion.php" class="nav-link text-white">Se connecter</a></li>
                    <li class="nav-item"><a href="../accueil/index.php#inscription" class="nav-link text-white">S'inscrire</a></li>
                <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) : ?>
                    <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                    <li class="nav-item"><a href="../espaceMembres/profilMembre.php" class="nav-link text-white">Profil</a></li>
                    <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                <?php elseif (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) : ?>
                    <li class="nav-item"><a href="../consulterMeteo.php" class="nav-link text-white">Éphéméride</a></li>
                    <li class="nav-item"><a href="profilAdmin.php" class="nav-link text-white">Profil</a></li>
                    <li class="nav-item"><a href="../../formulaires/deconnexion.php" class="nav-link text-white">Se déconnecter</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php
include "../accueil/titre.php";
?>
<!-------------------------- Formulaire de connexion ------------------------------->
<div class="container col-xl-10 col-xxl-8 pt-2 mb-3" id="sinscrire">
    <div class="align-items-center g-5 py-3">
        <div class="col-10 mx-auto col-lg-5 p-4">
        <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
        <form action="traiterConnexion.php" method="POST" class="p-5 border rounded-3 bg-light mt-4 mb-5">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" autocomplete="off">
                    <label for="email">E-mail</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Mot de passe" autocomplete="off">
                    <label for="pass">Mot de passe</label>
                </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" name="btnConnexion" type="submit">Se connecter</button>
        </form>
    </div>
</div>
</div>

<?php
include "../accueil/footer.php";
?>