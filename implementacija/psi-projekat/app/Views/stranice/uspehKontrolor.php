<div class="col-md-8 col-xs-12">
    <div class="alert alert-success text-center py-5">
        <h1>
            <?php
                switch ($naslov) {
                    case 'PROVERA - USPEH': echo 'USPEŠNO STE PROVERILI AUTOMOBIL.<br/><br/>';
                        echo $_SESSION['poruka'];
                        break;
                    case 'KAZNA - USPEH': echo 'USPEŠNO STE NAPISALI KAZNU.'; break;
                }
            ?>
        </h1>
    </div>
</div>

