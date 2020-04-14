<?php
  session_start();
  $korisnickoIme = $_SESSION["korisnickoIme"];
  if(!isset($_SESSION["ulogovan"])) { 
    header("Location: logovanje.php");
    exit();
  } 
?>
<!-- autor: Veljko Nestorovic 0039/2017 -->
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>Operater</title>
  </head>
  <body>
    <div class="container" style="margin-top: 20px;">
      <?php include("operaterHeder.php"); ?>
        <form>
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="tablice">TABLICE</label>
                <input type="text" class="form-control" id="tablice" placeholder="Tablice">
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="radioStavka11" value="gost" name="radioGrupa">
              <label class="form-check-label" for="radioStavka11">GOST</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" id="radioStavka12" value="registrovani" name="radioGrupa">
              <label class="form-check-label" for="radioStavka12">REGISTROVANI</label>
            </div>
          </div>
          </div>
          <div class="row justify-content-center">
            <button type="submit" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;"><i class="fas fa-search"></i> PRONAĐI ID KARTICE</button>
          </div>
        </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>