<?php
session_start(); 
include("config.php"); 
require_once("fonction.php");

if(!isset($_SESSION['idClient'])){

	ConnexionClient();

	if(isset($_POST['inscription'])){
			header("Location: ./inscription"); 
	}


?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Be Tea</title>
  </head>
<body><br>

	<div class="container text-center text-danger">
	<?php 
		if (isset($error)) {
			echo $error;
		}		
		?>
	</div>

	<div class="container">
		<br><br>
		<div class="row justify-content-center">
			<div class="col-sm-6" >
				<div class="shadow-lg p-3 mb-5 bg-body rounded">
					
					<center><img style="width: 90px; border-radius: 50px;" class="" src="ressource/images/logo.jpg"><h2>Connexion</h2></center>
					<br>
					<form method="POST" action="">

						<div class="form-group">
							<label>Saisir votre adresse mail :</label>
							<input class="form-control" type="text" name="email" value="oliver.grant@gmail.com">	
						</div>
						<br>
						<div class="form-group">

							<label>Saisir votre mot de passe :</label>
							<input class="form-control" type="password" name="password" value="azertyuiop" required>
							<small id="emailHelp" class="form-text text-muted"><a href="">Mot de passe oublié.</a></small>

						</div>
						<br>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="exampleCheck1">
							<label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
						</div>

						<button class="btn btn-primary" name="submit">Se connecter</button>
						<button class="btn btn-outline-secondary" name="inscription">S'inscrire</button><br><br>
						<a class="btn btn-outline-dark" href="administrateur">Connexion Admin</a>

					</form>		
				</div>
			</div>
		</div>
	  	
	</div>
</body>

<?php 
}
else{
	header("Location: ./accueil"); 
}