<?php
    // On inclut le fichier de connexion à la base de données
    require_once("../config/bdd.php");

    // Requête SQL
    $sql = "SELECT com_mail, com_mdp, com_id FROM compte";

    // Préparation de la requête
    $stmt = $bdd->prepare($sql);

    // Récupération des données du formulaire
    $com_mail = $_POST["email"];
    $mdp = $_POST["password"];

    function verifCompte($com_mail, $mdp, $bdd) {
        // Requête SQL
        $sql = "SELECT * FROM compte WHERE com_mail = :com_mail AND com_mdp = :mdp";

        // Préparation de la requête
        $stmt = $bdd->prepare($sql);
        $stmt->bindValue(':com_mail', $com_mail);
        $stmt->bindValue(':mdp', $mdp);
        $stmt->execute();

        if($stmt->rowCount() == 0) {
            echo("<div class='erreur'>");
            echo("<p>Erreur de connexion</p>");
            echo("<br>");
            echo("<a href='seConnecter.php'>Retour à la page de connexion</a>");
            echo("</div>");
        }

        foreach($stmt as $ligne) {
            echo($ligne["com_mail"]);

            // On démarre la session
            session_start();

            // On enregistre les paramètres de notre visiteur comme variables de session
            $_SESSION['com_mail'] = $ligne["com_mail"];
            $_SESSION['com_mdp'] = $ligne["com_mdp"];
            $_SESSION['com_nom'] = $ligne["com_nom"];
            $_SESSION['com_prenom'] = $ligne["com_prenom"];
            $_SESSION['com_id'] = $ligne["com_id"];

            // On redirige notre visiteur vers une page de notre section membre
            header('Location: /website/index.php');
        }
        
    }

    verifCompte($com_mail, $mdp, $bdd);

?>