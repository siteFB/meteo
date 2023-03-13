<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: ../../formulaires/formConnexion.php");
  die(); 
  exit;
}

require_once('../../base/connexionBDD.php');

$sql = 'SELECT * FROM `users`';

$query = $db->prepare($sql);

$query->execute();

$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('../../base/deconnexionBDD.php');
?>
<?php

$titre = "Espace administrateur/Liste des inscrits";
$gererTitre = "Liste des inscrits";

include "../../accueil/header.php";
?>
<link rel="stylesheet" href="../../boot.css">

<?php
include "../../accueil/navbar.php";
include "../../accueil/titre.php";
include "../bienvenu.php";
include "../gererTitre.php";
?>

<section>
  <div class="container mb-5">
    <div class="table-responsive">
      <table class="table table-bordered table-striped m-5">
        <thead class="table__head bg-warning">
          <tr class="winner__table">
            <th>id</th>
            <th><i class="fa fa-user" aria-hidden="true">&ensp;</i>Pseudo</th>
            <th><i class="fa fa-envelope" aria-hidden="true">&ensp;</i>Email</th>
            <th><i class="fa fa-calendar" aria-hidden="true">&ensp;</i>Date</th>
            <th><i aria-hidden="true">&ensp;</i>Role</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($result as $user) {
          ?>
            <tr>
              <td><?php echo $user['idUser'] ?></td>
              <td><?php echo $user['pseudo'] ?></td>
              <td><?php echo $user['email'] ?></td>
              <td><?php echo $user['dateInscrit'] ?></td>
              <td><?php if ($user["statut"] == "Admin") {
                    echo ' <p class="text-danger">' . $user["statut"] . '</p>';
                  } else {
                    echo ' <p class="text-primary">' . $user["statut"] . '</p>';
                  }; ?>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php
include "../../accueil/footer.php";
?>