<!-- < ?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../formulaires/formConnexion.php");
    die();
    exit;
}

require_once('../base/connexionBDD.php');

if(isset($_SESSION['user']['id']) AND !empty($_SESSION['user']['id'])){
if(isset($_POST['envoi_message'])){
if(isset($_POST['destinataire'], $_POST['titreMessage'], $_POST['message']) 
AND !empty($_POST['destinataire']) AND !empty($_POST['titreMessage']) AND !empty($_POST['message'])){
    $destinataire = htmlspecialchars($_POST['destinataire']) ;
    $titreMessage = htmlspecialchars($_POST['titreMessage']);
    $message = htmlspecialchars($_POST['message']);

    // Récupérer l'ID du destinataire
$id_destinataire = $db->prepare('SELECT idUser FROM users WHERE pseudo= ?');
$id_destinataire->execute(array($destinataire));
$dest_exist = $id_destinataire->rowCount();

// Interdire l'injection html et error "Utilisateur inexistant"
if($dest_exist ==1){
$id_destinataire = $id_destinataire->fetch();
$id_destinataire = $id_destinataire['idUser'];

// insérer le message
$ins = $db->prepare('INSERT INTO `messagerie` (id_expediteur, id_destinataire, titreMessage, mesage) VALUES (?, ?, ?, ?)');
$ins->bindValue(1, $_SESSION['user']['id'], PDO::PARAM_INT);
$ins->bindValue(2, $id_destinataire, PDO::PARAM_INT);
$ins->bindValue(3, $titreMessage, PDO::PARAM_STR);
$ins->bindValue(4, $message, PDO::PARAM_STR);
$ins->execute(array($_SESSION['user']['id'], $id_destinataire, $titreMessage, $message));

$_SESSION['message'] = "Message envoyé";
header("Location: ../boitemail/ecrire.php");

}else {
    $_SESSION['erreur'] = "Utilisateur inexistant";
    header("Location: ../boitemail/ecrire.php");
}

}else {
    $_SESSION['erreur'] = "Remplir tous les champs";
    header("Location: ../boitemail/ecrire.php");
}

}

$destinataires = $db->query('SELECT pseudo FROM users ORDER BY pseudo');

?>

< ?php
}    else {
    $_SESSION['erreur'] = "Compte inexistant";
    header("Location: ../formulaire/formConnexion.php");
}
?>


< !--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de message</title>
</head>

<body>

    <form action="" method="POST">
    < ?php
        if (!empty($_SESSION['erreur'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
            $_SESSION['erreur'] = "";
        }
        ?>
        < ?php
        if (!empty($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
            $_SESSION['message'] = "";
        }
        ?>
        <label for="">Destinataire</label>
       < !--- <select name="destinataire">

        < ?php while($d = $destinataires->fetch()) { ?>
                <option>< ?php echo $d['pseudo'] ?></option>
        < ?php } ?> 
        </select>  --- >
<input type="text" name="destinataire"><br><br>
<input type="text" placeholder="Sujet" name="titreMessage">
        <br><br>
        <textarea placeholder="votre message" name="message"></textarea>
        <br><br>
        <input type="submit" value="Envoyer" name="envoi_message">
        <br><br>
        < ?php if(isset($error)) {echo '<span style="color:red">'. $error. '</span>'; } ?>
    </form>
<a href="../formulaires/deconnexion.php">dec</a>
</body>

<a href="reception.php">Voir mes messages reçus</a>

</html>

< ?php
}    else {
    $_SESSION['erreur'] = "Compte inexistant";
}
?>

-->