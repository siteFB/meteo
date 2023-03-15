<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../formulaires/formConnexion.php");
    die();
}

if (isset($_GET['idUser']) && !empty($_GET['idUser'])) {
    require_once('../base/connexionBDD.php');

    $id = strip_tags($_GET['idUser']);
    $id_destinataire = strip_tags($_SESSION['user']['id']);

    $msg = $db->prepare('SELECT pseudo, titreMessage, idMessagerie, mesage, dateMess
                         FROM messagerie
                         LEFT JOIN users
                         ON users.idUser = messagerie.id_expediteur
                         WHERE messagerie.id_expediteur = :idUser AND id_destinataire = :id_destinataire
                         ORDER BY dateMess
                         DESC
                         ');

    $msg->bindValue(':idUser', $id, PDO::PARAM_INT);
    $msg->bindValue(':id_destinataire', $id_destinataire, PDO::PARAM_INT);

    $msg->execute();

    $msg_nbr = $msg->rowCount();   // nb de messages d'un seul expéditeur

    $resultat = $msg->fetchAll(PDO::FETCH_ASSOC);

    /*echo '<pre>';
    print_r($resultat); 
    print_r($resultat[0]['pseudo']);
    print_r($_GET['idUser']);
    echo '</pre>';*/

    if (!$resultat) {
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: /boitemail/recusMembre.php');
    }
}

$titre = "Espace membre";

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

<section>
    <h2 class="text-center pb-4 mt-2 mb-5 text-primary">Espace messagerie</h2>
    <div class="container mb-5">
        <!----------------------------------------------------------------------------->
        <div class="col-md-12 pb-4">
            <div>
                <div class="row bg-white border border-muted rounded">
                    <!----------------------------------------------------------------------------->
                    <div class="col-md-3">
                        <div>
                            <ul class="nav flex-column mx-3">
                                <li> <a href="/boitemail/ecrireMembre.php" class="btn btn-block btn-primary text-white my-4" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;ÉCRIRE&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                                <li class="mt-3 mb-3"><a class="fs-5" href="/boitemail/recusMembre.php">Messages</a></li>
                            </ul>
                        </div>
                    </div>
                    <!----------------------------------------------------------------------------->
                    <div class="bg-light border border-muted rounded col-10 mx-auto col-lg-7 pt-4 pb-2 mt-4 mb-4">
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
                        <div>

                            <div class="wrapinput mb-5">
                                <label for="auteur">Expéditeur</label>
                                <?php
                                if (!$msg_nbr == 0) {
                                ?>
                                    <input class="inputm d-block border border-muted rounded w-100 fs-5 px-4 p-3 text-primary fw-bold" id="auteur" type="text" name="expediteur" value="<?php echo $resultat[0]['pseudo'] ?> (<?php echo $msg_nbr; ?>)">
                                <?php
                                } else {
                                    $_SESSION['message'] = "Vous n'avez aucun message de cet utilisateur";
                                    header('Location: /boitemail/recusAdmin.php');
                                }
                                ?>
                            </div>
                            <?php
                            foreach ($resultat as $result) {
                            ?>
                                <div class="wrapinput">
                                    <input class="inputm d-block border border-muted rounded w-100 fs-6 fw-bold px-2 py-1 bg-light" type="text" name="titreMessage" value="<?php echo $result['titreMessage'] ?>">
                                </div>
                                <div class="wrapinput">
                                    <textarea class="inputm border border-muted rounded w-100 px-4 pt-1 pb-5 fs-6 fw-bold" type="text" name="message" value="mesage"><?php echo $result['mesage'] ?></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <p class="pt-2 px-2 text-end time"><?php echo $result['dateMess']; ?></p>
                                    <p class=" pt-2 px-2"><a class="fs-5 text-secondary text-primary" onclick="return confirm('Voulez-vous supprimer ce message?')" href="supprMessMembre.php?idUser=<?php echo $result['idMessagerie']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!----------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</section>