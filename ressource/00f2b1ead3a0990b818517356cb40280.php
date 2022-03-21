<?php 
session_start();
require_once("../fonction.php");   
ClientExist();
require_once("../ajax/accesBDD.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php include '../header.php'; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="ressource/style.css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
</head>
<body><br><br>
    <div class="wrapper">
        <div class="title">Chat bot <i class="fa-solid fa-comment-dots"></i></div>
        <form>
            <div class="form">
                <div class="bot-inbox inbox">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="msg-header">
                        <p>Bonjour <?= $info['prenom_client'] ?>,<br>comment pourrais-je<br>t'aider ?</p>
                    </div>
                </div>
       		</div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="data" type="text" placeholder="Posez vos questions.." required>
                    <button id="envoie-btn">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
    <script>
    	$(document).ready(function(){
    		
    		$("#envoie-btn").on("click", function(){
    			// créer la bulle de msg lorsqu'il est envoyé 	
    			$value = $("#data").val(); // recuperation des valeurs entré dans le input
    			$msg = "<div class='user-inbox inbox'><div class='msg-header'><p>" + $value + "</p></div></div>"
    			$(".form").append($msg);  // ajoute le msg dans la conversation
    			$("#data").val(''); // remet le input vide 

    			//ajax 
    			$.ajax({
    				url: 'ajax/message.php',
    				type: 'POST', 
    				data: 'text=' + $value, 
    				
    				success: function(result){
    					
    					$reponse = "<div class='bot-inbox inbox'><div class='icon'><i class='fas fa-user'></i></div><div class='msg-header'><p>" + result + "</p></div></div>"
    					$(".form").append($reponse); 
    					$(".form").scrollTop($(".form")[0].scrollHeight);
    				}
    			}); 
    		});
    	});

    </script>
</body>
</html>

