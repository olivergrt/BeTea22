<?php 

$reqAllclient = $bdd->query("SELECT id_client, code_client, nbr_point_client FROM client"); 

?>

<div class="container"><br>
		<h1 class="title text-light">Client</h1><br><br>
		<table class="table table-hover">
			<thead>
				<tr class="table-primary">
					<td>
						ID client
					</td>
					<td>
						Code Client
					</td>
					<td>
						Nombre point
					</td>
					<td>
						Rang
					</td>
				</tr>
			</thead>
			<tbody>
				<?php 

				 while ($p = $reqAllclient->fetch()) {
				  
				?>
				<tr class="table-secondary">
					<td>
						<?= $p["id_client"] ?>
					</td>
					<td>
						<?= $p["code_client"] ?>
					</td>
					<td>
						<?= $p["nbr_point_client"] ?>
					</td>
					<td>
						<?php 

							if($p['nbr_point_client'] >= 10){

								$rang = "Classic"; 

								if($p['nbr_point_client'] >= 100){

									$rang = "Medium"; 

									if($p['nbr_point_client'] >= 300){

										$rang = "Expert"; 
									}
								}
							}
						?>
						 <?= $rang ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
			
		</table><br><br>
	</div>