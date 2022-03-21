<?php 

$reqCmdAttente = $bdd->query("SELECT COUNT(id_commande) FROM commande WHERE statut_commande = 'En attente'");
    $resCount = $reqCmdAttente->fetch();

    $id = $_SESSION['idAdmin']; 
        $reqAllInfo = $bdd->query("SELECT nom_admin,prenom_admin,mail_admin FROM administrateur WHERE id_admin = $id"); 
        $res = $reqAllInfo->fetch(); 


    ?>


<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/a38abeb69f.js" crossorigin="anonymous"></script>
        <!-- ICON -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"></link>
         <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <title>Be Tea</title>
    </head>
    <header>
	    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Be Tea</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="./historiqueAdmin"><i class="fas fa-list"></i></a>

                        <div class="btn-group">
                            <button class="btn btn-dark text-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tasks"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                                <li> <hr class="dropdown-divider"><center class="text-secondary">Stock</center></li>
                                <li><a class="dropdown-item" href="./gestion-commandes">Commandes <small class="text-danger"><?php if(isset($resCount["COUNT(id_commande)"])){ ?>+ <?=$resCount["COUNT(id_commande)"]?> en attente. <?php }?></small></a></li>
                                <li><a class="dropdown-item" href="./gestion-categories">Catégories <small class="text-secondary"></small></a></li>
                                <li><a class="dropdown-item" href="./gestion-produits">Produits <small class="text-secondary"></small></a></li>
                                <li><hr class="dropdown-divider"><center class="text-secondary">Administration</center></li>
                                <li><a class="dropdown-item" href="./gestion-codespromo">Code promo</a></li>
                                <li><a class="dropdown-item" href="./gestion-clients">Clients</a></li>
                                <li><a class="dropdown-item" href="./gestion-rangs">Rangs</a></li>
                            </ul>
                        </div> 
                    <a class="nav-link" href="aide-client"><i class="fa-solid fa-comment-dots"></i></a>


                        <div class="btn-group">
                          <button class="btn btn-dark text-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="parametres-nom">Nom <small class="text-secondary"><?= $res ['nom_admin'] ?></small></a></li>
                            <li><a class="dropdown-item" href="parametres-prenom">Prénom <small class="text-secondary"><?= $res ['prenom_admin'] ?></small></a></li>
                            <li><a class="dropdown-item" href="parametres-mail">Mail <small class="text-secondary"><?= $res ['mail_admin'] ?></small></a></li>
                            <li><a class="dropdown-item" href="parametres-password">Mot de passe</a></li>
                            <li><a class="dropdown-item text-danger" href="deconnexion.php">Déconnexion</a></li>                    
                          </ul>
                        </div>
                    </div>
                </div>    
          </div>
        </nav>
    </header>