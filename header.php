<?php
$info = SelectInfoClient(); 
$nbArticle = GetNbrProduitPanier(); 

?>
<header>
  <title>Be Tea</title>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a38abeb69f.js" crossorigin="anonymous"></script>
    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"></link>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img style="width: 35px; border-radius: 50px;" class="" src="ressource/images/logo.jpg"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
              <a class="nav-link" href="./accueil"><i class="fas fa-home"></i></a>       
              <a class="nav-link" href="./commander"><i class="fas fa-cookie-bite"></i></a>
              <a class="nav-link" href="./historique-<?= $info ['prenom_client'] ?>"><i class="fas fa-list"></i></a>
              <a class="nav-link" href="./mon-panier"> 
              <?php 
                  // Quantité panier
                  if(isset($nbArticle) AND $nbArticle > 0){ ?>
                  <small><i class="fas fa-shopping-bag"></i> <?= $nbArticle ?></small>
              <?php }
                    else{ ?>
                        <small><i class="fas fa-shopping-bag"></i></small>
                <?php    }  
                   ?>
              </a>
              <a class="nav-link" href="./aide"><i class="fa-solid fa-comment-dots"></i></a>


              <div class="btn-group">
                <button class="btn btn-dark text-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-cogs"></i>
                </button>
                
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li>
                    <a class="dropdown-item" href="parametre-nom">Nom <small class="text-secondary"><?= $info ['nom_client'] ?></small></a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="parametre-prenom">Prénom <small class="text-secondary"><?= $info ['prenom_client'] ?></small></a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="parametre-mail">Mail <small class="text-secondary"><?= $info ['mail_client'] ?></small></a>
                  </li>
                  <li><a class="dropdown-item" href="parametre-mot-de-passe">Mot de passe</a></li>
                  <li><a class="dropdown-item" href="parametre-mot-de-passe">Supprimer mon compte</a></li>
                  <li><a class="dropdown-item text-danger" href="./deconnexion">Déconnexion</a></li>                    
                </ul>
              </div>
        </div>
      </div>
    </div>
  </nav>
</header><br><br><br>