<div class="col-md-8 col-xs-12">
    <div class="alert alert-success text-center py-5">
        <h2>
            <?php
                switch ($naslov) {
                    case 'IZDAVANJE KARTICE - USPEH': echo 'USPEŠNO STE IZDALI KARTICU.'; break;
                    case 'UPLATA - USPEH': echo 'USPEŠNO STE IZVRŠILI UPLATU.'; break;
                    case 'ISPLATA - USPEH': echo 'USPEŠNO STE IZVRŠILI ISPLATU.'; break;
                    case 'OBNOVA KARTICE - USPEH': echo 'USPEŠNO STE OBNOVILI KARTICU.'; break;
                    case 'GUBITAK KARTICE - USPEH': 
                        echo 'USPEŠNO STE EVIDENTIRALI GUBITAK KARTICE.'; 
                        echo "<br>";
                        echo $poruka;
                        break;
                }
            ?>
        </h2>
    </div>
</div>

