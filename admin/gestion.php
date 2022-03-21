<?php 
session_start(); 
require_once('../config.php');
if(isset($_SESSION['idAdmin'])){

?>

<!DOCTYPE html>
<html>
<?php include 'header.php'; ?>
<body>
	<?php 

	if (isset($_GET['gestion'])) {

	switch ($_GET['gestion']) {

		case 'categorie':
			include('gestion/categorie.php');
			exit;
			break;


		case 'commandes':
			include('gestion/commandes.php');
			exit;
			break;

		case 'produit':
			include('gestion/produit.php');
			exit;
			break;


		case 'supplement':
			include('gestion/supplement.php');
			exit;
			break;

		case 'codepromo':
			include('gestion/codepromo.php');
			exit;
			break;

		case 'client':
			include('gestion/client.php');
			exit;
			break;

		case 'rang':
			include('gestion/rang.php');
			exit;
			break;
		
		}
	}

	?>

</body>
<?php include('../footer.html'); ?>
</html>
<?php 
}
else{
	header("Location: connexion.php"); 
}
	


