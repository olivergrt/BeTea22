<?php     
$reqAllCateg = $bdd->query("SELECT id_categorie,libelle_categorie,img_categorie FROM categorie");

 ?>	

		<div class="container"><br><br><br>
			<table class="table text-center">
				<tr>
				<?php  			
				while ($c = $reqAllCateg->fetch()) { ?>
			         	<td>
			         	</td>	      	
			        	<td>
			         		<h3 class="title-dark"><p class="text-primary"><?= $c['libelle_categorie'] ?></p></h3>
			        		<a href="commander-categorie-<?= $c['id_categorie'] ?>">
			        			<img class="imgpdt" style="width: 200px; height: 200px;" src="<?= $c['img_categorie'] ?>"><br><br>
			        		</a>
			        		<a class="btn btn-outline-primary btn-lg" href="commander-categorie-<?= $c['id_categorie'] ?>">Choisir</a><br><br>
			        	</td>
				<?php } ?>
		    	</tr>
	   		</table>	
		</div>


<style type="text/css">
	
@media (max-width: 858px){
  .imgpdt{
    max-height: 100px;
    max-width: 100px;
    -webkit-column-count:2;
  text-align:justify;
  }

}	
</style>
