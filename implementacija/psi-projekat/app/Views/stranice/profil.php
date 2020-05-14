<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                  <div class="col">
                    <h4>Profil</h4>
                  </div>
                </div> <?php
            if(isset($poruka)) { ?>
            <div class="row justify-content-center">
                <div class="alert text-center alert-danger col-xl-6 col-md-9">
                    <strong><?php echo $poruka; ?></strong>
                </div>
            </div> <?php
            } ?>
                <form method="POST" action="<?php echo site_url('Registrovani/izmenaProfilaSubmit'); ?>" autocomplete="off">
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="ime">EMAIL ADRESA</label>
                        <input type="text" name="email" class="form-control form-control-lg" id="email" value="<?php if($pritisnuoDugme) echo set_value('email'); else echo $korisnik->email; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="telefon">TELEFON</label>
                        <input type="text" name="telefon" class="form-control form-control-lg" id="telefon" value="<?php if($pritisnuoDugme) echo set_value('telefon'); else echo $korisnik->telefon; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="ime">IME</label>
                        <input type="text" name="ime" class="form-control form-control-lg" id="ime" value="<?php if($pritisnuoDugme) echo set_value('ime'); else echo $korisnik->ime; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="prezime">PREZIME</label>
                        <input type="text" name="prezime" class="form-control form-control-lg" id="prezime" value="<?php if($pritisnuoDugme) echo set_value('prezime'); else echo $korisnik->prezime; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="grad">GRAD</label>
                        <input type="text" name="grad" class="form-control form-control-lg" id="grad" value="<?php if($pritisnuoDugme) echo set_value('grad'); else echo $korisnik->grad; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="adresa">ADRESA</label>
                        <input type="text" name="adresa" class="form-control form-control-lg" id="adresa" value="<?php if($pritisnuoDugme) echo set_value('adresa'); else echo $korisnik->adresa; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <button type="submit" name="sacuvajIzmene" class="btn btn-plavi btn-block mt-3 py-3">SAČUVAJ IZMENE</button>
                    </div>               
                </div>
            </form>
            </div>
</div>