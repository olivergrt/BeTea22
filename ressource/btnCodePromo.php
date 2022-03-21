<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Obtenir mon code</button>
<!-- Modal Pop up -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Code avantage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <center><h3 id="copy"><?= $codeAvantages ?></h3></center>
                <br><br><small>Après son utilisation ton nombre de points sera égale à 0 et tu perdras ton rang actuel qui est <?= $rang ?></small>
                <br><br><small>Expire le : <?= $dateExpir ?></small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="copyEvent('copy')">Copier le code</button>
            </div>
        </div>
    </div>
</div>