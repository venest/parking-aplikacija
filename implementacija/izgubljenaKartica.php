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
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>Operater</title>
  </head>
  <body>
    <div class="container" style="margin-top: 20px;">
      <?php include("operaterHeder.php"); ?>
      <form>
        <div class="row justify-content-center">
          <div class="form-group col-lg-6 col-md-9" id="lozinka">
            <label for="idKartice">ID KARTICE</label>
            <input type="text" class="form-control" id="idKartice" placeholder="ID">
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="cekboks1">
            <label class="form-check-label" for="cekboks1">
              IZDAVANJE DUPLIKATA
            </label>
          </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">EVIDENTIRAJ GUBITAK</button>
          </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>