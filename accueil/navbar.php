<nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MÉTÉO 58</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation" onclick="myFunction()">
            <span class="navbar-toggler-icon red"></span>
        </button>
        <div class="container" id="contenerNav">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills">

                    <!-------------------------- Gérer les accès de navigation selon la connexion ------------------------------->
                    <?php if (!isset($_SESSION["user"])) : ?>
                        <li class="nav-item"><a href="../formulaires/formConnexion.php" class="nav-link text-white">Se connecter</a></li>
                        <li class="nav-item"><a href="#inscription" class="nav-link text-white">S'inscrire</a></li>
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
                    <li class="nav-item"><a href="#inscription" class="nav-link text-white">S'inscrire</a></li>
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