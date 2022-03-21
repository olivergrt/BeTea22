<?php

function getmicrotime(){ // fonction pour calculer le temps de chargement 
        
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}


    $debut = getmicrotime();


if(!empty($_GET['categorie'])){

    $idCateg = $_GET['categorie'];
    $reqAllProduit = $bdd->prepare("SELECT id_produit,prix_produit,libelle_produit,img_produit,disponibilite_produit FROM produit WHERE id_categorie_produit = ? AND masquer_produit = 'Non'");
    $reqCountProduit = $bdd->prepare("SELECT COUNT(id_produit) FROM produit WHERE id_categorie_produit = ? AND masquer_produit = 'Non'");
    $reqAllProduit->execute(array($idCateg)); 
    $reqCountProduit->execute(array($idCateg)); 
    
    $nbProduit = $reqCountProduit->fetch();    
    ?>

        <div class="container">
            <table class="table">         
            <?php while ($p = $reqAllProduit->fetch()) {

                    // Si le produit est indisponible
                    $indispo = false; 
                    if($p['disponibilite_produit'] == "Indisponible"){

                        $indispo = true; 
                    }
            ?>
                <tr>
                    <td>
                        <h4><?= $p['libelle_produit'] ?> <?= $p['prix_produit'] ?> €</h4><hr class="bg-dark"><br>
                        <p class="text-secondary">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </td>
                    <td>
                        <img class="rounded img-fluid" style="max-width: 150px; max-height: 150px;" src="<?= $p['img_produit'] ?>"><br><br>
                        
                        <?php 
                        if($indispo == false){ 
                        ?>

                        <a class="btn btn-primary" href="commander-categorie-<?= $_GET['categorie']?>-produit-<?= $p['id_produit'] ?>">Ajouter <i class="fas fa-cart-plus"></i></a>

                        <?php 
                        }
                        else{ ?>
                            <a class="btn btn-secondary">Indisponible</a>
                        <?php  
                        }
                        ?>                    
                    </td>

        <?php  } 

                if($nbProduit['COUNT(id_produit)'] > 0){
                   
                    $fin = getmicrotime(); // temps de chargement de la page
                    echo "<h5 class='text-secondary'>".$nbProduit['COUNT(id_produit)']. " résultats <small> en ".round( $fin - $debut, 3) ." secondes </small></h5><br> "; 
                }
                else{
                    echo "<br><br><br><br><center><h1>Erreur 404.</h1><p>Cette page n'existe pas.</p></center>";
                }

        ?>
                </tr>
            </table>                       
        </div>
<?php 

}
?>