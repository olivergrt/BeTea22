<?php 

$connexion = mysqli_connect("127.0.0.1", "root", "", "betea") or die ("Erreur"); ; 
$getMsg = mysqli_real_escape_string($connexion, $_POST['text']); 

$verif_data = "SELECT reponses FROM chatbot WHERE requetes LIKE '%$getMsg%'"; 
$run_req = mysqli_query($connexion, $verif_data) or die ("Erreur"); 

if(mysqli_num_rows($run_req) > 0){

	$fetch_data = mysqli_fetch_assoc($run_req);
	$reponse = $fetch_data['reponses']; 
	echo utf8_encode($reponse);
}
else{
	echo "Desolé je n'arrive pas à<br> comprendre.";
}


