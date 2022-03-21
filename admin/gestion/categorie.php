<?php 

$reqAllCategorie = $bdd->query("SELECT * FROM categorie"); 


if(isset($_GET['modifier'])){
	if(!empty($_GET['modifier'])){

		$id_categorie = $_GET['modifier']; 

		$reqInfocategorie = $bdd->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
		$reqInfocategorie->execute(array($id_categorie)); 
		$res = $reqInfocategorie->fetch();  ?>
		
		<div class="container"><br>
			<form method="POST">
				<table class="table-warning" align="center">
					<tr>
						<td>
							Libelle
							<input type="text" name="lib_cat" class="form-control" value="<?= $res['libelle_categorie'] ?>">
						</td>
					</tr>
					<tr>

						<td>
							Nombre de points
							<input type="text" name="nbr_point" class="form-control" value="<?= $res['nbr_point_categorie'] ?>"><br>
						</td>
					</tr>
					<tr>
						<td>
							<button name="btn_modif_cat"  class="btn btn-primary">Mettre à jour</button>
							<a href="./gestion-categories"  class="btn btn-secondary">Annuler</button>
						</td>
					</tr>
				</table><br><br>
			</form>
		</div>

			
<?php

		if(isset($_POST['btn_modif_cat'], $_GET['gestion'], $_GET['modifier'])){

			if(isset($_POST['lib_cat']) AND !empty($_POST['lib_cat']) AND $_POST['lib_cat'] != $res['libelle_categorie']) {
				$newLib = htmlspecialchars($_POST['lib_cat']);
				$gestion = $_GET['gestion'];
				$idp = $res['id_categorie']; 
				$insertLib = $bdd->prepare('UPDATE categorie SET libelle_categorie = ? WHERE id_categorie = ?'); 
				$insertLib->execute(array($newLib, $idp)); 
				?>
					<script type="text/javascript">
						var newLocation = "./gestion-categories";
						window.location = newLocation;
					</script>
				<?php 
			}
			if(isset($_POST['nbr_point']) AND !empty($_POST['nbr_point']) AND $_POST['nbr_point'] != $res['nbr_point_categorie']) {
				$gestion = $_GET['gestion'];
				$newNbrPoint = htmlspecialchars($_POST['nbr_point']);
				$idp = $res['id_categorie']; 
				$insertNbrPoint = $bdd->prepare('UPDATE categorie SET nbr_point_categorie = ? WHERE id_categorie = ?'); 
				$insertNbrPoint->execute(array($newNbrPoint, $idp)); 
				?>
				<script type="text/javascript">
					var newLocation = "./gestion-categories";
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
		<h1>Catégories</h1><br><br>
		<table class="table table-hover">
				<tr class="table-primary">
					<td>
						ID categorie
					</td>
					<td>
						Libelle
					</td>
					<td>
						Nombre de point
					</td>
					<td>
						Modifier
					</td>
				</tr>
				<?php 

				 while ($p = $reqAllCategorie->fetch()) {
				  
				?>
				<tr class="table-secondary">
					<td>
						<?= $p["id_categorie"] ?>
					</td>
					<td>
						<?= $p["libelle_categorie"] ?>
					</td>
					<td>
						<?= $p["nbr_point_categorie"] ?>
					</td>
					<td>
						<a class="btn btn-warning" href="gestion-modifier-categorie-<?= $p['id_categorie'] ?>"><i class="fas fa-edit"></i></a>
					</td>
				<?php } ?>
				</tr>
			
		</table><br><br>
	</div>