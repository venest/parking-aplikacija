<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Promena lozinke</h4>
                </div> <?php
            if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-lg-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
                <form method="POST" action="<?php echo site_url('Registrovani/promenaLozinkeSubmit'); ?>">
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="staraLozinka">STARA LOZINKA</label>
                        <input type="password" class="form-control form-control-lg" id="staraLozinka" name="staraLozinka" value="<?php echo set_value('staraLozinka'); ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="novaLozinka">NOVA LOZINKA</label>
                        <input type="password" class="form-control form-control-lg" id="novaLozinka" name="novaLozinka" value="<?php echo set_value('novaLozinka'); ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="novaLozinkaPonovo">PONOVITE NOVU LOZINKU</label>
                        <input type="password" class="form-control form-control-lg" id="novaLozinkaPonovo" name="novaLozinkaPonovo" value="<?php echo set_value('novaLozinkaPonovo'); ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">PROMENI LOZINKU</button>
                    </div>
                </div>
            </form>
            </div>
</div>