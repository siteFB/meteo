<?php
session_start();

//Protéger la validation avec le bouton
if (isset($_POST['btnConnexion'])) {

if (isset($_POST) && !empty($_POST)) {
    if (
        isset($_POST["email"], $_POST["pass"])
        && !empty($_POST["email"] && !empty($_POST["pass"]))
    ) {

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("L'adresse mail est invalide");
        }

        require_once "../base/connexionBDD.php";

        $connexionCompte = $db->prepare("SELECT * FROM `users` WHERE `email`= :email");
        $connexionCompte->bindValue(':email', $_POST['email']);
        $connexionCompte->execute();
        $user = $connexionCompte->fetch();

        if (!$user) {
            die("Cet utilisateur et/ou le mot de passe est incorrect!");
        }

        if (!password_verify($_POST["pass"], $user["pass"])) {
            die("Cet utilisateur et/ou le mot de passe est incorrect2!");
        }

        $_SESSION["user"] = [
            "id" => $user["idUser"],
            "pseudo" => $user["pseudo"],
            "email" => $user["email"],
            "pass" => $user["pass"],
            "dateInscrit" => $user["dateInscrit"],
            "statut" => $user["statut"]
        ];
       
    }

        //Redirection selon le statut
        //Protéger les champs vides avec la session
        if (isset($_SESSION['user']) && $user["statut"] == "Membre") {
            header("Location: ../espaces/espaceMembres/espaceMembre.php");

        } elseif (isset($_SESSION['user']) && $user["statut"] == "Admin") {
            header("Location: ../espaces/espaceAdminister/espaceAdmin.php");
            
        } else {
            header("Location: ../../formulaires/formConnexion.php");
            die('Vous devez remplir tous les champs');
        }
    }

//Redirection si le bouton n'est pas utilisé  
}else{
    header("Location: ../../formulaires/formConnexion.php");
    die(); 
}
?>
