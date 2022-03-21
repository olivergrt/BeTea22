<?php 
session_start(); 

	if(isset($_SESSION['idClient'])){
		
		unset($_SESSION['TotalCodePromo']);
		unset($_SESSION['CodeAvantage']); 
		unset($_SESSION['cookieOFFERT']);
		header("Location: panier_client.php"); 
	}
	else{
		header("Location: connexion.php"); 
	}