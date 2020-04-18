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
            <label for="brojTablica">BROJ REGISTARSKIH TABLICA</label>
            <input type="text" class="form-control form-control-lg" name="brojTablica" id="brojTablica" placeholder="unesite broj tablica">
          </div>
        </div>
      <div class="row justify-content-center">
        <button type="submit" name="izdavanjeKartice" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">IZDAVANJE KARTICE</button>
      </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>