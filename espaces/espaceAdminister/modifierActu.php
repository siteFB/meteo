<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../../formulaires/formConnexion.php");
}

if ($_POST) {
    if (
        isset($_POST['idEphemeride']) && !empty($_POST['idEphemeride'])
        && isset($_FILES['imgTemps']) && !empty($_FILES['imgTemps'])
        && isset($_POST['titre']) && !empty($_POST['titre'])
        && isset($_POST['topo']) && !empty($_POST['topo'])
    ) {

        require_once('../../base/connexionBDD.php');

        $id = strip_tags($_POST['idEphemeride']);
        $titre = strip_tags($_POST['titre']);
        $topo = strip_tags($_POST['topo']);

        $image = $_FILES['imgTemps']['name'];
        $tmp_name = $_FILES['imgTemps']['tmp_name'];
        $size = $_FILES['imgTemps']['size'];
        $error = $_FILES['imgTemps']['error'];

    
        $sql = 'UPDATE `ephemeride` SET `imgTemps`=:imgTemps, `titre`=:titre, `topo`=:topo WHERE `idEphemeride`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':imgTemps', $image, PDO::PARAM_STR);
        $query->bindValue(':titre', $titre, PDO::PARAM_STR);
        $query->bindValue(':topo', $topo, PDO::PARAM_STR);

        $query->execute();


// Upload de l'image et vérifier chaque clé: name, type, fichier temp, error et taille
if (isset($_FILES['imgTemps']) &&  !empty($_FILES['imgTemps']['tmp_name'])) {

    if (is_uploaded_file($_FILES['imgTemps']['tmp_name'])) {  // clé error
		$types_autorises = ['image/png', 'image/jepg', 'image/jpg']; // Formats
        $typeMime = mime_content_type($_FILES['imgTemps']['tmp_name']);
        if(!in_array($typeMime, $types_autorises)){

            $size = filesize($_FILES['imgTemps']['tmp_name']);  //taille
            if($size > 10000){ 
                $message = "L'image ne doit pas dépasser 10000 octets soit 10ko ";
            
                }else{  // nom et temp avant envoi
                // Nettoyer le fichier, sécurité
                $nomAvantNettoyage = $_POST['fileName'];
                                
                $nomEnCoursDeNettoyage = preg_replace('~[\\pL\d]+~u', '-', $nomAvantNettoyage);
                                
                $nomEnCoursDeNettoyage = trim($nomEnCoursDeNettoyage, '-'); 
                                
                $nomEnCoursDeNettoyage = iconv('utf-8', 'us-ascii//TRANSLIT', $nomEnCoursDeNettoyage);
                                
                $nomEnCoursDeNettoyage = strtolower($nomEnCoursDeNettoyage);

                $nomNettoye = preg_replace('~[^-\w]+~', '', $nomEnCoursDeNettoyage);

                //Construire le chemin de l'extension et sécuriser
                $extension = substr(strrchr($_FILES['imgTemps']['tmp_name'], "."), 1);
                $cheminDeDestination = '../../images/'.$nomNettoye. '.' .$extension;

                // Définitif         
                $moveIsOk = move_uploaded_file($_FILES['imgTemps']['tmp_name'], $cheminDeDestination);
                    if ($moveIsOk) {
                        $message = "Image déplacée avec succès"; 
                        } else {
                             $message = 'echec, l\'image n\'a pas pu être déplacée';
                                }
                }
}else{
    $message = "Il faut obligatoire une image de type png, jpeg ou jpg";
}

   } else {
        $message = "Un problème a eu lieu lors de l'upload";
    }
} else {
    $message = "Aucune image à télécharger";
}


//Renommer l'image et envoi
$cheminEtNomTemporaire = $_FILES['imgTemps']['tmp_name'];

$extension=substr(strrchr($_FILES['imgTemps']['name'], "." ), 1);

$nouveauNom = $_POST['fileName']. '.' .$extension;

$cheminEtNomDefinitif = '../../images/' . $nouveauNom; 

$moveIsOk = move_uploaded_file($cheminEtNomTemporaire, $cheminEtNomDefinitif);

if ($moveIsOk) {
    $message = "L'image est uploadée";
    
} else {
    $message = 'echec de l\'upload';
}




        $_SESSION['message'] = "L'éphéméride' est modifiée";
        require_once('../../base/deconnexionBDD.php');

        header('Location: gererActu.php');

    } else {
        $_SESSION['erreur'] = "Formulaire incomplet";
    }
}

if(isset($_GET['idEphemeride']) && !empty($_GET['idEphemeride'])) {
    require_once('../../base/connexionBDD.php');

    $id = strip_tags($_GET['idEphemeride']);

    $sql = 'SELECT * FROM `ephemeride` WHERE `idEphemeride`=:id';

    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $ephemeride = $query->fetch();


    if (!$ephemeride) {
        $_SESSION['erreur'] = "Cette éphéméride n'existe pas";
        header('Location: gererActu.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: gererActu.php');
}
?>

<?php
//var_dump($_FILES);
?>

<?php
$titre = "Espace administrateur/Gérer l'actualité";
$gererTitre = "Modifier l'éphéméride";

include "../../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">

<?php
include "../../accueil/navbar.php";
include "../../accueil/titre.php";
include "../bienvenu.php";
include "../retourEphemeride.php";
?>

<section>
    <main class="container mb-5 w-25" id="actuE23">
        <div>
            <section>
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imgTemps"></label>
                        <input type="file" id="imgTemps" name="imgTemps" class="form-control mb-2" value="../../images/'<?php echo strip_tags($ephemeride["imgTemps"]) ?>" accept="image/png, image/jpeg, image/jpg">
                    </div>
                    <div>
                    <div>
                        <label for="fileName">Nommer l'image <i>(facultatif)</i></label><br>
                        <input type="text" id="fileName" name="fileName" class="form-control mb-4" value=""> 
                    </div>
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" id="titre" name="titre" class="form-control mb-4" placeholder="Titre" value="<?php echo strip_tags($ephemeride["titre"]) ?>">
                    </div>
                    <div class="form-group">
                        <label for="topo">Topo</label>
                        <input type="textarea" placeholder="Topo" id="topo" name="topo" class="form-control mb-4" placeholder="Topo" value="<?php echo strip_tags($ephemeride["topo"]) ?>">
                    </div>
                    </div>
                    <br>
                    <input type="hidden" name="idEphemeride" value="<?php echo strip_tags($ephemeride['idEphemeride']) ?>">
                    <button class="btn btn-primary">Modifier</button>
                </form>
            </section>
        </div>
    </main>
</section>

<?php
include "../../accueil/footer.php";
?>