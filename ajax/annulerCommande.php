<?php

    include("../config.php");    

    if(isset($_GET['idCommande'])){

        $numCmd = htmlspecialchars($_GET['idCommande']); // verifie si la commande en toujours en attente
        $verif = $bdd->prepare("SELECT statut_commande FROM commande WHERE code_commande = ? AND statut_commande = ?"); 
        $verif->execute(array($numCmd, 'En attente')); 
        $res = $verif->rowCount(); 

        if($res > 0){
                
                $annulCmd = $bdd->prepare("UPDATE commande SET statut_commande = ? WHERE code_commande = ?"); 
                $annulCmd->execute(array("Annulée", $numCmd)); 
                header("location: historique_client.php"); 
        }
        else{
                header("location: historique_client.php"); 
        }
    }
?>
