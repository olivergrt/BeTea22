<?php 

$reqAllrang = $bdd->query("SELECT * FROM rang"); 

?>

<div class="container"><br>
		<h1 class="title">Rangs</h1><br>
		<table class="table table-hover">
			<thead>
				<tr class="table-primary">
					<td>
						ID rang
					</td>
					<td>
						Libelle
					</td>
					<td>
						Palier
					</td>
				</tr>
			</thead>
			<tbody>
				<?php 

				 while ($p = $reqAllrang->fetch()) {
				  
				?>
				<tr class="table-secondary">
					<td>
						<?= $p["id_rang"] ?>
					</td>
					<td>
						<?= $p["libelle_rang"] ?>
					</td>
					<td>
						<?= $p["palier"] ?>
					</td>
				<?php } ?>
				</tr>
			</tbody>
			
		</table><br><br>
	</div>