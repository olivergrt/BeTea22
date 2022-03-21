<?php 
session_start();
require_once('../config.php'); 

$code_client = $_SESSION['idClient'];
$reqAllCmd = $bdd->query("SELECT code_commande,commande,prix_commande,date_commande,statut_commande FROM commande WHERE code_client_commande = '$code_client' ORDER BY date_commande DESC");


?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<table class="table table-hover">
		<tr>
			<td>Numéro commande</td>
			<td>Commande</td>
			<td>Prix Total</td>
			<td>Date</td>
			<td>Statut</td>
			<td>Annuler</td>
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