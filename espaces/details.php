<?php
session_start();

if(isset($_GET['idEphemeride']) && !empty($_GET['idEphemeride'])){
    require_once('../base/connexionBDD.php');

    $id = strip_tags(stripslashes(htmlentities(trim($_GET['idEphemeride']))));

    $sql = 'SELECT `imgTemps` FROM `Ephemeride` WHERE `idEphemeride` = :id;';

    $query = $db->prepare($sql);
    
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    $query->execute();

    $produit = $query->fetch();

    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: consulterMeteo.php');
    }
    
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: consulterMeteo.php');
}
?>
<?php
$titre = "Espace consulter la météo: détails";

include "../accueil/header.php";
?>
<link rel="stylesheet" href="../boot.css">
<?php
include "../accueil/navbar.php";
include "../accueil/titre.php";
include "bienvenu.php";
?>

<span class="d-flex justify-content-end mb-5 mx-5">
    <?php
    echo "
        <div>
            <button type='button' class='btn btn-success mx-4'><a class='text-white' href='consulterMeteo.php'>Retour</a></button>
        </div>
               ";
    ?>
</span>

<div class="row ">
    <div class="col-4 mx-auto text-center mb-3">
        <img src="../images/<?php echo strip_tags(stripslashes(htmlentities(trim($produit['imgTemps'])))) ?>" style="height:60vh; width:70vh" class="pb-3 mb-5">
    </div>
</div>

<?php
include "../accueil/footer.php";
?>