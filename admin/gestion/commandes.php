	
<?php 

$reqAllCommandes = $bdd->query("SELECT id_commande,code_commande,code_client_commande,commande,prix_commande,date_commande,statut_commande FROM commande  ORDER BY date_commande DESC "); 

if(isset($_GET['supprimer'], $_GET['gestion'])){

	if(!empty($_GET['supprimer'])){

		$id_commande = $_GET['supprimer']; 

		$reqSuppCmd = $bdd->prepare("DELETE FROM commande WHERE id_commande = ?"); 
		$reqSuppCmd->execute(array($id_commande)); 
		?>
	
		<script type="text/javascript">
			var newLocation = "gestion-commandes";
			window.location = newLocation;
		</script>
<?php  
	}
}


if(isset($_GET['modifier'])){
	if(!empty($_GET['modifier'])){

		$id_commande = $_GET['modifier']; 

		$reqInfoProduit = $bdd->prepare("SELECT id_commande,code_commande,statut_commande FROM commande WHERE id_commande = ?");
		$reqInfoProduit->execute(array($id_commande)); 
		$res = $reqInfoProduit->fetch();  ?>
		
		<div class="container"><br>
			<h1>Modifier Produit</h1><br><br>
			<form method="POST">
				<table class="table-warning">
					<tr>
						<td>
							<div class="input-group input-group-mb-3">
							<span class="input-group-text" id="inputGroup-sizing-default">Numéro commande</span>
							<input type="text" class="form" value="<?= $res['code_commande'] ?>">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<select name="statut_cmd" class="form-select">
								<option><?= $res['statut_commande'] ?></option>
								<option value="En attente">En attente</option>
								<option value="En cours">En cours</option>
								<option value="Terminé">Terminé</option>
								<option value="Annulée">Annulée</option>
							</select><br>
						</td>
					</tr>
					<tr>
						<td>
							<button name="btn_modif_cmd"  class="btn btn-primary">Mettre à jour</button>
							<a href="gestion-commandes"  class="btn btn-secondary">Annuler</a>
						</td>
					</tr>
				</table><br><br>
			</form>
		</div>

			
<?php

		if(isset($_POST['statut_cmd'], $_GET['gestion'], $_GET['modifier'])){

			if(isset($_POST['statut_cmd']) AND !empty($_POST['statut_cmd']) AND $_POST['statut_cmd'] != $res['statut_commande']) {
				
				$newStatut = htmlspecialchars($_POST['statut_cmd']);
				$idC = $res['id_commande']; 

				//mise a jour du statut de la commande
				$insertLib = $bdd->prepare('UPDATE commande SET statut_commande = ? WHERE id_commande = ?'); 
				$insertLib->execute(array($newStatut, $idC)); 

				//Ajout des points en attente vers les point cumulés si les statut modifier vers "terminé"
				if($newStatut == "Terminé"){

					$verifPointAttente = $bdd->query("SELECT code_client_commande,point_en_attente FROM commande WHERE id_commande = $idC");
					$resPoint = $verifPointAttente->fetch(); 

					if($resPoint > 0){

						$newPoint = $resPoint['point_en_attente']; 
						$id_client = $resPoint['code_client_commande'];
						$updatePoints = $bdd->query("UPDATE client SET nbr_point_client = nbr_point_client + $newPoint WHERE code_client = '$id_client'");
						$ResetPointEnAttente = $bdd->query("UPDATE commande SET point_en_attente = 0 WHERE id_commande = $idC");

					}
				}

				if($newStatut == "Annulée"){

					$ResetPointEnAttente = $bdd->query("UPDATE commande SET point_en_attente = 0 WHERE id_commande = $idC");

				}

				$gestion = $_GET['gestion'];
				?>
	
				<script type="text/javascript">
					var newLocation = "gestion-commandes";
					window.location = newLocation;
				</script>
		<?php 

			}

		}	  
		exit();
	}
}
?>

	<div class="container"><br>
		<h1>Commandes</h1><br><br>
		<div class="table-responsive">
			<table class="table table-hover">
					<tr class="table-primary">
						<td>
							#
						</td>
						<td>
							Numéro 
						</td>
						<td>
							Client
						</td>
						<td>
							Commande
						</td>
						<td>
							Prix Total
						</td>
						<td>
							Date
						</td>
						<td>
							Statut
						</td>
						<td>
							Modifier
						</td>
						<td>
							Supprimer
						</td>
					</tr>
					<?php 

					 while ($c = $reqAllCommandes->fetch()) {
					 	
					 	if($c['statut_commande'] == "Annulée"){
							$color = "danger";
					  		$btn = "btn btn-outline-warning";

						}
						elseif($c['statut_commande'] == "En attente"){
							$color = "secondary"; 
							$annuler = true;
					  		$btn = "btn btn-warning"; 

						}
						elseif($c['statut_commande'] == "En cours"){
							$color = "light";
					  		$btn = "btn btn-warning"; 

						}
						else{
							$color = "success";
					  		$btn = "btn btn-outline-warning";
							
						}

						
						// Convertit la date de AAAA/mm/jj en jj/mm/AAAA
						$date = $c['date_commande'];	   
						// Création du timestamp à partir du date donnée
						$timestamp = strtotime($date);

						// Créer le nouveau format à partir du timestamp
						$date = date("d-m-Y H:i:s", $timestamp);
						
						$verifDateToday = date("Y-m-d", $timestamp);
						

						date_default_timezone_set('Europe/Paris');
	     				$dateToday = date('Y-m-d');
						$dateYesterday = date('Y-m-d');
	                    $dateYesterday = date('Y-m-d', strtotime("-1 day", strtotime($dateToday)));
	                    $dateBeforeYesterday = date('Y-m-d', strtotime("-2 day", strtotime($dateToday)));


						if($verifDateToday == $dateToday){
							
							$date = "Aujourd'hui"; 
						}
						elseif($verifDateToday == $dateYesterday){

							$date = "Hier"; 

						}
						elseif($verifDateToday == $dateBeforeYesterday){

							$date = "Avant-hier"; 

						}

					?>
					<tr class="table-<?=$color?> table-hover">
						<td>
							<?= $c["id_commande"] ?>
						</td>
						<td>
							<?= $c["code_commande"] ?>
						</td>
						<td>
							<?= $c["code_client_commande"] ?> 
						</td>
						<td>
							<?= $c["commande"] ?>
						</td>
						<td>
							<?= $c["prix_commande"] ?> €
						</td>
						<td>
							<?= $date ?>
						</td>
						<td>
							<?= $c["statut_commande"] ?>
						</td>
						<td>
							<a class="<?= $btn ?>" href="gestion-modifier-commandes-<?= $c['id_commande'] ?>"><i class="fas fa-edit"></i></a></button>
						</td>
						<td>
							<a class="btn btn-outline-danger" href="gestion-supprimer-commandes-<?= $c['id_commande'] ?>"><i class="fas fa-trash-alt"></i></a> 
						</td>
					</tr>
					<?php } ?>
				
			</table><br><br>
		</div>
	</div>