<?php 
session_start(); 

if(isset($_SESSION['idClient'])){

	$_SESSION = array(); 
	session_destroy(); 
	header("Location: ./connexion");
}
elseif(isset($_SESSION['idAdmin'])){

	$_SESSION = array(); 
	session_destroy(); 
	header("Location: ./administrateur");
}
else{
	header("Location: ./connexion"); 
}
	 