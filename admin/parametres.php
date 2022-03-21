<?php 
session_start(); 
require_once('../config.php'); 
	
	if(isset($_SESSION['idAdmin'])){

		$id = $_SESSION['idAdmin']; 
		$reqAllInfo = $bdd->query("SELECT * FROM administrateur WHERE id_admin = $id"); 
		$res = $reqAllInfo->fetch(); 

		if(isset($_POST['annuler'])){
			header("location: ./historiqueAdmin");
		}


		if(isset($_POST['btn_modif_nom'])){

			if(isset($_POST['new_nom']) AND !empty($_POST['new_nom']) AND $_POST['new_nom'] != $res['nom_admin']) {
				$newNom = htmlspecialchars($_POST['new_nom']);
				$idA = $res['id_admin']; 
				$insertNom = $bdd->prepare('UPDATE administrateur SET nom_admin = ? WHERE id_admin = ?'); 
				$insertNom->execute(array($newNom, $idA)); 
				header("location: ./historiqueAdmin");
			}
			else{
					$error = "Veuillez remplir tous les champs.";
			}
		}

		if(isset($_POST['btn_modif_prenom'])){

			if(isset($_POST['newPrenom']) AND !empty($_POST['newPrenom']) AND $_POST['newPrenom'] != $res['prenom_admin']) {
				$newPrenom = htmlspecialchars($_POST['newPrenom']);
				$idA = $res['id_admin']; 
				$insertPrenom = $bdd->prepare('UPDATE administrateur SET prenom_admin = ? WHERE id_admin = ?'); 
				$insertPrenom->execute(array($newPrenom, $idA)); 
				header("location: ./historiqueAdmin");
			}
			else{
					$error = "Veuillez remplir tous les champs.";
			}
		}

		
		if(isset($_POST['btn_modif_mail'])){

			if(isset($_POST['new_mail']) AND !empty($_POST['new_mail']) AND $_POST['new_mail'] != $res['mail_admin']) {
				$new_mail = htmlspecialchars($_POST['new_mail']);
				$idA = $res['id_admin']; 
				$insertMail = $bdd->prepare('UPDATE administrateur SET mail_admin = ? WHERE id_admin = ?'); 
				$insertMail->execute(array($new_mail, $idA)); 
				header("location: ./historiqueAdmin");
			}
			else{
					$error = "Veuillez remplir tous les champs.";
			}
		}


		if(isset($_POST['btn_modif_mdp'])){

			if(isset($_POST['new_mdp']) AND isset($_POST['new_mdp_confirm']) AND !empty($_POST['new_mdp']) AND !empty($_POST['new_mdp_confirm'])){

				$lengthMdp = strlen($_POST['new_mdp']); 
				if($lengthMdp >= 8 ){

					$new_mdp = sha1($_POST['new_mdp']);
					$new_mdp_confirm = sha1($_POST['new_mdp_confirm']); 


					if($new_mdp == $new_mdp_confirm){

						if($new_mdp != $res['mdp_admin']){

							$new_mdp = sha1($_POST['new_mdp']);
							$idA = $res['id_admin']; 
							$insertNewMdp = $bdd->prepare('UPDATE administrateur SET mdp_admin = ? WHERE id_admin = ?'); 
							$insertNewMdp->execute(array($new_mdp, $idA)); 
							header("location: ./historiqueAdmin");
						}
						else{
								$error = "Le nouveau mot de passe ne peut pas être le même que l'ancien.";
						}

						
					}
					else{
						$error =  "Les mots de passe sont differents.";
					}

					
				}
				else{
					$error = "Mot de passe trop court";
				}
				
			}
			else{
				$error = "Veuillez remplir tous les champs.";
			}
		}
?>

<!DOCTYPE html>
<html>
<head>
	 			<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ICON -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"></link>
         <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head><br><br><br>
<body>

	<div class="container text-center text-danger"> 
		<?php if(isset($error)){ 		// message d'erreur 
			echo $error;
		}
		?>
	</div>


<?php
		if(isset($_GET['nom'])){
			if(!empty($_GET['nom'])){ ?>

				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<form method="POST">
								<center><h3>Modifier Nom</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
										<input type="text" name="new_nom" class="form-control" value="<?= $res['nom_admin'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_nom"  class="btn btn-primary">Enregistrer</button>
									<a href="./historiqueAdmin" class="btn btn-outline-secondary">Annuler</a>
								</div>
											
								</form>
							</div>
						</div>
					</div>
				</div>

<?php 
			}

		}

		if(isset($_GET['prenom'])){
			if(!empty($_GET['prenom'])){ ?>

				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<form method="POST">
								<center><h3>Modifier Prénom</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Prénom</span>
										<input type="text" name="newPrenom" class="form-control" value="<?= $res['prenom_admin'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_prenom"  class="btn btn-primary">Enregistrer</button>
									<a href="./historiqueAdmin" class="btn btn-outline-secondary">Annuler</a>
								</div>
											
								</form>
							</div>
						</div>
					</div>
				</div>

<?php 
			}

		}

		if(isset($_GET['mail'])){
			if(!empty($_GET['mail'])){ ?>

				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<form method="POST">
								<center><h3>Modifier Mail</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Mail</span>
										<input type="text" name="new_mail" class="form-control" value="<?= $res['mail_admin'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_mail"  class="btn btn-primary">Enregistrer</button>
									<a href="./historiqueAdmin" class="btn btn-outline-secondary">Annuler</a>
								</div>
											
								</form>
							</div>
						</div>
					</div>
				</div>
<?php 
			}
		}

		if(isset($_GET['password'])){
			if(!empty($_GET['password'])){ ?>

				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<form method="POST">
								<center><h3>Modifier Mot de passe</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Nouveau mot de passe</span>
										<input type="password" name="new_mdp" class="form-control" value=""><br>
								</div><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Confirmer le nouveau mot de passe</span>
										<input type="password" name="new_mdp_confirm" class="form-control" value=""><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_mdp" class="btn btn-primary">Enregistrer</button>
									<a href="./historiqueAdmin" class="btn btn-outline-secondary">Annuler</a>
								</div>
											
								</form>
							</div>
						</div>
					</div>
				</div>
<?php 
			}
		}

	?>

</body>
<?php include('../footer.html'); ?>
</html>



<?php 

}
else{
	header("Location: index.php"); 
}

?>