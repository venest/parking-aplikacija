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
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>OPERATER</title>
  </head>
  <body>
    <div class="container-fluid">
      <?php include("operaterHeder.php"); ?>
    </div>
    <div class="container">
    <div class="jumbotron bg-siva">
      <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
          <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="email">EMAIL ADRESA</label>
                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="unesite email">
              </div>
          </div>
          <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="tablice">AUTOMOBIL</label>
                <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite tablice">
              </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group col-lg-6 col-md-9">
              <label for="datumDo">BROJ DANA ILI DATUM VAŽENJA (DATUM DO)</label>
              <input type="text" class="form-control form-control-lg" name="datumDo" id="datumDo" placeholder="unesite broj dana ili datum (dan.mesec.godina.)">
            </div>
        </div>
          <div class="row justify-content-center">
            <button type="submit" name="izdavanjeKartice" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">IZDAVANJE KARTICE</button>
          </div>
      </form>
      </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>