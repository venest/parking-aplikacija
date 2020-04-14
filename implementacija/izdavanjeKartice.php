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
              <div class="form-group col-lg-6 col-md-9">
                <label for="inputEmail4">EMAIL</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
              </div>
          </div>
          <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="tablice">AUTOMOBIL</label>
                <input type="text" class="form-control" id="tablice" placeholder="Tablice">
              </div>
          </div>
          <div class="row justify-content-center">
            <div class="form-group col-lg-6 col-md-9">
              <label for="datumDo">DATUM VAŽENJA (DATUM DO)</label>
              <input type="text" class="form-control" id="datumDo" placeholder="dan.mesec.godina">
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