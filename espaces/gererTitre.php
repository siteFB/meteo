<span class="d-flex justify-content-center">
    <h2 class="text-center pb-4 mx-4"><?php echo $gererTitre ?></h2>
    <?php

    if ($_SESSION["user"]['statut'] == "Membre") {

        echo "
        <div>
            <button type='button' class='btn btn-success'><a class='text-white' href='espaceMembre.php'>Retour</a></button>
        </div>
               ";
    } else {
        if ($_SESSION["user"]['statut'] == "Admin") {
            echo "    
            <div>
            <button type='button' class='btn btn-success'><a class='text-white' href='espaceAdmin.php'>Retour</a></button>
        </div>
               ";
        }
    }
    ?>
</span>