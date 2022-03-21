<?php 
session_start(); 
require_once('fonction.php');
ClientExist();
require_once('config.php');

$code_client = $_SESSION['idClient'];
$reqAllCmd = GetAllCommande($code_client); 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Be Tea</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<?php require_once("header.php");  ?>
</head>
	<body>
		
		<div class="container"><br>
			<h2 class="title">Historique des commandes</h2><br><br><br>		
			<small class="text-danger">Tant qu'une commande est en attente il est possible de l'annuler.</small>	
			<div class="table-responsive">
				<div id="statutCmd">
					<table class="table table-hover">
							<tr>
								<td>N°commande</td>
								<td></td>
								<td>Prix</td>
								<td>Date et heure</td>
								<td>Statut</td>
								<td></td>
							</tr>
						<?php 

					
							while ($infoCommande = $reqAllCmd->fetch()) { 

								$annuler = false; 

								if($infoCommande['statut_commande'] == "Annulée"){
									$color = "danger";
								}
								elseif($infoCommande['statut_commande'] == "En attente"){
									$color = "secondary"; 
									$annuler = true;
								}
								elseif($infoCommande['statut_commande'] == "En cours"){
									$color = "light";
								}
								else{
									$color = "success"; 
								}

								// Convertit la date de AAAA/mm/jj en jj/mm/AAAA
							$dateCommande = $infoCommande["date_commande"];	   
							// Création du timestamp à partir du date donnée
							$timestamp = strtotime($dateCommande);

							// Créer le nouveau format à partir du timestamp
							$dateCommande = date("d/m/Y à H:i:s", $timestamp);
							?>

							<tr class="table-<?= $color ?>">
								<td>
									<?= $infoCommande["code_commande"] ?>
								</td>
								<td>
									<?= $infoCommande["commande"] ?>
								</td>
								<td>
									<?= $infoCommande["prix_commande"] ?> €
								</td>
								<td>
									<?= $dateCommande ?>
								</td>
								<td>
									<?= $infoCommande["statut_commande"] ?>
								</td>
								<td>
									<?php if($annuler == true){ ?>
												
									<button id="buttonAnnuler" value="<?= $infoCommande["code_commande"] ?>" class="btn btn-outline-danger">Annuler</button>

								<?php }
						
									?>
								</td>
							</tr>
						<?php
						}
						?>
				</table>
			</div>
		</div>

	</div>
</body>
<?php include('footer.html');
	 ?>
</html>

<script type="text/javascript">
		
		let buttonAnnuler = document.getElementById("buttonAnnuler");
	 	buttonAnnuler.addEventListener("click", AnnulerCmd);

	    function AnnulerCmd(){
	          
	        let idCommande = buttonAnnuler.value;
	        fetch("ajax/annulerCommande.php?idCommande="+ idCommande)
	          
          	.catch(function (error) {
	                        console.log('La requête à échouée', error);
	           });

	          
          	$('#statutCmd').load('ajax/loadStatut.php'); // JQuery auto reload 

	  }
</script>
