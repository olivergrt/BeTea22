<?php 

$reqAllCodePromo = $bdd->query("SELECT * FROM code_promotionnel"); 

if(isset($_GET['supprimer'], $_GET['gestion'])){

	if(!empty($_GET['supprimer'])){

		$id_code_promo = $_GET['supprimer']; 

		$reqSuppCodeP = $bdd->prepare("DELETE FROM code_promotionnel WHERE id_code_promo = ?"); 
		$reqSuppCodeP->execute(array($id_code_promo)); 
		// header("location: gestion-codespromo"); 
	}
}


if(isset($_POST['ajout_code'])){ ?>

	<div class="container"><br>
		<form method="POST">
			<table class="table-warning" align="center">
				<tr>
					<td>
						Code
						<input type="text" name="code_promo" class="form-control" value="">
					</td>
				</tr>
				<tr>

					<td>
						Nombre d'utilisation
						<input type="number" name="nbr_utilisation" class="form-control" value="">
					</td>
				</tr>
				<tr>
					<td>
						 % Réduction
						<input type="text" class="form-control" name="reduction" value="">
					</td>
				</tr>
				<tr>
					<td>
						<button name="btn_ajouter_CodeP"  class="btn btn-primary">Ajouter</button>
						<a href="./gestion-codespromo"  class="btn btn-secondary">Annuler</button>
					</td>
				</tr>
			</table><br><br>
		</form>
	</div> 

	<?php
	exit();
}

	if(isset($_POST['btn_ajouter_CodeP'])){
		if(!empty($_POST['code_promo']) AND !empty($_POST['nbr_utilisation']) AND !empty($_POST['reduction'])){

			$codeP = htmlspecialchars($_POST['code_promo']);
			$NbrUtilisation = htmlspecialchars($_POST['nbr_utilisation']);
			$Reduc = htmlspecialchars($_POST['reduction']);

			$reqAjoutPdt = $bdd->prepare("INSERT INTO code_promotionnel (nbr_utilisation,code_promo,reduction) VALUES (?,?,?)"); 
			$reqAjoutPdt->execute(array($NbrUtilisation,$codeP,$Reduc)); 
			// header("location: gestion-codespromo"); 
		}
	} 


if(isset($_GET['modifier'])){
	if(!empty($_GET['modifier'])){

		$id_code_promo = $_GET['modifier']; 

		$reqInfoCode = $bdd->prepare("SELECT * FROM code_promotionnel WHERE id_code_promo = ?");
		$reqInfoCode->execute(array($id_code_promo)); 
		$res = $reqInfoCode->fetch();  ?>
		
		<div class="container"><br>
			<form method="POST">
				<table class="table-warning" align="center">
					<tr>
						<td>
							Code promo
							<input type="text" name="code_promo" class="form-control" value="<?= $res['code_promo'] ?>">
						</td>
					</tr>
					<tr>

						<td>
							Nombre d'utilisation
							<input type="text" name="nbr_utilisation" class="form-control" value="<?= $res['nbr_utilisation'] ?>">
						</td>
					</tr>
					<tr>
						<td>
							Reduction
							<input type="text" class="form-control" name="modif_reduction" value="<?= $res['reduction'] ?>">
						</td>
					</tr>
					<tr>
					<td>
						Validité
						<select name="validite" class="form-select">
							<option value=""><?= $res['valide'] ?></option>	
							<option value="oui">oui</option>
							<option value="non">non</option>
						</select><br>
					</td>
				</tr>
					<tr>
						<td>
							<button name="btn_modif_Code"  class="btn btn-primary">Mettre à jour</button>
							<a href="./gestion-codespromo"  class="btn btn-secondary">Annuler</button>
						</td>
					</tr>
				</table><br><br>
			</form>
		</div>

			
<?php

		if(isset($_POST['btn_modif_Code'], $_GET['gestion'], $_GET['modifier'])){

			if(isset($_POST['code_promo']) AND !empty($_POST['code_promo']) AND $_POST['code_promo'] != $res['code_promo']) {
				$newCode = htmlspecialchars($_POST['code_promo']);
				$gestion = $_GET['gestion'];
				$idC = $res['id_code_promo']; 
				$insertCode = $bdd->prepare('UPDATE code_promotionnel SET code_promo = ? WHERE id_code_promo = ?'); 
				$insertCode->execute(array($newCode, $idC)); 
				?>
				<script type="text/javascript">
					var newLocation = "./gestion-codespromo";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['nbr_utilisation']) AND !empty($_POST['nbr_utilisation']) AND $_POST['nbr_utilisation'] != $res['nbr_utilisation']) {
				$gestion = $_GET['gestion'];
				$newNbrUtil = htmlspecialchars($_POST['nbr_utilisation']);
				$idC = $res['id_code_promo']; 
				$insertNbrUtil = $bdd->prepare('UPDATE code_promotionnel SET nbr_utilisation = ? WHERE id_code_promo = ?'); 
				$insertNbrUtil->execute(array($newNbrUtil, $idC)); 
				?>
				<script type="text/javascript">
					var newLocation = "./gestion-codespromo";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['modif_reduction']) AND !empty($_POST['modif_reduction']) AND $_POST['modif_reduction'] != $res['reduction']){
				$gestion = $_GET['gestion'];
				$newReduc = htmlspecialchars($_POST['modif_reduction']);
				$idC = $res['id_code_promo']; 
				$insertReduc = $bdd->prepare('UPDATE code_promotionnel SET reduction = ? WHERE id_code_promo = ?'); 
				$insertReduc->execute(array($newReduc, $idC)); 
				?>
				<script type="text/javascript">
					var newLocation = "./gestion-codespromo";
					window.location = newLocation;
					exit;
				</script>
			<?php

			}
			if(isset($_POST['validite']) AND !empty($_POST['validite']) AND $_POST['validite'] != $res['valide']){
				$gestion = $_GET['gestion'];
				$newValidite = htmlspecialchars($_POST['validite']);
				$idC = $res['id_code_promo']; 
				$insertValidite = $bdd->prepare('UPDATE code_promotionnel SET valide = ? WHERE id_code_promo = ?'); 
				$insertValidite->execute(array($newValidite, $idC)); 
				?>
				<script type="text/javascript">
					var newLocation = "./gestion-codespromo";
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
		<h1>Code Promo</h1><br><br>
		<form method="POST"><h3><button class="btn btn-primary" name="ajout_code">Ajouter <?= $_GET['gestion']?></button></h3></form><br>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="table-primary">
						<td>
							ID code promo
						</td>
						<td>
							Code Promo
						</td>
						<td>
							Nombre Utilisation
						</td>
						<td>
							Réduction
						</td>
						<td>
							Valide
						</td>
						<td>
							Modifier
						</td>
						<td>
							Supprimer
						</td>
					</tr>
				</thead>
				<tbody>
					<?php 

					 while ($p = $reqAllCodePromo->fetch()) {
					  
					?>
					<tr class="table-secondary">
						<td>
							<?= $p["id_code_promo"] ?>
						</td>
						<td>
							<?= $p["code_promo"] ?>
						</td>
						<td>
							<?= $p["nbr_utilisation"] ?>
						</td>
						<td>
							-<?= $p["reduction"] ?>%
						</td>
						<td>
							<?= $p["valide"] ?>
						</td>
						<td>
							<a class="btn btn-warning" href="./gestion-modifier-codepromo-<?= $p['id_code_promo'] ?>"><i class="fas fa-edit"></i></a>
						</td>
						<td>
							<a class="btn btn-danger" href="gestion-supprimer-codepromo-<?= $p['id_code_promo'] ?>"><i class="fas fa-trash-alt"></i></a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
				
			</table><br><br>
		</div>
	</div>