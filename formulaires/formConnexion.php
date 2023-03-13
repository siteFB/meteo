<?php
$titre = "Connexion";

include "../accueil/header.php";
include "../accueil/navbar.php";
include "../accueil/titre.php";

?>

<!-------------------------- Formulaire de connexion ------------------------------->
<div class="container col-xl-10 col-xxl-8 pt-2 mb-3" id="sinscrire">
    <div class="align-items-center g-5 py-3">
        <div class="col-10 mx-auto col-lg-5 p-4">
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