<?php
session_start(); 
include("../config.php"); 

if(!isset($_SESSION['idAdmin'])){
	if(isset($_POST['submit'])){
	    if(!empty($_POST['email']) AND !empty($_POST['password'])){

	        $email =  htmlspecialchars($_POST['email']); 
					$pwd = sha1($_POST['password']); 

					$reqVerifEmail = $bdd->prepare("SELECT id_admin FROM administrateur WHERE mdp_admin = ? AND mail_admin = ?"); 
					$reqVerifEmail->execute(array($pwd, $email)); 
					$res = $reqVerifEmail->rowCount(); 

					if ($res == 1) {
						
						$info = $reqVerifEmail->fetch();
						$_SESSION['idAdmin'] = $info['id_admin']; 
						header("Location: ./historiqueAdmin");
					}
					else{
						$erreur = "Identifiant ou mot de passe incorect !";
					}
	    }
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
<body class="bg-secondary">


	<?php 
		if (isset($erreur)) {
			echo "<center style='color : red'>".$erreur."</center>";
		}		
		?>

	<div class="container">
		<br><br><br>
		<div class="row justify-content-center">
			<div class="col-sm-6">
				<div class="shadow-lg p-3 mb-5 bg-body rounded">

				<h1 class="text-center">Connexion</h1>
					<br>
					<form method="POST" action="">

						<div class="form-group">
							<label>Saisir votre adresse mail :</label>
							<input class="form-control" type="text" name="email" value="test@test.fr">	
						</div>

						<div class="form-group">

							<label>Saisir votre mot de passe :</label>
							<input class="form-control" type="password" name="password" value="azertyuiop" required>
							<small class="form-text text-muted"><a href="">Mot de passe oublié.</a></small>

						</div>
						<br>
						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="exampleCheck1">
							<label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
						</div>

						<button class="btn btn-primary" name="submit">Se connecter</button><br><br>
						<a class="btn btn-outline-dark" href="./connexion">Connexion client</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>


<?php 
}
else{
	header("Location: ./historiqueAdmin"); 
}