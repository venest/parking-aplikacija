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
          <div class="col col-md-9 col-lg-6">
            <div class="form-group">
                <label for="idKartice">ID KARTICE</label>
                <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice" placeholder="unesite ID kartice">
            </div>
              </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="iznos">IZNOS ISPLATE</label>
                <div class="input-group">
                <input type="text" class="form-control form-control-lg" name="iznos" id="iznos" placeholder="unesite iznos">
                <div class="input-group-append">
                  <span class="input-group-text">RSD</span>
                </div>
                </div>
            </div>
              </div>
          </div>
          <div class="row justify-content-center">
            <button type="submit" name="evidentirajIsplatu" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">EVIDENTIRAJ ISPLATU</button>
          </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>