<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Gubitak kartice</h4>
                </div>
               <?php
               if(isset($poruka)) { ?>
                   <div class="row justify-content-center">
                       <div class="alert text-center alert-danger col-xl-6 col-md-9">
                           <strong><?php 
                           echo $poruka; ?></strong>
                       </div>
                   </div> <?php
               } ?>
                <form method="POST" action="gubitakKarticeSubmit" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="email">EMAIL ADRESA</label>
                      <input type="text" class="form-control form-control-lg" name="email" id="email">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="tablice">AUTOMOBIL</label>
                      <input type="text" class="form-control form-control-lg" name="tablice" id="tablice">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">EVIDENTIRAJ GUBITAK</button>
                    </div>
                  </div>
                </form>
            </div>
</div>