<!-- < ?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../formulaires/formConnexion.php");
    die();
    exit;
}
require_once('../base/connexionBDD.php');

if(isset($_SESSION['user']['id']) AND !empty($_SESSION['user']['id'])){

$msg = $db->prepare('SELECT * FROM `messagerie` WHERE `id_destinataire` = ?');
$msg->execute(array($_SESSION['user']['id']));  //??????$msg->execute(array($_SESSION[['id']));  ?????
$msg_nbr = $msg->rowCount();
}

?>
< !--
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boite de réception</title>
 </head>
 <body>
    
<a href="envoi.php">Envoyer un nouveau message</a> <h3>Votre boite de réception</h3>

< !-------------- Récupérer le pseudo de l'expéditeur ------ >
< ?php 
if($msg_nbr == 0) { echo "Vous n'avez aucun message";  }
while($m = $msg->fetch()) {    
    $p_exp = $db->prepare('SELECT `pseudo` FROM users WHERE idUser = ?');
    $p_exp->execute(array($m['id_expediteur']));   
    $p_exp = $p_exp ->fetch();
    $p_exp = $p_exp['pseudo']; 
    ?>

< !------------ Afficher le pseudo de l'expéditeur ---------- >
< ?php echo "$p_exp"; ?> vous a envoyé un nouveau message:
< ?php echo $m['mesage'] ;  ?>

< ?php } ?>


 </body>
 </html>

< ?php
}    $error = "Compte inexistant";
?>
-->

