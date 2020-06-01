<div class="col-md-8 col-xs-12">
    <div class="alert alert-success text-center py-5">
        <h2>
            <?php
                switch ($naslov) {
                    case 'PROMENA LOZINKE - USPEH': echo 'USPEŠNO STE SE PROMENILI LOZINKU.'; break;
                    case 'TRANSFER - USPEH': echo 'USPEŠNO STE OBAVILI TRANSFER.'; break;
                    case 'PROFIL - USPEH': echo 'USPEŠNO STE IZMENILI PROFIL.'; break;
                    case 'OBNOVA KARTICE - USPEH': echo 'USPEŠNO STE OBNOVILI KARTICU.'; break;
                }
            ?>
        </h2>
    </div>
</div>


