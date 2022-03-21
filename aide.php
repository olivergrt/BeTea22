<?php 
session_start();
require_once("fonction.php");   
ClientExist();
require_once("./ajax/accesBDD.php");

$code_client = $_SESSION['idClient']; 
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'header.php'; ?>
</head>
<body><br><br>
<?php
  InsertAide($code_client);  //insertion du commentaire
        ?>

        <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6" >
                <div class="shadow-lg p-3 mb-5  rounded" id="container">
                    <form method="POST">
                        <center><h1>Aide <i class="fa-solid fa-comment-dots"></i></h1>
                            <small>Réponse rapide en moins d'une heure !</small>
                        </center>
                        <br>
                    
                        <?php 

                        $code_client = $_SESSION['idClient'];

                        $lesCommandes = getLesCommandesByIdClient($code_client); 
                        ?>

                        <div class="input-group input-group-mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Numéro commande</span>
                            <select class="form-select" name="codeCommande" id="listeCommandes">
                                <option></option>

                                <?php
                                    foreach ($lesCommandes as $commande) {
                                        
                                        echo "<option value = '".$commande['id_commande']."'>".$commande['code_commande']."</option>";
                                    } 
                                ?>

                            </select>
                        </div><br>
                      
                        <div class="input-group">
                            <span class="input-group-text">Statut</span>
                            <div class="form-control" id="divStatut" readonly></div>
                        </div><br>

                        <div class="input-group">
                            <span class="input-group-text">Date de commmande</span>
                            <div class="form-control" id="divDate" readonly></div>
                        </div><br>

                        <div class="input-group">
                            <span class="input-group-text">Commmande</span>
                            <textarea class="form-control" name="commande" id="divContenu" aria-label="With textarea" readonly></textarea>
                        </div><br>

                        <div class="input-group input-group-mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Prix</span>
                            <div id="divPrix" type="contenu" name="prix" class="form-control" readonly></div>
                        </div><br>

                        <div class="input-group">
                            <span class="input-group-text">Commentaire</span>
                            <textarea placeholder="Ex : Problème avec un bubble tea.." name="commentaire" class="form-control" aria-label="With textarea"></textarea>
                        </div><br>

                        <div class="d-grid gap-2">
                            <button name="submit" class="btn btn-primary">Soumettre</button>
                        </div>         
                    </form>
                </div>  
            </div>
        </div>
    </div>
<script type="text/javascript" src="ajax/fonctions.js"></script>
</body>
</html>


<style type="text/css">
    
    body{
        background: #DDEAFC;
    }
    div#container{
        background: #F3F5F9;
    }
</style>