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
          <h4>Pronađi id kartice</h4>
        </div>
      <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="tablice">TABLICE</label>
                <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite broj tablica">
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <div class="form-group">
            <label for="tipKorisnika">TIP KORISNIKA</label>
                <select class="form-control form-control-lg" id="tipKorisnika" name="tipKorisnika">
                    <option value="gost">GOST</option>
                    <option value="registrovani">REGISTROVANI</option>
                </select>
            </div>
          </div>
          </div>
          <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <button type="submit" name="pronadjiId" class="btn btn-plavi btn-block mt-3 pt-3 pb-3"><i class="fas fa-search"></i> PRONAĐI ID KARTICE</button>
          </div>
          </div>
      </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>