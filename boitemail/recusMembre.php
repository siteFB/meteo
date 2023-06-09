<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../formulaires/formConnexion.php");
    die();
}

require_once('../base/connexionBDD.php');

if (isset($_SESSION['user']['id']) and !empty($_SESSION['user']['id'])) {

    $id_destinataire = strip_tags($_SESSION['user']['id']);

    $msg = $db->prepare("SELECT  pseudo, idMessagerie, id_expediteur, titreMessage, dateMess 
                         FROM `messagerie`
                         LEFT JOIN users
                         ON users.idUser = messagerie.id_expediteur
                         WHERE `id_destinataire` = :id_destinataire 
                         ORDER BY dateMess
                         DESC
                     ");
    $msg->bindValue(':id_destinataire', $id_destinataire, PDO::PARAM_INT);
    $msg->execute();
    $msg_nbr = $msg->rowCount();
    $msg->fetch();

    if ($msg_nbr == 0) {
        $_SESSION['message'] = "Vous n'avez aucun message";
    }
}
?>

<?php
$titre = "Espace Membre";

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

    <span class="d-flex justify-content-end mx-5">
        <?php
        if (isset($_SESSION["user"]) && ($_SESSION["user"]["statut"] == "Membre")) {
            echo "
            <div>
                <button type='button' class='btn btn-success'><a class='text-white' href='../espaces/espaceMembres/espaceMembre.php'>Retour</a></button>
            </div>
                   ";
        } else {
            header('Location: ../../../formulaires/formConnexion.php');
        }
        ?>
    </span>

    <h2 class="text-center pb-4 mt-2 mb-5 text-primary">Espace messagerie</h2>
    <div class="container mb-5">
        <!----------------------------------------------------------------------------->
        <div class="col-md-12 pb-4">
            <div>
                <div class="row bg-white border border-muted rounded px-3">
                    <!----------------------------------------------------------------------------->
                    <div class="col-md-3">
                        <div>
                            <ul class="nav flex-column mt-5">
                                <li><a href="/boitemail/ecrireMembre.php" class="btn btn-block btn-primary text-white my-4" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;ÉCRIRE&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                                <li class="mt-3 mb-3"><a class="fs-5" href="/boitemail/recusMembre.php">Messages (<?php echo $msg_nbr; ?>)</a></li>
                            </ul>
                        </div>
                    </div>
                    <!----------------------------------------------------------------------------->
                    <div class="col-md-9 my-5 bg-light p-3">
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
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <?php
                                    while ($m = $msg->fetch()) {
                                    ?>
                                        <tr>
                                            <th class="fs-5"><?php echo $m['pseudo']; ?></th>
                                            <td><a class="fs-5" href="detailsAdmin.php?idUser=<?php echo $m['id_expediteur']; ?>"><?php echo $m['titreMessage']; ?></a></td>
                                            <td class="time"><?php echo $m['dateMess']; ?></td>
                                            <td><a class="fs-5 text-secondary" onclick="return confirm('Voulez-vous supprimer ce message?')" href="supprMessAdmin.php?idUser=<?php echo $m['idMessagerie']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!----------------------------------------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "../accueil/footer.php";
?>