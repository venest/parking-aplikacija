<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Isplata</h4>
                </div>
                <?php 
                if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
                <form method="POST" action="isplataSaKarticeSubmit" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="idKartice">ID KARTICE</label>
                      <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice"
                             value="<?php 
                            if(isset($vrednost)){
                             if(strcmp($poruka, "KARTICA SA DATIM ID NE POSTOJI U BAZI.")!=0 &&
                                  strcmp($poruka, "KARTICA SA DATIM ID PRIPADA GOSTU I NE MOZE SE IZVRSITI ISPLATA")!=0 &&
                                    strcmp($poruka, "NA KARTICI NEMA DOVOLJNO SREDSTAVA. POKUSAJTE ISPLATU MANJE SUME.")!=0)
                                echo $vrednost;
                            }
                        ?>">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="iznos">IZNOS ISPLATE</label>
                      <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="iznos" id="iznos">
                        <div class="input-group-append">
                          <span class="input-group-text">RSD</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-plavi btn-block mt-3 pt-3 pb-3">EVIDENTIRAJ ISPLATU</button>
                    </div>
                  </div>
                </form>
            </div>
</div>