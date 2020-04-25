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
    <div class="container-fluid">
        <?php include("kontrolorHeder.php"); ?>
    </div>
    <div class="container">
    <div class="jumbotron bg-siva">
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
            <button type="submit" name="provera" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">PROVERA</button>
          </div>
      </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>