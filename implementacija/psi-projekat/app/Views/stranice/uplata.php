<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Uplata</h4>
                </div>
                <?php
                if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9 py-4">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
                <form method="POST" action="uplataNaKarticuSubmit" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="idKartice">ID KARTICE</label>
                      <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice" value="<?php echo set_value('idKartice'); ?>">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="iznos">IZNOS UPLATE</label>
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
                      <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">EVIDENTIRAJ UPLATU</button>
                    </div>
                  </div>
                </form>
            </div>
</div>