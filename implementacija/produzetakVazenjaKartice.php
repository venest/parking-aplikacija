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
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="idKartice">ID KARTICE</label>
              <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice" placeholder="unesite ID kartice">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="datum">BROJ DANA ILI DATUM PRODUŽENJA (DATUM DO)</label>
              <input type="text" class="form-control form-control-lg" name="datumDo" id="datumDo" placeholder="unesite broj dana ili datum (dan.mesec.godina.)">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" name="evidentirajProduzenje" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">EVIDENTIRAJ PRODUŽENJE</button>
        </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>