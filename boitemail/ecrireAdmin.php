<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../../formulaires/formConnexion.php");
    exit();
}

require_once('../base/connexionBDD.php');

if (isset($_SESSION['user']['id']) and !empty($_SESSION['user']['id'])) {
    if (isset($_POST['envoimessage'])) {
        if (
            isset($_POST['destinataire']) && !empty($_POST['destinataire'])
            && isset($_POST['titreMessage']) && !empty($_POST['titreMessage'])
            && isset($_POST['mesage']) && !empty($_POST['mesage'])
        ) {

            $id_expediteur = $_SESSION['user']['id'];
            $destinataire = htmlspecialchars($_POST['destinataire']);
            $titreMessage = htmlspecialchars($_POST['titreMessage']);
            $mesage = htmlspecialchars($_POST['mesage']);

            // Récupérer le pseudo...
            $id_destinataire = $db->prepare('SELECT idUser FROM users WHERE pseudo = :destinataire');
            $id_destinataire->bindValue(':destinataire', $destinataire, PDO::PARAM_STR);
            $id_destinataire->execute();

            // Protéger l'injection dans l'URL
            $dest_exist = $id_destinataire->rowCount();
            if ($dest_exist == 1) {
                // ... et récupérer l'ID
                $id_destinataire = $id_destinataire->fetch();
                $id_destinataire = $id_destinataire['idUser'];


                // Insérer le message: faire une requête
                $ins = $db->prepare('INSERT INTO messagerie(id_expediteur, id_destinataire, titreMessage, mesage)
                                     VALUES (:id_expediteur, :id_destinataire, :titreMessage, :mesage)');
                
                $ins->bindValue(':id_expediteur', $_SESSION['user']['id'], PDO::PARAM_INT);
                $ins->bindValue(':id_destinataire', $id_destinataire, PDO::PARAM_INT);
                $ins->bindValue(':titreMessage', $titreMessage, PDO::PARAM_STR);
                $ins->bindValue(':mesage', $mesage, PDO::PARAM_STR);
    
                $ins->execute();

                $_SESSION['message'] = "Votre message a bien été envoyé";
                require_once('../base/deconnexionBDD.php');
                
            } else {
                $_SESSION['erreur'] = "Ce destinataire n'existe pas";
                require_once('../base/deconnexionBDD.php');
            }
        } else {
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            require_once('../base/deconnexionBDD.php');
        }
    }

    // La requête
   //$destinataires = $db->query('SELECT pseudo FROM users ORDER BY pseudo');
   // require_once('../base/deconnexionBDD.php');
?>

    <?php
    $titre = "Espace administrateur";

    include "../accueil/header.php";
    ?>
    <link rel="stylesheet" href="../../boot.css">
    <?php
    include "../accueil/navbar.php";
    include "../accueil/titre.php";
    include "../espaces/bienvenu.php";
    ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="bm.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <section class="mb-5">
        <span class="d-flex justify-content-end mx-5">
            <?php
            if (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Admin")) {
                echo "
            <div>
                <button type='button' class='btn btn-success'><a class='text-white' href='../espaces/espaceAdminister/espaceAdmin.php'>Retour</a></button>
            </div>
                   ";
            } else {
                header('Location: ../../../formulaires/formConnexion.php');
            }
        } else {
            header('Location: ecrireAdmin.php');
        }
            ?>
        </span>
        <h2 class="text-center pb-3 mt-2 mb-5 text-primary">Espace messagerie</h2>
        <div class="container col-xl-10 col-xxl-12 pt-2 pb-4">
            <div class="row align-items-center py-3 bg-white border border-muted rounded">
                <!----------------------------- Actions -------------------------->
                <div class="col-10 p-3 mx-auto mb-5 col-lg-3 pb-3 align-self-baseline">
                    <h4 class="col-xl-4 col-xxl-4 w-100 mt-5 mb-5 fw-bold" style="color:#846add">
                        Écrire un message
                    </h4>
                    <div>
                        <ul class="nav flex-column mt-5">
                            <li><a href="/boitemail/ecrireAdmin.php" class="btn btn-block btn-primary text-white mb-2" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;ÉCRIRE&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                            <li class="mt-3 mb-3"><a class="fs-5" href="/boitemail/recusAdmin.php">Messages</a></li>
                        </ul>
                    </div>
                </div>
                <!----------------------------- Formulaire ----------------------------->
                <div class="bg-light border border-muted rounded col-10 mx-auto col-lg-7 pt-3 pb-4 mt-4 mb-4">
                    <?php
                    if (!empty($_SESSION['erreur'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                        $_SESSION['erreur'] = "";
                    }
                    ?>
                    <?php
                    if (!empty($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        $_SESSION['message'] = "";
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="wrapinput">
                            <input class="inputm border border-muted rounded w-100 fs-6 px-4 p-3 fw-bold mb-3" type="text" name="destinataire" placeholder="Destinataire">
                        </div>
                        <div class="wrapinput">
                            <input class="inputm border border-muted rounded w-100 fs-6 fw-bold px-4 py-1 mb-2" type="text" name="titreMessage" placeholder="Sujet:">
                        </div>
                        <div class="wrapinput">
                            <textarea class="inputm border border-muted rounded w-100 px-4 pt-1 pb-5 fs-6 fw-bold" name="mesage" placeholder="Message"></textarea>
                        </div>
                        <div class="containerbutton w-100 d-flex-wrap justify-content-center pt-4">
                            <button class="w-100 h-100 p-3 fs-5 text-white rounded" style="background-color:#846add" name="envoimessage">
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
                <!---------------------------------------------------------------------->
            </div>
        </div>
    </section>

    <?php
    include "../accueil/footer.php";
    ?>
