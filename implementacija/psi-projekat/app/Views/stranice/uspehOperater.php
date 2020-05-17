<div class="col-md-8 col-xs-12">
    <div class="alert alert-success text-center py-5">
        <h1>
            <?php
                switch ($naslov) {
                    case 'ULAZAK GOST': echo 'USPESNO USAO GOST'; break;
                    case 'ULAZAK REGISTROVANI': echo 'USPESNO USAO REGISTROVANI'; break;
                    case 'IZLAZAK': echo 'USPESNO IZASAO'; break;
                   
                }
            ?>
        </h1>
    </div>
</div>

