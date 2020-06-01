<div class="col-md-8 col-xs-12">
    <div class="alert alert-success text-center py-5">
        <h2>
            <?php
                switch ($naslov) {
                    case 'ULAZAK GOST': 
                        echo 'USPESNO USAO GOST';
                        echo '<br/>'; 
                        echo 'ID kartice: '.$_SESSION['ID'];
                    break;
                    case 'ULAZAK REGISTROVANI': echo 'USPEŠNO UŠAO REGISTROVANI'; break;
                    case 'IZLAZAK':
                        echo 'USPEŠNO IZAŠAO';
                        echo "</br>";
                        echo "ID korisnika: ".$_SESSION['ID'] ;
                        $_SESSION['ID'] = '';
                        if($cena > 0) echo 'Placen racun od: '.$cena.'.00 dinara!';
                        break;
                   
                }
            ?>
        </h2>
    </div>
    
</div>

