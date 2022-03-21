<?php 
session_start();
require_once("fonction.php");
ClientExist(); 


$code_client = $_SESSION['idClient']; 
$pointEnAttente = GetPointEnAttente($code_client); 
$info = SelectInfoClient();
$points_client = $info['nbr_point_client'];


if($points_client > 0){ 
    
    $rang = GetLibelleRangByID($points_client); 
    $rang = $rang['libelle_rang']; 

    $resVerifCodeAvantages = verifCodeAvantages($code_client); 

    // Si aucun code avantages n'existe pour le client 
    if($resVerifCodeAvantages == 0){
        // Génere un code avantage : la premiere lettre du prénom et nom du client + 5 chiffres aléatoires
        if($rang != "Non classé"){
            
            $num = ""; 

            for($i = 0; $i < 5; $i++){
               $num .= mt_rand(0,9);
            }

            $codeAvantages = strtoupper(substr($info['prenom_client'], 0, 1)); // recupèrer la premier lettre du nom /prenom
            $codeAvantages .= strtoupper(substr($info['nom_client'], 0, 1)) . $num;

            $codeAvantages = $codeAvantages; 
            $rangAvantages = $rang;  
            $codeClientAvantages = $code_client;
            $dateExpiration = date("Y-m-d"); 
            $dateExpiration = date('Y-m-d', strtotime("+3 months", strtotime($dateExpiration)));

            InsertCodeAvantages($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration); 
        }
    }
    //un code avantages existe
    else{
        $infoAvantages = InfoAvantages($code_client);        
        // si le code trouvé est différent du rang actuel
        if($infoAvantages['rang_avantages'] == $rang){
            $codeAvantages = $infoAvantages['code_avantages'];
        }
        // le code trouvé n'est pas a jour avec le rang donc on regénère un nouveau code avantages
        else{
            
            if($rang == "Classic" OR $rang == "Medium" OR $rang == "Expert"){
                
                $num = ""; 

                for($i = 0; $i < 5; $i++){
                   $num .= mt_rand(0,9);
                }
                // suppression de l'ancien code pour le remplacer        
                deleteCodeAvantage($code_client); 
                //creation du code avantage
                $codeAvantages = strtoupper(substr($info['prenom_client'], 0, 1));
                $codeAvantages .= strtoupper(substr($info['nom_client'], 0, 1)) . $num;
                $codeAvantages = $codeAvantages; 
                $rangAvantages = $rang;  
                $codeClientAvantages = $code_client;
                date_default_timezone_set('Europe/Paris');
                $dateExpiration = date("Y-m-d"); 
                $dateExpiration = date('Y-m-d', strtotime("+3 months", strtotime($dateExpiration)));
                InsertNewCodeAvantage($codeAvantages,$codeClientAvantages,$rangAvantages,$dateExpiration);
            }
             else{
                $deleteCodeAvantage = connexionDB()->query("DELETE FROM avantages WHERE code_client_avantages = '$code_client'");
            }
        }   
    }
    // Background color 
    if($rang == "Classic"){

        $bg = "success";
        $bg_page = "#F6FEEC";
    }
    elseif($rang == "Medium"){

        $bg = "warning";
        $bg_page = "#F7F0DB"; 
    }
    else{
        $bg = "primary";
        $bg_page = "#DDEAFC"; 
    }
}
else{
    
    $rang = "non classé"; 
    $bg = "secondary"; 
    $bg_page = "#6c757d";
}




?>



<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <?php require_once('header.php'); ?>
    </head><br>
    <body style="background: <?= $bg_page; ?>">
        <div class="container">
            <h1 id="sizePoint" class="text-dark"><?= $points_client ?><span id="sizePT">pt<span></h1>

            <?php // Points en attentes
             if($pointEnAttente["SUM(point_en_attente)"] > 0){ ?><p class="text-danger"><b>+ <?= $pointEnAttente["SUM(point_en_attente)"]  ?> points</b> en attente..</p> 
            <?php }?>
            
            <p class="rang">Rang <b><?= $rang ?></b></p>
            <hr class="bg-<?=$bg?>">
        </div>
        <br>

        <!-- Code QR -->
        <div class="container text-center">
            <h5 class="text-center text-dark "><b><?= $_SESSION['idClient'] ?></b></h5>
            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img class="img-thumbnail"  src="<?= $info['chemin_qr_code'] ?>">
            </a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                       <center><img class="img-thumbnail" id="qrcode" src="<?= $info['chemin_qr_code'] ?>"></center>
                  </div>
                  <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
        </div><br><br>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6" >
                    <div class="shadow-lg p-3 mb-5 rounded">  
                        <h2 class="">Mes offres <i class="fas fa-gift"></i></h2><br>
                       
                        <?php 
                        $resExpiration = DateExpire($code_client);
                        
                        if($resExpiration == true){  // si une date d'expiration existe
                            
                            $dateExpir = $resExpiration['date_expiration']; // Convertit la date de AAAA/mm/jj en jj/mm/AAAA  
                            $timestamp = strtotime($dateExpir);            // Création du timestamp à partir du date donnée
                            $dateExpir = date("d/m/Y", $timestamp);       // Créer le nouveau format à partir du timestamp

                            if($points_client < 50){
                                echo "Vous avez aucune offre aujourd'hui.";
                            }
                            elseif($points_client >= 50 AND $points_client < 100){     
                                echo "<p>Vous avez un Bubble Tea OFFERT ! </p>"; 
                                include("ressource/btnCodePromo.php");      
                            }
                            elseif($points_client >= 100 AND $points_client < 150){ //Rang Medium 
                                echo "<p>Vous avez 1 bubble tea et 1 cookie OFFERT ! </p>";
                                include("ressource/btnCodePromo.php");
                            }
                            elseif($points_client >= 150 AND $points_client < 200){
                                echo "<p>Vous avez 1 bubble tea et 1 cookie OFFERT ! </p>";
                                include("ressource/btnCodePromo.php");
                            }
                            elseif($points_client >= 200 AND $points_client < 300){
                                echo "<p>Vous avez 2 Bubble Tea et 1 café au choix OFFERT ! </p>";
                                include("ressource/btnCodePromo.php");
                            }
                            elseif($points_client >= 300){  // Rang expert
                                echo "<p>Vous avez 2 Bubble Tea et 1 pâtisserie au choix OFFERT ! </p>"; 
                                include("ressource/btnCodePromo.php");
                            }
                            else{
                                echo "Erreur"; 
                            }
                        }
                        else{
                                echo "<p>Vous avez aucune offre aujourd'hui.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!-- Carrousel images -->
        <?php require_once("ressource/carrousel.php"); ?>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6" >
                    <div class="shadow-lg p-3 mb-5 rounded">  
                        <h1 class="text-center text-success">Be Tea Rewards <i class="fas fa-award"></i></h1><hr class="sizehr"><br>
                        <p>- 1 Bubble Tea acheté <b class="text-primary">+ 10 points</b></p>
                        <p>- 1 Patisserie acheté <b class="text-primary">+ 5 points</b></p>
                        <p>- <b class="text-primary">10 points OFFERTS</b> lors de la création de votre compte</p>
                        <br><br><br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-6" >
                    <div class="shadow-lg p-3 mb-5 rounded">      
                        <table class="table">                
                                 <tr class="table-primary">
                                    <td><h4><b>Expert</b></h4><small>A partir de 300 points</small></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-primary">
                                    <td></td>
                                    <td><b>300 points</b></td>
                                    <td>
                                        <img class="rounded" id="imgRewards" src="https://i0.wp.com/be-tea.fr/wp-content/uploads/2022/01/unnamed-20.png?fit=485%2C512&ssl=1">
                                        +
                                        <img class="rounded" id="imgRewards" src="https://i0.wp.com/be-tea.fr/wp-content/uploads/2022/01/IMG_2242_Facetune_15-01-2022-09-51-03-_1_.jpg?resize=300%2C300&ssl=1"><br>
                                        2 Bubble Teas et 1 pâtisserie au choix OFFERT !
                                    </td>
                                </tr>

                                <tr class="table-warning">
                                    <td><h4><b>Medium</b></h4><small>de 150 points à 299 points</small></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-warning">
                                    <td></td>
                                    <td><b>150 points</b></td>
                                    <td>
                                        <img class="rounded" id="imgRewards" src="https://i0.wp.com/be-tea.fr/wp-content/uploads/2022/01/unnamed-20.png?fit=485%2C512&ssl=1">
                                        +
                                        <img class="rounded" id="imgRewards" src="https://img.cuisineaz.com/660x660/2013/12/20/i60252-photo-de-cappuccino.jpeg"><br>
                                        2 Bubble Teas et 1 café au choix OFFERT !
                                    </td>
                                </tr>
                                <tr class="table-warning">
                                    <td>
                                    </td>
                                    <td>
                                        <b>200 points</b>
                                    </td>
                                    <td>
                                        <img class="rounded" id="imgRewards" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxR-3CZiJu0FZwgSsrPirSCP9FxzBdAdUP-g&usqp=CAU">
                                        +
                                        <img class="rounded" id="imgRewards" src="https://blog.borderlandsbakery.com/wp-content/uploads/2020/04/boba-milk-tea-cookies.jpg"><br>
                                        Vous avez 1 bubble tea et 1 cookie OFFERT !
                                    </td>
                                </tr>

                               <tr class="table-success">
                                    <td>
                                        <h4><b>Classic</b></h4><small>de 10 points à 149 points</small>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-success">
                                    <td></td>
                                    <td><b>50 points</b></td>
                                    <td> 
                                        <img class="rounded" id="imgRewards" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxR-3CZiJu0FZwgSsrPirSCP9FxzBdAdUP-g&usqp=CAU"><br>
                                        1 Bubble Tea OFFERT !
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td></td>
                                    <td><b>100 points</b></td>
                                    <td>
                                        <img class="rounded" id="imgRewards" src="https://blog.borderlandsbakery.com/wp-content/uploads/2020/04/boba-milk-tea-cookies.jpg"><br>
                                        Pour l'achat d'1 Bubble Tea 1 Cookie est OFFERT ! 
                                    </td>
                                </tr>

                                <tr class="table-secondary">
                                    <td><h4><b>Non classé</b></h4><small>de 0 à 9 points</small></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td></td>
                                    <td><b>0 point</b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    <?php include('footer.html'); ?>
    </body>
</html>

<script>
    function copyEvent(id) // copier code avantage
    {
        var str = document.getElementById(id);
        window.getSelection().selectAllChildren(str);
        document.execCommand("Copy")
    }
</script>



<style type="text/css">
span#sizePT{
    font-size: 22px;
}
h1{
    font-size: 46px;
}
hr.sizehr{
    margin: 0 80px;
}
img#imgRewards{
    width: 120px;
}
p.rang{
    font-size: 19px;
}
img#qrcode{
    width: 200px;
}
</style>

