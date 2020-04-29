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
    <?php include("navOperater.php"); ?>
    <div class="container">
    <div class="jumbotron pt-0 mb-1">
      <div class="row justify-content-center pt-4 pb-4">
          <h4>Isplata</h4>
        </div>
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
          <div class="col-lg-6 col-md-9">
            <button type="submit" name="evidentirajIsplatu" class="btn btn-plavi btn-block mt-3 pt-3 pb-3">EVIDENTIRAJ ISPLATU</button>
          </div>
          </div>
      </form>
      </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>