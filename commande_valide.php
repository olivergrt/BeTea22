<?php 
session_start();

if (isset($_SESSION['idClient']) AND isset($_SESSION['numero_Commande'])) {

	unset($_SESSION['TotalCodePromo']); 
	unset($_SESSION['CodeAvantage']);
	unset($_SESSION['cookieOFFERT']);
	header("Refresh: 10; ./accueil");
	$numCommande = $_SESSION['numero_Commande'];
	unset($_SESSION['numero_Commande']); 


?>

<!DOCTYPE html>
<html>
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<meta charset="utf-8">
	<title></title>
</head>
<body style="background: #FAF6EA;">
	<br><br>
	<div class="container">
		<center><h1 style="color: green;">La commande a bien été effectuée !</h1><br>
				<h3>Votre numéro de commande est : <b><?= $numCommande ?>.</b></h3>
				<small>Vous retrouver votre numéro de commande dans la rubrique historique.</small><br><br>
		<a href='index.php'>Retour à la page d'acceuil</a></center>
	</div>
</body>
</html>


<?php }
elseif (isset($_SESSION['idAdmin']) AND isset($_SESSION['numero_Commande'])) {
	
	unset($_SESSION['code_client_commande']); 
	header("Refresh: 5; commandes_admin.php");
	$numCommande = $_SESSION['numero_Commande']; 
	unset($_SESSION['numero_Commande']); 

	?>

	<!DOCTYPE html>
	<html>
	<head>
		<link rel='stylesheet' type='text/css' href='styles.css'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body style="background: #FAF6EA;">
		<br><br>
		<div class="container">
			<center><h1 style="color: green;">La commande a bien été effectuée !</h1><br>
					<h3>Le numéro de commande est : <b><?= $numCommande ?>.</b></h3>
			<a href='commandes_admin.php'>Retour à la page d'acceuil</a></center>
		</div>
	</body>
</html>

<?php 
}
else{
	header("Location: ./connexion"); 
} 

 ?>


<style type="text/css">
*{
  padding: 0;
  margin: 0 auto;
  text-decoration: none;

}

html,body{font-family:Verdana,sans-serif;font-size:15px;line-height:1.5}html{overflow-x:hidden}
h1,h2,h3,h4,h5,h6{font-family:"Segoe UI",Arial,sans-serif;font-weight:400;margin:0px 0}


</style>