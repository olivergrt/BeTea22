<?php
 require_once('config.php'); 

 if(isset($_POST['inscription'])){

 	if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['tel']) AND !empty($_POST['dateNaiss']) AND !empty($_POST['password_confirm']) AND !empty($_POST['password_confirm'])){

 		$prenom = htmlspecialchars($_POST['prenom']); 
	 	$nom = htmlspecialchars($_POST['nom']); 
	 	$email = htmlspecialchars($_POST['email']); 
	 	$dateNaiss = htmlspecialchars($_POST['dateNaiss']);
	 	$tel = htmlspecialchars($_POST['tel']);
	 	$password = htmlspecialchars($_POST['password']); 
	 	$password_confirm = htmlspecialchars($_POST['password_confirm']);  

	 	$code_client = "BT";   

 		if (filter_var($email, FILTER_VALIDATE_EMAIL)){

			$passwordLength = strlen($password);
            $passwordConfirmL = strlen($password_confirm);
            if($passwordLength >= 8 AND $passwordConfirmL >= 8){

            	if($password == $password_confirm){

            		$longueur = 7; 
            		for($i=1;$i<$longueur;$i++){   // Creation du code client avec des chiffres aléatoires
                        	
                        $code_client .= mt_rand(0,9);
                      	  
                    }

            		$password = sha1($password_confirm);

								require_once 'phpqrcode/qrlib.php';
								$chemin = 'phpqrcode/qr_code';
								$chemin_qr_code = $chemin.uniqid().".png";
								$qr_contenue = $code_client;
								QRcode::png($qr_contenue, $chemin_qr_code); // genere un code qr

            		$insertmbr = $bdd->prepare('INSERT INTO client(code_client,prenom_client, nom_client, mail_client, date_naiss_client, tel_client, mdp_client, chemin_qr_code) VALUES (?,?,?,?,?,?,?,?)'); 
                $insertmbr->execute(array($code_client,$prenom, $nom, $email, $dateNaiss, $tel, $password, $chemin_qr_code));
                header("Location: ./connexion");  

	            }
	            else{
                    $erreur = "Vos mots de passe ne correpondent pas"; 
              }
	 		}
	 		else{
                $erreur = "Votre mot de passe doit comporter au minimum de 8 caractères";
              }
	 	}
	 	else{
        $erreur = "Votre adresse mail n'est pas valide";
      }
	}
	else{
      $erreur = "Tous les champs doivent être complétés";
    }
}

if(isset($_POST['back'])){
	header("Location: ./connexion"); 
}

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Be Tea</title>
  </head>
<body style="background: #FAF6EA;">

	<?php 
		if (isset($erreur)) {
			echo "<br><center style='color : red'>".$erreur."</center>";
		}		
		?>

	<div class="container">
	   
		
	<br><br><br>
		<div class="row justify-content-center">
			<div class="col-sm-6">
				<div class="shadow-lg p-3 mb-5 bg-body rounded">
					<form method="POST"><button class="btn btn-outline-secondary" name="back">Retour à la connexion</button></form>
					<h1 class="text-center">Inscription</h1>
		
					<form method="POST" action="">

						<div class="form-group">
							<label>Votre Prénom :</label>
							<input class="form-control" type="text" name="prenom">	
						</div>

						<div class="form-group">
							<label>Votre Nom :</label>
							<input class="form-control" type="text" name="nom">	
						</div>


						<div class="form-group">
							<label>Votre adresse mail :</label>
							<input class="form-control" type="email" name="email">	
						</div>

						<div class="form-group">
							<label>Votre numéro de téléphone :</label>
							<input class="form-control" type="number" name="tel">	
						</div>

						<div class="form-group">
							<label>Votre Date de naissance :</label>
							<input class="form-control" type="date" name="dateNaiss">	
						</div>

						<div class="form-group">

							<label>Votre mot de passe :</label>
							<input class="form-control" type="password" name="password">

						</div>

						<div class="form-group">

							<label>Confirmer le mot de passe :</label>
							<input class="form-control" type="password" name="password_confirm">
						</div><br>
						<button class="btn btn-primary" name="inscription">Valider l'inscription</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>