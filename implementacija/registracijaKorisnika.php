<?php
  session_start();
  $korisnickoIme = $_SESSION["korisnickoIme"];
  if(!isset($_SESSION["ulogovan"])) { 
    header("Location: logovanje.php");
    exit();
  } 
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>OPERATER</title>
  </head>
  <body>
    <div class="container" style="margin-top: 20px;">
      <?php include("operaterHeder.php"); ?>
      <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="form-group col-md-9 col-lg-6">
                  <label for="ime">IME</label>
                  <input type="text" class="form-control form-control-lg" name="ime" id="ime" placeholder="unesite ime">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-9 col-lg-6">
                  <label for="prezime">PREZIME</label>
                  <input type="text" class="form-control form-control-lg" name="prezime" id="prezime" placeholder="unesite prezime">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                <label for="email">EMAIL ADRESA</label>
                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="unesite email">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                <label for="lozinka">LOZINKA</label>
                <input type="password" class="form-control form-control-lg" name="lozinka" id="lozinka" placeholder="unesite lozinku">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                  <label for="grad">GRAD</label>
                  <input type="text" class="form-control form-control-lg" name="grad" id="grad" placeholder="unesite grad">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                  <label for="adresa">ADRESA</label>
                  <input type="text" class="form-control form-control-lg" name="adresa" id="adresa" placeholder="unesite ulicu i broj">
               </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                  <label for="telefon">TELEFON</label>
                  <input type="text" class="form-control form-control-lg" name="telefon" id="telefon" placeholder="unesite telefon">
               </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" name="potvrdiRegistraciju" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">POTVRDI REGISTRACIJU</button>
            </div>
        </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>