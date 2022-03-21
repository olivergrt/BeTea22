<?php 
session_start(); 

if(isset($_SESSION['idAdmin'])){
	
	require_once('../config.php');
	$reqAllCmd = $bdd->query("SELECT id_commande, code_commande, code_client_commande, commande, prix_commande, date_commande, statut_commande FROM commande ORDER BY date_commande DESC"); 

	
?>

<!DOCTYPE html>
<html>
<?php include 'header.php'; ?>
	<body>
		
		<div class="container"><br>
			<h1 class="title text-dark">Historique des commandes</h1><br>
			<h4 class="text-dark">Recherche par code client :</h4>
			<form method="POST" class="d-flex">
				<input class="form-control me-2" style="width: 300px" value="<?php if(isset($_POST['search'])){ echo $_POST['search_cmd'];} ?>" placeholder="ex : BT209183" maxlength="8" type="text" name="search_cmd"><br>
				<button class="btn btn-primary" name="search"><i class="fas fa-search"></i></button>
				<button class="btn btn-outline-secondary" name="">Tout</button>
			</form>
		<br><br><br>
		<div class="table-responsive">
			<table class="table table-hover table">
					<tr class="table-primary">
						<th>
							#
						</th>
						<th>
							Numéro
						</th>
						<th>
							Code client
						</th>
						<th>
							Commande
						</th>
						<th>
							Prix Total
						</th>
						<th>
							Date
						</th>
						<th>
							Etat
						</th>
					</tr>


				<?php 

				if(isset($_POST['search'])){

					if(!empty($_POST['search_cmd'])){

						$code_client = htmlspecialchars($_POST['search_cmd']); 

						// recherche par num client
						$reqSearch = $bdd->prepare("SELECT id_commande, code_commande, code_client_commande, commande, prix_commande, date_commande, statut_commande FROM commande WHERE code_client_commande = ?"); 
						$reqSearch->execute(array($code_client)); 
						$res = $reqSearch->rowCount(); 

						if($res > 0){

							while ($infoClient = $reqSearch->fetch()) { 

								// Convertit la date de AAAA/mm/jj à jj/mm/AAAA
								$date = $infoClient['date_commande'];	   
								// Création du timestamp à partir du date donnée
								$timestamp = strtotime($date);

								// Créer le nouveau format à partir du timestamp
								$date = date("d-m-Y H:i:s", $timestamp);
						?>

							<tr class="table-secondary">
								<td>
									<?= $infoClient["id_commande"] ?>
								</td>
								<td>
									<?= $infoClient["code_commande"] ?>
								</td>
								<td>
									<?= $infoClient["code_client_commande"] ?>
								</td>
								<td>
									<?= $infoClient["commande"] ?>
								</td>
								<td>
									<?= $infoClient["prix_commande"] ?> €
								</td>
								<td>
									<?= $date ?>
								</td>
								<td>
									<?= $infoClient["statut_commande"] ?>
								</td>
							</tr>
							
					<?php
							}
						}
						else{

							echo "code_client incorrect";
						}
					}
					else{

					 while ($infoClient = $reqAllCmd->fetch()) {
			 			// Convertit la date de AAAA/mm/jj à jj/mm/AAAA
						$date = $infoClient['date_commande'];	   
						// Création du timestamp à partir du date donnée
						$timestamp = strtotime($date);

						// Créer le nouveau format à partir du timestamp
						$date = date("d-m-Y H:i:s", $timestamp);
					  
					?>
					<tr class="table-secondary">
						<td>
							<?= $infoClient["id_commande"] ?>
						</td>
						<td>
							<?= $infoClient["code_commande"] ?>
						</td>
						<td>
							<?= $infoClient["code_client_commande"] ?>
						</td>
						<td>
							<?= $infoClient["commande"] ?>
						</td>
						<td>
							<?= $infoClient["prix_commande"] ?> €
						</td>
						<td>
							<?= $date ?>
						</td>
						<td>
							<?= $infoClient["statut_commande"] ?>
						</td>
					</tr>
					<?php } 
				}

				}
				else{

					 while ($infoClient = $reqAllCmd->fetch()) {
					 	// Convertit la date de AAAA/mm/jj à jj/mm/AAAA
						$date = $infoClient['date_commande'];	   
						// Création du timestamp à partir du date donnée
						$timestamp = strtotime($date);

						// Créer le nouveau format à partir du timestamp
						$date = date("d-m-Y H:i:s", $timestamp);
					  
					?>
					<tr class="table-secondary">
						<td>
							<?= $infoClient["id_commande"] ?>
						</td>
						<td>
							<?= $infoClient["code_commande"] ?>
						</td>
						<td>
							<?= $infoClient["code_client_commande"] ?>
						</td>
						<td>
							<?= $infoClient["commande"] ?>
						</td>
						<td>
							<?= $infoClient["prix_commande"] ?> €
						</td>
						<td>
							<?= $date ?>
						</td>
						<td>
							<?= $infoClient["statut_commande"] ?>
						</td>
					</tr>
					<?php } 
				}
			?>

			</table>
		</div>
	</div>
</body>
<?php include('../footer.html'); ?>
</html>

<?php 

	} 
	else{
		header("location: index.php"); 
	}
?>