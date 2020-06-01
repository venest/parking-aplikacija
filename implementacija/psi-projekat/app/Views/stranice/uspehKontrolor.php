<div class="col-md-8 col-xs-12">
    <div class="alert <?php if($_SESSION['kaznjen']) echo 'alert-danger'; else echo 'alert-success'; ?> text-center py-5">
        <h2>
            <?php
                switch ($naslov) {
                    case 'PROVERA - USPEH':
                        echo $_SESSION['poruka'];
                        break;
                    case 'KAZNA - USPEH': echo 'USPEŠNO STE EVIDENTIRALI KAZNU.'; break;
                }
            ?>
        </h2>
    </div>
</div>

