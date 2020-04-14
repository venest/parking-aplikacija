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
          <div class="col col-md-9 col-lg-6">
            <div class="form-group">
                <label for="idKartice">ID KARTICE</label>
                <input type="text" class="form-control" id="idKartice" placeholder="ID">
            </div>
              </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="iznos">IZNOS UPLATE</label>
                <div class="input-group">
                <input type="text" class="form-control" id="iznos" placeholder="Iznos">
                <div class="input-group-append">
                  <span class="input-group-text">RSD</span>
                </div>
                </div>
            </div>
              </div>
          </div>
          <div class="row justify-content-center">
            <button type="submit" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">EVIDENTIRAJ UPLATU</button>
          </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>