<div class="container">
    <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center py-4">
          <h4>Prijavite se na svoj nalog</h4>
        </div> <?php
        if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-xl-6 col-md-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
        } ?>
        <form method="POST" action="<?php echo site_url('Gost/prijaviSe'); ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="form-group col-xl-6 col-md-9">
                  <label for="korisnickoIme">KORISNIČKO IME ILI EMAIL ADRESA</label>
                  <input type="text" name="korisnickoIme" class="form-control form-control-lg" id="korisnickoIme" value="<?php echo set_value('korisnickoIme'); ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-xl-6 col-md-9" id="lozinka">
                  <label for="lozinka">LOZINKA</label>
                  <input type="password" name="lozinka" class="form-control form-control-lg" id="lozinka">
                </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9">
              <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">PRIJAVI SE</button>
            </div>
            </div>
        </form>
        <div class="row justify-content-center mt-4">
          <h5> <a href="<?php echo site_url('Gost/registracija'); ?>" class="link-registruj-se"> Nemate nalog? Registrujte se. </a> </h5>
        </div>
    </div>
</div>