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
    <title>ADMIN</title>
  </head>
  <body>
    <?php include("navAdmin.php"); ?>
    <div class="container-fluid">
    <?php include("kontrolnaTablaDugme.php"); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
          <div class="collapse text-center d-md-block" id="side-nav">
            <h5 class="my-4">KONTROLNA TABLA</h5>
            <div class="list-group text-center mb-2">
              <a href="izdavanjeKartice.php" class="list-group-item list-group-item-action py-4">IZDAVANJE KARTICE</a>
              <a href="obnovaKarticeOperater.php" class="list-group-item list-group-item-action py-4">OBNOVA KARTICE</a>
              <a href="uplata.php" class="list-group-item list-group-item-action py-4">UPLATA</a>
              <a href="isplata.php" class="list-group-item list-group-item-action py-4">ISPLATA</a>
              <a href="gubitakKartice.php" class="list-group-item list-group-item-action py-4 active">GUBITAK KARTICE</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Gubitak kartice</h4>
                </div>
                <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="tablice">AUTOMOBIL</label>
                      <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite broj tablica">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="email">EMAIL ADRESA</label>
                      <input type="text" class="form-control form-control-lg" name="email" id="email" placeholder="unesite email">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" name="evidentirajGubitak" class="btn btn-plavi btn-block mt-3 py-3">EVIDENTIRAJ GUBITAK</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>