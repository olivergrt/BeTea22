<?php 
session_start();
require_once("fonction.php");
ClientExist();  
require_once("config.php");
require_once("class/panier.php"); 

SelectInfoClient();
PanierExist(); 
ReduireQuantite(); 
AugmenterQuantite(); 
ViderPanier();
RetirerArticlePanier(); 
FinaliserCommande(); 
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <?php require_once("header.php"); ?>
</head>
<body>
    <div class="container"><br><br>
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="shadow-lg p-3 mb-5 bg-body rounded">       
                <?php ErrorMessage(); ?>
                    <form method="POST" action="">
                        <table class="table">
            
                            <?php 
                            $prixTotal = 0;  //initialisation

                            foreach ($_SESSION['panier'] as $id_pdt => $qte) { // affichage des articles du panier 

                                $reqInfoPdtPanier = ConnexionDB()->query("SELECT libelle_produit, prix_produit,id_produit,img_produit FROM produit WHERE id_produit = $id_pdt");
                                $res = $reqInfoPdtPanier->fetch();

                                foreach ($_SESSION['panier'] as $idTotal => $qteTotal) {
                                    
                                     if ($idTotal == $res['id_produit']) {
                                
                                    $prixArticle = $res['prix_produit'] * $qteTotal; 
                                    $prixTotal += $prixArticle;  

                                    }
                                }

                                $lib_produit = $res['libelle_produit'];
                                $id_pdt = $res['id_produit']; 
                                $img_pdt = $res['img_produit'];

                                ?>

                                <tr class="">
                                    <td><img style="width: 75px;" src="<?= $img_pdt ?>"></td>
                                    <td><?= $lib_produit ?></td>
                                    <td>
                                        <a href="panier_client.php?retirer=<?= $res['id_produit'] ?>"><i class="fa fa-minus"></i></a>     
                                        <?= $qte ?>   
                                        <a href="panier_client.php?ajouter=<?= $res['id_produit'] ?>"><i class="fa fa-plus"></i></a> 
                                    </td>
                                    <td><?= $prixArticle ?> €</td>
                                    <td><a href="panier_client.php?supprimer=<?= $res['id_produit'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>

                                <?php } ?>

                                </tr>
                                <td>
                                    <br><a href="./commander" class="btn btn-sm btn-outline-success" >Poursuivre la commande</a>
                                </td>
                                 <td></td>
                                <td></td>
                                <td>
                                    <br><button class="btn btn-sm btn-outline-danger" name="viderPanier">Vider le panier</button>
                                </td>
                        </table>
                    </form> 
                </div>
            </div>
        </div>
        <!-- --------------------------------->
        <!------------- CODE PROMO  ---------->
        <!------------------------------------>
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="shadow-lg p-3 mb-5 bg-body rounded">
                    <table class="table">
                        <tr>
                            <form method="POST">    
                                <td class="prixTotal">
                                    Code promotionnel
                                    <input style="max-width: 200px" name="code_promo" value="<?php if(isset($_SESSION['TotalCodePromo'])){ echo $_SESSION['TotalCodePromo']; } ?><?php if(isset($_SESSION['CodeAvantage'])){ echo $_SESSION['CodeAvantage']; } ?>" placeholder="ex: BETEA25" type="text"  class="form-control me-2"><br>

                                    <button class="btn btn-sm btn-dark" name="appliquerCode">Appliquer</button><br>

                                    <?php if(isset($_SESSION['TotalCodePromo'])){ ?>
                                    <a href="ressource/retirerPromo.php">Retirer le code</a>
                                    <?php } ?>
                                    <?php if(isset($_SESSION['CodeAvantage'])){ ?>
                                    <a href="ressource/retirerPromo.php">Retirer le code</a>
                                    <?php } ?>      
                                </td><br>
                            </form>

                           <?php 
                            AppliquerCodePromo(); 

                            if(isset($_SESSION['TotalCodePromo'])){
                                
                                $code_prm = $_SESSION['TotalCodePromo'];
                                $info_promo = GetPromotion($code_prm);
                                $reduc = $prixTotal * $info_promo['reduction'] / 100; 
                                $prixTotalPromo = $prixTotal - $reduc;  
                            }
                            ?>



                        <!-- /////////////////////////////// -->
                        <!-- --------------TOTAL---------- -->
                        <!-- //////////////////////////////// -->
                    
                            <td></td>
                            <td><br>

                                <h4 class="prixTotal">
                                   
                                    <?php 
                                    if(isset($_SESSION['TotalCodePromo'])){ // si un code promo a été utilisé ?> 

                                         Prix TOTAL :
                                        <span class="text-success">
                                            <?= number_format($prixTotalPromo,2) ?> €
                                        </span> 
                                            <span class="text-danger">
                                                <small><strike><?= $prixTotal ?> € </strike></small>
                                            </span>
                                        <h5 class="text-danger">-<?= $info_promo['reduction'] ?>%</h5>
                                     <?php
                                    }
                                  
                                    else{  ?>

                                         Prix TOTAL : <?= number_format($prixTotal,2) ?> €

                                   <?php } ?>

                                </h4>

                                <form method="POST">

                                    <br>
                                     <!-- /////////////////////////////// -->
                                    <!-- --------------Bouton payer---------- -->
                                    <!-- //////////////////////////////// -->
                                    <button style="width: 200px" class="btn btn-lg btn-primary" name="btn_finaliser">
                                        <i class="fas fa-lock"></i> Payer 

                                        <?php 
                                        if(isset($_SESSION['TotalCodePromo'])){

                                            echo number_format($prixTotalPromo,2)." €"; // arrondit à 2 chiffres après la virgule
                                        }
                                         else{
                                            echo number_format($prixTotal,2)." €";
                                         }
                                        ?>
                                    </button>
                                </form>
                            </td>
                        </tr> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('footer.html'); ?>
</html>
