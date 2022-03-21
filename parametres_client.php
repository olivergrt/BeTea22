<?php 
session_start(); 
require_once('fonction.php'); 
ClientExist(); 
require_once('config.php'); 

$info = SelectInfoClient(); 
$idC = $info['id_client'];
ModifierNom($info,$idC);
ModifierPreom($info,$idC); 
ModifierMail($info,$idC); 
ModifierPwd($info,$idC); 
?>

<!DOCTYPE html>
<html>
	<head>
	<header>
		<title>Be Tea</title>
	   	<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		</header><br><br><br>
	</head>
<body>

	<div class="container text-center text-danger"> 
		<?php if(isset($error)){ echo $error;} ?>
	</div>

<?php
		if(isset($_GET['nom'])){
			if(!empty($_GET['nom'])){ ?>

				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 rounded" id="container">
								<form method="POST">
								<center><h3>Modifier Nom</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Nom</span>
										<input maxlength="20" type="text" name="new_nom" class="form-control" value="<?= $info['nom_client'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_nom"  class="btn btn-primary">Enregistrer</button>
									<a href="./accueil" class="btn btn-outline-secondary">Annuler</a>
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
							<div class="shadow-lg p-3 mb-5 rounded" id="container">
								<form method="POST">
								<center><h3>Modifier Prénom</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Prénom</span>
										<input maxlength="20" type="text" name="newPrenom" class="form-control" value="<?= $info['prenom_client'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_prenom"  class="btn btn-primary">Enregistrer</button>
									<a href="./accueil" class="btn btn-outline-secondary">Annuler</a>
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
							<div class="shadow-lg p-3 mb-5 rounded" id="container">
								<form method="POST">
								<center><h3>Modifier Mail</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Mail</span>
										<input maxlength="30" type="text" name="new_mail" class="form-control" value="<?= $info['mail_client'] ?>"><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_mail"  class="btn btn-primary">Enregistrer</button>
									<a href="./accueil" class="btn btn-outline-secondary">Annuler</a>
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

<?php
		if(isset($_GET['password'])){
			if(!empty($_GET['password'])){ ?>


				<div class="container">
					<div class="row justify-content-center">
						<div class="col-sm-6" >
							<div class="shadow-lg p-3 mb-5 rounded" id="container">
								<form method="POST">
								<center><h3>Modifier Mot de passe</h3></center><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Nouveau mot de passe</span>
										<input maxlength="30" type="password" name="new_mdp" class="form-control" value=""><br>
								</div><br>

								<div class="input-group input-group-mb-3">
										<span class="input-group-text" id="inputGroup-sizing-default">Confirmer le nouveau mot de passe</span>
										<input maxlength="30" type="password" name="new_mdp_confirm" class="form-control" value=""><br>
								</div><br>

								<div class="d-grid gap-4">
									<button name="btn_modif_mdp" class="btn btn-primary">Enregistrer</button>
									<a href="./accueil" class="btn btn-outline-secondary">Annuler</a>
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
<?php include('footer.html'); ?>
</html>


<style type="text/css">
	
	body{
		background: #DDEAFC;
	}
	div#container{
		background: #F3F5F9;
	}
</style>