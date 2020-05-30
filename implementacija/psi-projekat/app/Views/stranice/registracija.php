<div class="container">
    <div class="jumbotron pt-0 mb-1">
        <div class="row py-4">
          <div class="col">
            <h4>Registracija</h4>
          </div>
        </div> <?php
        if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-xl-6 col-md-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
        } ?>
        <form method="POST" action="<?php echo site_url('Gost/registrujSe'); ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="form-group col-lg-6">
                  <label for="ime">IME</label>
                  <input type="text" name="ime" class="form-control form-control-lg" id="ime" value="<?php echo set_value('ime'); ?>">
                </div>
                <div class="form-group col-lg-6">
                  <label for="prezime">PREZIME</label>
                  <input type="text" name="prezime" class="form-control form-control-lg" id="prezime" value="<?php echo set_value('prezime'); ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6">
                  <label for="grad">GRAD</label>
                  <input type="text" name="grad" class="form-control form-control-lg" id="grad" value="<?php echo set_value('grad'); ?>">
                </div>
                <div class="form-group col-lg-6">
                  <label for="adresa">ADRESA</label>
                  <input type="text" name="adresa" class="form-control form-control-lg" id="adresa" value="<?php echo set_value('adresa'); ?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-lg-6">
                <label for="email">EMAIL ADRESA</label>
                <input type="text" name="email" class="form-control form-control-lg" id="emailRegistracija" value="<?php echo set_value('email'); ?>">
              </div>
              <div class="form-group col-lg-6">
                  <label for="telefon">TELEFON</label>
                  <input type="text" name="telefon" class="form-control form-control-lg" id="telefon" value="<?php echo set_value('telefon'); ?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-lg-6">
                <label for="password">LOZINKA</label>
                <input type="password" name="lozinka" class="form-control form-control-lg" id="lozinkaRegistracija" value="<?php echo set_value('lozinka'); ?>">
              </div>
              <div class="form-group col-lg-6">
                <label for="ponovljenPassword">PONOVITE LOZINKU</label>
                <input type="password" name="ponovljenaLozinka" class="form-control form-control-lg" id="ponovljenaLozinkaRegistracija" value="<?php echo set_value('ponovljenaLozinka'); ?>">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-9">
              <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">REGISTRUJ SE</button>
            </div>
            </div>
        </form>
    </div>
</div>