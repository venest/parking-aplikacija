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
                  <label for="ime">IME</label>
                  <input type="text" class="form-control" id="ime" placeholder="Ime">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-md-9 col-lg-6">
                  <label for="prezime">PREZIME</label>
                  <input type="text" class="form-control" id="prezime" placeholder="Prezime">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                <label for="inputEmail4">EMAIL</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                <label for="inputPassword4">PASSWORD</label>
                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                  <label for="grad">GRAD</label>
                  <input type="text" class="form-control" id="grad" placeholder="Grad">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-md-9 col-lg-6">
                  <label for="adresa">ADRESA</label>
                  <input type="text" class="form-control" id="adresa" placeholder="Ulica i broj">
               </div>
              </div>
            <div class="row justify-content-center">
              <button type="submit" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">POTVRDI REGISTRACIJU</button>
            </div>
          </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>