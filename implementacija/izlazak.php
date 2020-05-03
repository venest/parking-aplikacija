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
    <div class="container-fluid">
    <?php include("kontrolnaTablaDugme.php"); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
          <div class="collapse text-center d-md-block" id="side-nav">
            <h5 class="my-4">KONTROLNA TABLA</h5>
            <div class="list-group text-center mb-2">
              <a href="ulazakGost.php" class="list-group-item list-group-item-action py-4">ULAZAK GOST</a>
              <a href="ulazakRegistrovani.php" class="list-group-item list-group-item-action py-4">ULAZAK REGISTROVANI</a>
              <a href="izlazak.php" class="list-group-item list-group-item-action py-4 active">IZLAZAK</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Izlazak</h4>
                </div>
                <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="idKartice">ID KARTICE</label>
                      <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice" placeholder="unesite ID kartice">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" name="evidentirajIzlazak" class="btn btn-plavi btn-block mt-3 py-3">EVIDENTIRAJ IZLAZAK</button>
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