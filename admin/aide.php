<?php 
session_start(); 
require_once('../config.php');
if(!isset($_SESSION['idAdmin'])){

	header("location: connexion.php");

}

$reqAllAide = $bdd->query("SELECT * FROM aide"); 

?>

<!DOCTYPE html>
<html>
<head>
	<?php include "header.php"; ?>
</head>
<body><br><br>

	 <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6" >
                <div class="shadow-lg p-3 mb-5 bg-body rounded">
                        <center><h2>Aide Client <i class="fa-solid fa-comment-dots"></i></h2></center>
                        <table class="table">
                        	<tr>
                        		<td>Code client</td>
                        		<td>Code commande</td>
                        		<td>Commentaire</td>
                        	</tr>

                        <?php 

                        	while($res = $reqAllAide->fetch()){
                        		
                         ?>

		                        
		                        <tr>
		                        	<td><?= $res['code_client_aide'] ?></td>
		                        	<td><?= $res['id_commande_aide'] ?></td>	
		                        	<td><?= $res['commentaire'] ?></td>

		                        </tr>
		                    
		                    
		                    <?php
                        	}
                        ?>
                        </table>

                </div>
            </div>

       	</div>
   	</div>  




</body>
</html>