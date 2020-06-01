<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Provera</h4>
                </div>
                <?php 
                if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9 py-4">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
                <form method="POST" action="proveraAutomobila" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="col-lg-9 form-group">
                        <label for="tablice">AUTOMOBIL</label>
                        <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" value="<?php echo set_value('tablice'); ?>">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">PROVERA</button>
                    </div>
                  </div>
                </form>
            </div>
</div>