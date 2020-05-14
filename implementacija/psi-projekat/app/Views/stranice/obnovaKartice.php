<div class="col-md-8 col-xs-12">
    <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center py-4">
            <h4>Obnova kartice</h4>
        </div> <?php
        if(count($kartice) == 0) { ?>
            <div class="alert alert-warning text-center">
                <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
            </div> <?php 
        } else {
            if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
        <form method="POST" action="<?php echo site_url('Registrovani/obnovaKarticeSubmit'); ?>" autocomplete="off">
              <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="idKartice">KARTICA</label>
                  <select class="form-control form-control-lg selectpicker" name="idKartice">
                        <?php 
                         foreach ($kartice as $kartica) { ?>
                            <option value="<?php echo $kartica->idKartice; ?>">
                                <?php 
                                    $datum = explode('-', $kartica->vaziDo);
                                    $dan = $datum[2];
                                    $mesec = $datum[1];
                                    $godina = $datum[0];
                                    echo $kartica->automobil.', '.$kartica->stanje.' RSD, '.$dan.'.'.$mesec.'.'.$godina.'.'; 
                                ?>
                            </option> <?php
                         }
                        ?>
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="period">PERIOD</label>
                  <select class="form-control form-control-lg selectpicker" name="period">
                    <option value="dan">DAN, 200 RSD</option>
                    <option value="sedmica">SEDMICA, 800 RSD</option>
                    <option value="mesec">MESEC, 2000 RSD</option>
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-lg-9">
                  <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">POTVRDI</button>
                </div>
              </div>
            </form> <?php
        } ?>
    </div>
</div>
