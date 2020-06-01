<div class="col-md-8 col-xs-12">
    <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center py-4">
            <h4>Transfer</h4>
        </div> <?php
        if(count($kartice) == 0) { ?>
            <div class="alert alert-warning text-center">
                <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
            </div> <?php 
        } else {
            if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9 py-4">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
        <form method="POST" action="<?php echo site_url('Registrovani/transferSubmit'); ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="col-lg-9 form-group">
                    <label for="idKarticeSa">KARTICA SA</label>
                    <select class="form-control form-control-lg selectpicker" name="idKarticeSa" id="idKarticeSa">
                        <?php 
                         foreach ($kartice as $kartica) { ?>
                            <option value="<?php echo $kartica->idKartice; ?>">
                                <?php echo $kartica->automobil.', '.$kartica->stanje.' RSD'; ?>
                            </option> <?php
                         }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 form-group">
                    <label for="idKarticeNa">KARTICE NA</label>
                    <select class="form-control form-control-lg selectpicker" name="idKarticeNa" id="idKarticeNa">
                        <?php 
                         foreach ($kartice as $kartica) { ?>
                            <option value="<?php echo $kartica->idKartice; ?>">
                                <?php echo $kartica->automobil.', '.$kartica->stanje.' RSD'; ?>
                            </option> <?php
                         }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 form-group">
                    <label for="iznos">IZNOS</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="iznos" id="iznos" value="<?php echo set_value('iznos'); ?>">
                      <div class="input-group-append">
                        <span class="input-group-text">RSD</span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                  <button type="submit" class="btn btn-plavi btn-block mt-3 px-5 py-3">POTVRDI</button>
                </div>
            </div>
        </form> <?php
        } ?>
    </div>
</div>