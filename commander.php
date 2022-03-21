<?php 
session_start(); 
require_once("fonction.php");
ClientExist();
require_once("config.php");
require_once("class/panier.php");


    AjoutPanier(); 

?>
    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
        <head>
            <?php require_once("header.php"); ?>    
        </head>
        <body>
        <?php
            if(isset($error)){
                echo "<div class='container text-center text-danger'>".$error."</div>"; 
            }

            if(!isset($_GET['categorie'])){
            
                include("commande/choix_categorie.php"); 

            }

            if(isset($_GET['categorie']) AND !isset($_POST['btn_prendre_commande'])){

            include("commande/choix_produit.php");
        }
        ?> 


        </body>
        <?php include('footer.html'); ?>
    </html>
