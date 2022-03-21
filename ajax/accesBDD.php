<?php 
    
function getLesCommandesByIdClient($code_client) {

    $lesCommandes = null;

    include('./config.php');

    $requete = "SELECT * from commande Where code_client_commande = '$code_client' ORDER BY date_commande DESC";
    $resultat = $bdd->query($requete);
    $lesCommandes = $resultat->fetchAll();

    return $lesCommandes;
}
   

function GetContenuCommande() {
    
    $idCommande = $_GET['idCommande']; 
    
    include("../config.php");    

    $requete = "SELECT commande from commande where id_commande = '$idCommande'";
    $resultat = $bdd->query($requete);


    $contenu = $resultat->fetch(PDO::FETCH_ASSOC);
    echo json_encode($contenu);

}

function GetDateById() {

    $idCommande = $_GET['idCommande']; 
    
    include("../config.php");    

    $requete = "SELECT date_commande from commande where id_commande = '$idCommande'";
    $resultat = $bdd->query($requete);

    $date = $resultat->fetch(PDO::FETCH_ASSOC);
    echo json_encode($date);
}

function GetPrix() {

    $idCommande = $_GET['idCommande']; 
    
    include("../config.php");    

    $requete = "SELECT prix_commande from commande where id_commande = '$idCommande'";
    $resultat = $bdd->query($requete);


    $prix = $resultat->fetch(PDO::FETCH_ASSOC);
    echo json_encode($prix);
}

function GetStatut() {

    $idCommande = $_GET['idCommande']; 
    
    include("../config.php");    

    $requete = "SELECT statut_commande from commande where id_commande = '$idCommande'";
    $resultat = $bdd->query($requete);


    $statut = $resultat->fetch(PDO::FETCH_ASSOC);
    echo json_encode($statut);
}
?>