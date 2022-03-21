<?php 

$reqAllProduit = $bdd->query("SELECT * FROM produit"); 

if(isset($_GET['supprimer'], $_GET['gestion'])){

	if(!empty($_GET['supprimer'])){

		$id_produit = $_GET['supprimer']; 

		$reqSuppPdt = $bdd->prepare("DELETE FROM produit WHERE id_produit = ?"); 
		$reqSuppPdt->execute(array($id_produit)); 
		?>
	
	<script type="text/javascript">
		var newLocation = "gestion-produits";
		window.location = newLocation;
	</script>
<?php 
	}
}


if(isset($_POST['ajout_produit'])){ ?>

	<div class="container"><br>
		<div class="row justify-content-center">
			<div class="col-sm-6">
				<div class="shadow-lg p-3 mb-5 bg-body rounded">
					<center><h2>Nouveau Produit</h2></center><br><br>
					<form method="POST">
						<table class="table-warning">

							<div class="input-group">
					  			<span class="input-group-text">Libelle</span>
								<input type="text" name="lib_pdt" class="form-control" value="">
							</div><br>

							<div class="input-group">
					  			<span class="input-group-text">Prix</span>
								<input type="text" name="prix_pdt" class="form-control" value="">
							</div><br>

							<div class="input-group">
					  			<span class="input-group-text">ID catégorie</span>
								<input type="text" class="form-control" name="id_cat_pdt" value="">
							</div><br>

							<div class="d-grid gap-4">
								<button name="btn_ajouter_produit"  class="btn btn-primary">Ajouter</button>
								<a href="./gestion-produits"  class="btn btn-outline-secondary">Annuler</a>
							</div>
							
						</table><br><br>
					</form>
				</div>
			</div>
		</div>
	</div> 

<?php
exit;
}

	if(isset($_POST['btn_ajouter_produit'])){
		if(!empty($_POST['lib_pdt']) AND !empty($_POST['prix_pdt']) AND !empty($_POST['id_cat_pdt'])){

			$lib = htmlspecialchars($_POST['lib_pdt']);
			$prix = htmlspecialchars($_POST['prix_pdt']);
			$idCat = htmlspecialchars($_POST['id_cat_pdt']);

			$reqAjoutPdt = $bdd->prepare("INSERT INTO produit (libelle_produit, prix_produit, id_categorie_produit) VALUES (?,?,?)"); 
			$reqAjoutPdt->execute(array($lib, $prix, $idCat)); 
			?>
			<script type="text/javascript">
				var newLocation = "gestion-produits";
				window.location = newLocation;
			</script>
	<?php 
		}
	} 


if(isset($_GET['modifier'])){
	if(!empty($_GET['modifier'])){

		$id_produit = $_GET['modifier']; 

		$reqInfoProduit = $bdd->prepare("SELECT * FROM produit WHERE id_produit = ?");
		$reqInfoProduit->execute(array($id_produit)); 
		$res = $reqInfoProduit->fetch();
	  ?>
		
		<div class="container"><br>
			<div class="row justify-content-center">
				<div class="col-sm-6">
					<div class="shadow-lg p-3 mb-5 bg-body rounded">
						<form method="POST">
							<table class="table-warning" align="center">
								<center><h2>Modifier Produit</h2></center><br>

								<div class="input-group">
						  			<span class="input-group-text">Libelle</span>
									<input type="text" name="lib_pdt" class="form-control" value="<?= $res['libelle_produit'] ?>">
								</div><br>

								<div class="input-group">
						  			<span class="input-group-text">Prix</span>
									<input type="text" name="prix_pdt" class="form-control" value="<?= $res['prix_produit'] ?>">
								</div><br>

								
								<div class="input-group">
						  			<span class="input-group-text">Image</span>
									<input type="text" name="image_pdt" class="form-control" value="<?= $res['img_produit'] ?>">
								</div><br>

								<div class="input-group">
						  			<span class="input-group-text">ID Categorie</span>
									<input type="text" class="form-control" name="modif_idCat_pdt" value="<?= $res['id_categorie_produit'] ?>">
								</div><br>


								
								<div class="input-group">
						  			<span class="input-group-text" id="inputGroup-sizing-default">Disponibilité</span>
									<select name="disponibilite" class="form-select">
										<option value="<?= $res['disponibilite_produit'] ?>"><?= $res['disponibilite_produit'] ?></option>	
										<option value="Disponible">Disponible</option>
										<option value="Indisponible">Indisponible</option>
									</select><br>
								</div><br>



								<div class="input-group">
						  			<span class="input-group-text" id="inputGroup-sizing-default">Masquer</span>
									<select name="masquer" class="form-select">
										<option value="<?= $res['masquer_produit'] ?>"><?= $res['masquer_produit'] ?></option>	
										<option value="Oui">Oui</option>
										<option value="Non">Non</option>
									</select><br>
								</div><br>
								
								<div class="d-grid gap-4">
									<button name="btn_modif_pdt"  class="btn btn-primary">Mettre à jour</button>
									<a href="./gestion-produits"  class="btn btn-outline-secondary">Annuler</a>
								</div>

							</table><br><br>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php


		if(isset($_POST['btn_modif_pdt'], $_GET['gestion'], $_GET['modifier'])){

			if(isset($_POST['lib_pdt']) AND !empty($_POST['lib_pdt']) AND $_POST['lib_pdt'] != $res['libelle_produit']) {
				$newLib = htmlspecialchars($_POST['lib_pdt']);
				$gestion = $_GET['gestion'];
				$idp = $res['id_produit']; 
				$insertLib = $bdd->prepare('UPDATE produit SET libelle_produit = ? WHERE id_produit = ?'); 
				$insertLib->execute(array($newLib, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['prix_pdt']) AND !empty($_POST['prix_pdt']) AND $_POST['prix_pdt'] != $res['prix_produit']) {
				$gestion = $_GET['gestion'];
				$newPrix = htmlspecialchars($_POST['prix_pdt']);
				$idp = $res['id_produit']; 
				$insertPrix = $bdd->prepare('UPDATE produit SET prix_produit = ? WHERE id_produit = ?'); 
				$insertPrix->execute(array($newPrix, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['image_pdt']) AND !empty($_POST['image_pdt']) AND $_POST['image_pdt'] != $res['img_produit']) {
				$gestion = $_GET['gestion'];
				$newImg = htmlspecialchars($_POST['image_pdt']);
				$idp = $res['id_produit']; 
				$insertImg = $bdd->prepare('UPDATE produit SET img_produit = ? WHERE id_produit = ?'); 
				$insertImg->execute(array($newImg, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['modif_idCat_pdt']) AND !empty($_POST['modif_idCat_pdt']) AND $_POST['modif_idCat_pdt'] != $res['id_categorie_produit']){
				$gestion = $_GET['gestion'];
				$newIdCat = htmlspecialchars($_POST['modif_idCat_pdt']);
				$idp = $res['id_produit']; 
				$insertIdCat = $bdd->prepare('UPDATE produit SET id_categorie_produit = ? WHERE id_produit = ?'); 
				$insertIdCat->execute(array($newIdCat, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['disponibilite']) AND !empty($_POST['disponibilite']) AND $_POST['disponibilite'] != $res['id_categorie_produit']){
				$gestion = $_GET['gestion'];
				$newDispo = htmlspecialchars($_POST['disponibilite']);
				$idp = $res['id_produit']; 
				$insertDispo = $bdd->prepare('UPDATE produit SET disponibilite_produit = ? WHERE id_produit = ?'); 
				$insertDispo->execute(array($newDispo, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['masquer']) AND !empty($_POST['masquer']) AND $_POST['masquer'] != $res['masquer_produit']){
				$gestion = $_GET['gestion'];
				$newMasque = htmlspecialchars($_POST['masquer']);
				$idp = $res['id_produit']; 
				$insertMasque = $bdd->prepare('UPDATE produit SET masquer_produit = ? WHERE id_produit = ?'); 
				$insertMasque->execute(array($newMasque, $idp)); 
			?>
				<script type="text/javascript">
					var newLocation = "gestion-produits";
					window.location = newLocation;
					exit;
				</script>
			<?php
			}

		}
		exit;	  
	}
}


?>

<div class="container"><br>
		<h1>Produits</h1><br><br>
		<form method="POST"><h3><button class="btn btn-primary" name="ajout_produit">Ajouter <?= $_GET['gestion']?></button></h3></form><br>
		<div class="table-responsive">
			<table class="table table-hover">
					<tr class="table-primary">
						<td>
							#
						</td>
						<td></td>
						<td>
							Libelle
						</td>
						<td>
							Prix
						</td>
						<td>
							Catégorie
						</td>
						<td>
							Disponibilité 
						</td>
						<td>
							Masqué
						</td>
						<td></td>
						<td></td>
					</tr>
					<?php 

					 while ($p = $reqAllProduit->fetch()) {

					 	if($p['masquer_produit'] == "Oui"){

					 		$bg = "secondary"; 
					 	}
					 	elseif($p['disponibilite_produit'] == "Indisponible"){

					 		$bg = "danger";

					 	}
					 	else{
					 		$bg = "light"; 
					 	}
					  
					?>
					<tr class="table-<?= $bg ?>">
						<td>
							<?= $p["id_produit"] ?>
						</td>
						<td>
							<img style="width: 50px;" src="<?= $p['img_produit'] ?>">
						</td>

						<td>
							<?= $p["libelle_produit"] ?>
						</td>
						<td>
							<?= $p["prix_produit"] ?> €
						</td>
						<td>
							<?= $p["id_categorie_produit"] ?>
						</td>
						<td>
							<?= $p["disponibilite_produit"] ?>
						</td>
						<td>
							<?= $p["masquer_produit"] ?>
						</td>
						<td>
							<a class="btn btn-warning" href="gestion-modifier-produit-<?= $p['id_produit'] ?>"><i class="fas fa-edit"></i></a>
						</td>
						<td>
							<a class="btn btn-danger" href="gestion-supprimer-produit-<?= $p['id_produit'] ?>"><i class="fas fa-trash-alt"></i></a>
						</td>
					</tr>
					<?php } ?>
			</table><br><br>
		</div>
	</div>