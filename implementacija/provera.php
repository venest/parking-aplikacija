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
    <title>KONTROLOR</title>
  </head>
  <body>
    <div class="container" style="margin-top: 20px;">
        <?php include("kontrolorHeder.php"); ?>
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="tablice">BROJ REGISTARSKIH TABLICA</label>
                <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite broj tablica">
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <button type="submit" name="provera" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">PROVERA</button>
          </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>