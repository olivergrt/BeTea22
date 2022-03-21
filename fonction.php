<?php

function ConnexionDB(){  
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=betea;charset=utf8', 'root', '');
	return $bdd; 
}

//verifie si  la Session du client est active
function ClientExist(){
    if(!isset($_SESSION['idClient'])){
        header("Location: connexion.php");  
    }
}

function SelectInfoClient(){
    $code_client = $_SESSION['idClient'];
    $infoClient = ConnexionDB()->query("SELECT id_client,nom_client,prenom_client,mail_client,mdp_client,nbr_point_client,chemin_qr_code FROM client WHERE code_client = '$code_client'"); 
    $info = $infoClient->fetch();
    return $info; 
}


//page de connexion
function ConnexionClient(){

	if(isset($_POST['submit'])){
	    if(!empty($_POST['email']) AND !empty($_POST['password'])){
	        
            $email =  htmlspecialchars($_POST['email']); 
			$pwd = sha1($_POST['password']); 
			$reqVerifEmail = ConnexionDB()->prepare("SELECT id_client, code_client FROM client WHERE mdp_client = ? AND mail_client = ?"); 
			$reqVerifEmail->execute(array($pwd, $email)); 
			$res = $reqVerifEmail->rowCount(); 
			
            if ($res == 1) {
				$info = $reqVerifEmail->fetch();
				$_SESSION['idClient'] = $info['code_client']; 
				header("Location: ./accueil");
			}
			else{
				$error = "Identifiant ou mot de passe incorect !";
			}
	   	}
	}
}



////////////////////////////////////
// Fonctions pour la page d'acceuil 
//////////////////////////////////////

function GetPointEnAttente($code_client){
    $req_point_en_attente = ConnexionDB()->query("SELECT SUM(point_en_attente) FROM commande WHERE code_client_commande = '$code_client' AND statut_commande != 'Annulee'");
    $pointEnAttente = $req_point_en_attente->fetch();  
    return $pointEnAttente; 
}

// Selectionne le nom du rang qui conresspond au palier des points du client (DESC pour ordonner les rang du + grand au + petit)
function GetLibelleRangByID($points_client){
    $infoRang = connexionDB()->query("SELECT libelle_rang FROM rang WHERE palier <= $points_client  ORDER BY id_rang DESC LIMIT 1"); 
    $rang = $infoRang->fetch(); 
    return $rang;  
}

// Verifie si le code avantages est deja généré
function verifCodeAvantages($code_client){
    $verifCodeAvantages = connexionDB()->query("SELECT * FROM avantages WHERE code_client_avantages = '$code_client'");
    $resVerifCodeAvantages = $verifCodeAvantages->rowCount();
    return $resVerifCodeAvantages; 
}
//
function InfoAvantages($code_client){
    $verifCodeAvantages = connexionDB()->query("SELECT * FROM avantages WHERE code_client_avantages = '$code_client'");
    $infoAvantages = $verifCodeAvantages->fetch();
    return $infoAvantages; 
}
function InsertCodeAvantages($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration){
    $InsertCodeAvantages = connexionDB()->prepare("INSERT INTO avantages (code_avantages,code_client_avantages,rang_avantages,date_expiration) VALUES (?,?,?,?)");
    $InsertCodeAvantages->execute(array($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration));
} 

// suppression de l'ancien code pour le remplacer
 function deleteCodeAvantage($code_client){
    $deleteCodeAvantage = connexionDB()->query("DELETE FROM avantages WHERE code_client_avantages = '$code_client'");
    
} 

function DateExpire($code_client){ 
    $reqExpiration = connexionDB()->query("SELECT date_expiration FROM avantages WHERE code_client_avantages = '$code_client'");
    $resExpiration = $reqExpiration->fetch();
    return $resExpiration;
}
function InsertNewCodeAvantage($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration){
    $InsertCodeAvantages = connexionDB()->prepare("INSERT INTO avantages (code_avantages,code_client_avantages,rang_avantages,date_expiration) VALUES (?,?,?,?)");
    $InsertCodeAvantages->execute(array($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration));
}


//////////////////////////////////////////////////////////
//---- Fonctions pour le panier du client ---------------
/////////////////////////////////////////////////////////


// compte le nombre d'article present dans le panier
function GetNbrProduitPanier(){

    $nbArticle = 0;
    if(isset($_SESSION['panier'])){
        foreach ($_SESSION['panier'] as $id_pdt => $qte) {
            $reqInfoPdtPanier = connexionDB()->query("SELECT COUNT(id_produit) FROM produit WHERE id_produit = $id_pdt");
            $res = $reqInfoPdtPanier->fetch();
            $nbArticle += $res['COUNT(id_produit)'] * $qte;
        } 
    }
    return $nbArticle;
}

function ErrorMessage(){
	if(isset($ErrorMessage))
	{ 
		echo $ErrorMessage;
	}
}

function PanierExist(){
	if(empty($_SESSION['panier'])){
        header("Location: commander.php");
    }
}

function AjoutPanier(){

    if(isset($_GET['categorie']) AND isset($_GET['produit']) AND !empty($_GET['produit'])){

        $qte = 1; 
        $id_pdt = $_GET['produit']; 

        $reqInfoProduit = ConnexionDB()->query("SELECT libelle_produit,disponibilite_produit,masquer_produit FROM produit WHERE id_produit = $id_pdt"); 
        $resInfoPdt = $reqInfoProduit->fetch();

            if($resInfoPdt == true){
            
                $libelle_produit = $resInfoPdt["libelle_produit"];
                
                if($resInfoPdt['disponibilite_produit'] == "Disponible" AND $resInfoPdt['masquer_produit'] == "Non"){  // si le produit est bien disponible et n'est pas masqué 

                    $p = new Panier; 
                    $p->ajouter($id_pdt,$qte);

                    if(isset($_SESSION['CodeAvantage'])){ // permet l'ajout d'un article depuis l'espace panier

                        header("location: ./mon-panier");
                    }
                    else{
                    header("Location: ./commander-categorie-". $_GET['categorie']);  

                    }
                }
                else{
                    $error = "<h5>Malheureusement ce produit n'est plus disponible</h5>"; 
                    header("Refresh: 10, ./commander-categorie-". $_GET['categorie']);  
                }
            }
            else{
                 $error = "<h5>Malheureusement ce produit n'existe pas</h5>"; 
                header("Refresh: 10, ./commander-categorie-". $_GET['categorie']);
            }

    }
}

function AugmenterQuantite(){

	if (isset($_GET['ajouter'])) { // Augmente la quantité
        if (!empty($_GET['ajouter'])) {
            
            $id = $_GET['ajouter']; 
            $reqDispo = ConnexionDB()->prepare("SELECT disponibilite_produit FROM produit WHERE id_produit = ?"); 
            $reqDispo->execute(array($id));
            $resDispo = $reqDispo->fetch();
            
            if($resDispo['disponibilite_produit'] == "Disponible"){
                $panier = new Panier; 
                $panier->ajouterQte($id); 
                header("Location: ./mon-panier");
            }
            else{
                echo "Produit indisponible";
                header("Location: ./mon-panier");
            }
        }
    }
}

function ReduireQuantite(){

	if (isset($_GET['retirer'])) {     // Reduit la quantité
        if (!empty($_GET['retirer'])) {

            $id = $_GET['retirer']; 
            $panier = new Panier;
            $panier->retirerQte($id); 

            if($_SESSION['cookieOFFERT']){
                unset($_SESSION['CodeAvantage']); 
                unset($_SESSION['cookieOFFERT']);   
            } 
            header("Location: ./mon-panier");  
        }
    }
}

function ViderPanier(){

	if(isset($_POST['viderPanier'])){ // vide le panier

        $v = new Panier; 
        $v->vider();
        unset($_SESSION['TotalCodePromo']); 
        
        if($_SESSION['cookieOFFERT']){
            unset($_SESSION['TotalCodePromo']);
            unset($_SESSION['CodeAvantage']); 
            unset($_SESSION['cookieOFFERT']);   
        }
        header("Location: commander.php");
    }
}

function RetirerArticlePanier(){
	if (isset($_GET['supprimer'])) {   // Retirer un article du panier
        
        if (!empty($_GET['supprimer'])) {    
            $id = $_GET['supprimer']; 
            $panier = new Panier; 
            $panier->retirer($id); 
            
            if($_SESSION['cookieOFFERT']){
                unset($_SESSION['CodeAvantage']); 
                unset($_SESSION['cookieOFFERT']);   
            }
            header("Location: ./mon-panier");
        }
    }
}

function GetPromotion($code_prm){
    $infoPromo = ConnexionDB()->query("SELECT reduction FROM code_promotionnel where code_promo = '$code_prm'");
    $info_promo = $infoPromo->fetch();
    return $info_promo;  
}

function GetRangAvantage($code_avantage){
    $infoAvantage = ConnexionDB()->query("SELECT rang_avantages FROM avantages where code_avantages = '$code_avantage'");
    $info_avtg = $infoAvantage->fetch(); 
    $rangAvtg = $info_avtg['rang_avantages'];
    return $rangAvtg; 
}

function GetNbPoint($codeClient){
    $reqNbPoint = ConnexionDB()->query("SELECT nbr_point_client FROM client WHERE code_client = '$codeClient'"); 
    $resNbPoint = $reqNbPoint->fetch(); 
    return $resNbPoint; 
}

// Finalisation et enregistrement de la commande 
function FinaliserCommande(){

	if (isset($_POST['btn_finaliser'])) {
        
        $produit_indispo = ""; //
        $resReqNumCmd = 1; // intialisation de variables pour la suite 
        $numCommande = ""; //

            
        while ($resReqNumCmd == 1) { //Creation du numéro de commmande 
            
            $commande = ""; 
            $numero  = ""; 

            for ($i=0; $i < 8 ; $i++) { 
                $numero  .= mt_rand(10, 99); 
            
            }       
            // Verification si le numero de commande généré existe déja pour une commande
            $verifNumCmd = ConnexionDB()->query("SELECT code_commande FROM commande WHERE code_commande = $numero");
            $resReqNumCmd = $verifNumCmd->rowCount(); 
        }

        $numCommande .= "BT-".$numero;

        
        $prixTtc = 0;  //initialisation
        $nouveaux_points = 0; 

        //Recuperation du nom et prix du produit appartir de l'ID 
        foreach ($_SESSION['panier'] as $id2 => $qte2) {
            
            $reqInfo = ConnexionDB()->query("SELECT libelle_produit,prix_produit,id_categorie_produit,disponibilite_produit FROM produit WHERE id_produit = $id2"); 
            $resInfo = $reqInfo->fetch();  

            if($resInfo['disponibilite_produit'] == "Disponible"){ // verifie si le produit est bien disponibke

                if($resInfo["id_categorie_produit"] == 1){
                    $nouveaux_points += 10 * $qte2; 
                }
                if($resInfo["id_categorie_produit"] == 2){
                    $nouveaux_points += 5 * $qte2; 
                }

                // Calcule le prix total pour chaque produit
                $prixPdtCommande = intval($qte2) * $resInfo['prix_produit'];  
                $prixTtc += $prixPdtCommande;   
                $commande .= $qte2." ".$resInfo['libelle_produit'].", ";
               
            }
            else{
                $produit_indispo .= $resInfo['libelle_produit']. ", "; // affiche un message d'erreur car produit indispo
            }   
            
        }

    	// si un code promo est utilisé
        if(isset($_SESSION['TotalCodePromo'])){ 
                    
            $code_prm = $_SESSION['TotalCodePromo'];
            $infoPromo = ConnexionDB()->query("SELECT reduction FROM code_promotionnel where code_promo = '$code_prm'");
            $info_promo = $infoPromo->fetch(); 
            $reduc = $prixTtc * $info_promo['reduction'] / 100; 
            $prixTtc = $prixTtc - $reduc;

            //mise a jour du nb d'utilisitation du code dans la table code promo 
            $updateNbUtil = ConnexionDB()->query("UPDATE code_promotionnel SET nbr_utilisation = nbr_utilisation - 1 WHERE code_promo = '$code_prm'");
        }

        // Si  code avantage utilisé
        $codeClient = $_SESSION['idClient'];    
        if(isset($_SESSION['cookieOFFERT']) AND isset($_SESSION['CodeAvantage'])){ // reduction du prix du cookie sur le total;  retire les points et supp code avantages

            $verifCateg = ConnexionDB()->query("SELECT prix_produit FROM produit WHERE libelle_produit = 'Cookie'");
            $resCateg = $verifCateg->fetch(); 
            $prixTtc = $prixTtc - $resCateg['prix_produit'];
            $nouveaux_points = 0 ; 
            $updatePointClient = ConnexionDB()->query("UPDATE client SET nbr_point_client = 0 WHERE code_client = '$codeClient'");
            $delCodeAvantages = ConnexionDB()->query("DELETE FROM avantages WHERE code_client_avantages = '$codeClient'"); 
        }
        

        //////////////////////////
        //Insertion de la commande
        /////////////////////////

        date_default_timezone_set('Europe/Paris');
        $date_commande = date('Y-m-d H:i:s'); 

        $id_client = $_SESSION['idClient'];
        $p = $nouveaux_points;
        
        if(empty($produit_indispo)){
            // // Insertion dans la bdd du numero de cmde + le recapitulatif + prix total + date et heure de cmde
            $insertPdt = ConnexionDB()->prepare("INSERT INTO commande (code_commande,code_client_commande,commande, prix_commande,date_commande,point_en_attente) VALUES (?,?,?,?,?,?)");
            $insert = $insertPdt->execute(array($numCommande,$id_client, $commande, $prixTtc, $date_commande,$p)); 
            
            $noerreur = "La commande a bien été effectuée"; 
            $_SESSION['numero_Commande'] = $numCommande;                 
            
            $v = new Panier; 
            $v->vider();

            header("Location: commande_valide.php"); 
        }
        else{
             $ErrorMessage = "<p class='text-danger'>Le produit : <b>$produit_indispo</b> est indisponible.</p>";


        }
    }
}


function AppliquerCodePromo(){// Bouton appliquer Code promo 

	if(isset($_POST['appliquerCode'])){

        if(!empty($_POST['code_promo'])){

            $code = htmlspecialchars($_POST['code_promo']); 
            $VerifCode = ConnexionDB()->prepare("SELECT code_promo FROM code_promotionnel WHERE code_promo = ? AND valide = ? AND nbr_utilisation > ?");
            $VerifCode->execute(array($code,'oui', 0)); 
            $verifValide1 = $VerifCode->rowCount(); 

            if($verifValide1 > 0){ // verifie s'il s'agit d'un code promo valide  

                $resCode = $VerifCode->fetch();
                $_SESSION['TotalCodePromo'] = $resCode['code_promo'];  ?>
                <script>window.location.replace("./mon-panier");</script>
      <?php
            }
            else{
                echo "<p class='text-danger'>Code promotionnel invalide</p>";
            }
        }    
    }
}

//////////////////////////////////////////////////////////
//---- Fonctions pour la page Historique Commmande ---------------
/////////////////////////////////////////////////////////


function GetAllCommande($code_client){
    $reqAllCmd = ConnexionDB()->query("SELECT code_commande,commande,prix_commande,date_commande,statut_commande FROM commande WHERE code_client_commande = '$code_client' ORDER BY date_commande DESC");
    return $reqAllCmd;  
}


//////////////////////////////////////////////////////////
//---- Fonctions pour la page Parametre ---------------
/////////////////////////////////////////////////////////

function ModifierNom($info,$idC){

    if(isset($_POST['btn_modif_nom'])){

        if(isset($_POST['new_nom']) AND !empty($_POST['new_nom']) AND $_POST['new_nom'] != $info['nom_client']) {
            $newNom = htmlspecialchars($_POST['new_nom']); 
            $insertNom = connexionDB()->prepare('UPDATE client SET nom_client = ? WHERE id_client = ?'); 
            $insertNom->execute(array($newNom, $idC)); 
            header("location: ./accueil");
        }
        else{
                $error = "Veuillez remplir tous les champs.";
        }
    }
}

function ModifierPreom($info,$idC){
    if(isset($_POST['btn_modif_prenom'])){

        if(isset($_POST['newPrenom']) AND !empty($_POST['newPrenom']) AND $_POST['newPrenom'] != $info['prenom_client']) {
            $newPrenom = htmlspecialchars($_POST['newPrenom']);
            
            $insertPrenom = connexionDB()->prepare('UPDATE client SET prenom_client = ? WHERE id_client = ?'); 
            $insertPrenom->execute(array($newPrenom, $idC)); 
            header("location: ./accueil");
        }
        else{
                $error = "Veuillez remplir tous les champs.";
        }
    }
}

function ModifierMail($info,$id){
    if(isset($_POST['btn_modif_mail'])){

        if(isset($_POST['new_mail']) AND !empty($_POST['new_mail']) AND $_POST['new_mail'] != $info['mail_client']) {
            $new_mail = htmlspecialchars($_POST['new_mail']);
            
            $insertMail = $bdd->prepare('UPDATE client SET mail_client = ? WHERE id_client = ?'); 
            $insertMail->execute(array($new_mail, $idC)); 
            header("location: ./accueil");
        }
        else{
                $error = "Veuillez remplir tous les champs.";
        }
    }   
}


function ModifierPwd($info,$idC){

    if(isset($_POST['btn_modif_mdp'])){
        if(isset($_POST['new_mdp']) AND isset($_POST['new_mdp_confirm']) AND !empty($_POST['new_mdp']) AND !empty($_POST['new_mdp_confirm'])){
            $lengthMdp = strlen($_POST['new_mdp']); 
            if($lengthMdp >= 8 ){
                $new_mdp = sha1($_POST['new_mdp']);
                $new_mdp_confirm = sha1($_POST['new_mdp_confirm']); 
                if($new_mdp == $new_mdp_confirm){
                    if($new_mdp != $info['mdp_client']){
                        $new_mdp = sha1($_POST['new_mdp']);       
                        $insertNewMdp = connexionDB()->prepare('UPDATE client SET mdp_client = ? WHERE id_client = ?'); 
                        $insertNewMdp->execute(array($new_mdp, $idC)); 
                        header("location: ./accueil");
                    }
                    else{
                        $error = "Le nouveau mot de passe ne peut pas être le même que l'ancien.";
                    }   
                }else{
                    $error =  "Les mots de passe sont differents.";
                }   
            }else{
                $error = "Mot de passe trop court";
            }   
        }else{
            $error = "Veuillez remplir tous les champs.";
        }
    }
}


//////////////////////////////////////////////////////////
//---- Fonctions pour la page aide ---------------
/////////////////////////////////////////////////////////

 function InsertAide($code_client){            
    if(isset($_POST['submit'])){
        if(!empty($_POST['commentaire'])){
            if( htmlspecialchars($_POST['commentaire']) != "#chatbot"){
                if(!empty($_POST['codeCommande'])){
                    
                        $idCommande = htmlspecialchars($_POST['codeCommande']);
                        $commentaire = htmlspecialchars($_POST['commentaire']); 

                        $reqNumCmd = connexionDB()->query("SELECT code_commande FROM commande WHERE id_commande = $idCommande");
                        $code_commande = $reqNumCmd->fetch(); 

                        $code = $code_commande['code_commande'];

                        $insertAide = connexionDB()->prepare("INSERT INTO aide (id_commande_aide,code_client_aide,commentaire) VALUES (?,?,?)");
                        $insertAide->execute(array($code,$code_client,$commentaire)); 

                        echo "<h4 class='text-success text-center'>Commentaire envoyé !</h4>";
                        header("Refresh: 3; ./accueil");
                }
            }
            else{
                header("location: ./00f2b1ead3a0990b818517356cb40280"); 
            }
        }   
    }
}

