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
          <div class="form-group col-md-9 col-lg-6">
            <label for="brojTablica">BROJ REGISTARSKIH TABLICA</label>
            <input type="text" class="form-control" id="brojTablica" placeholder="Tablice">
          </div>
        </div>
      <div class="row justify-content-center">
        <button type="submit" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">IZDAVANJE KARTICE</button>
      </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>