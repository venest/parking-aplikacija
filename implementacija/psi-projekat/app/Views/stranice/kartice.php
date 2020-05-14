<div class="col-md-8 col-xs-12">
    <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center py-4">
            <h4>Kartice</h4>
        </div> <?php
        if(count($kartice) == 0) { ?>
            <div class="alert alert-warning text-center">
                <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
            </div>
        <?php 
        } else { ?>
            <table class="table table-hover">
                <thead>
                    <tr class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">AUTOMOBIL</th>
                        <th scope="col">VAŽI DO</th>
                        <th scope="col">STANJE</th>
                    </tr>
                </thead>
                <tbody> <?php
                foreach ($kartice as $kartica) {
                    $idKartice = $kartica->idKartice;
                    $automobil = $kartica->automobil;
                    $vaziDo = $kartica->vaziDo;
                    $datum = explode("-", $vaziDo);
                    $dan = $datum[2];
                    $mesec = $datum[1];
                    $godina = $datum[0];
                    $vazenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina);
                    $trenutnoUnix = time();
                    $vazeca = ($vazenjeUnix > $trenutnoUnix) ? true : false;
                    $stanje = $kartica->stanje; ?>
                    <tr class="<?php if($vazeca) echo 'table-success'; else echo 'table-danger'; ?>">
                    <th scope="row"> <?php echo $idKartice; ?> </th>
                    <td><?php echo "$automobil"; ?></td>
                    <td><?php echo "$dan."."$mesec."."$godina."; ?></td>
                    <td><?php echo "$stanje"; ?></td>
                    </tr> <?php
                } ?> 
                </tbody>
            </table> <?php
        } ?>
    </div>
</div>