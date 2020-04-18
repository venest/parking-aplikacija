<?php

  // autor: Veljko Nestorovic 0039/2017

  session_start();
  if(isset($_SESSION["ulogovan"]))  { 
    switch($_SESSION["tip"]) {
      case "rk": header("Location: korisnik.php"); exit(); break;
      case "o": header("Location: operater.php"); exit(); break;
      case "k": header("Location: kontrolor.php"); exit(); break;
    }
  }
  if(isset($_REQUEST["ulogujSe"])) {
    $korisnickoIme = $_REQUEST["korisnickoIme"];
    $lozinka = $_REQUEST["lozinka"];
    $svePopunjeno = false;
    $ispravniKredencijali = false;
    if(strcmp($korisnickoIme, "") != 0 && strcmp($lozinka, "") != 0) {
      $svePopunjeno = true;
      $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom"); 
      $upit = "SELECT * FROM registrovani WHERE email = '$korisnickoIme'";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      if($red = mysqli_fetch_array($rezultat)) {
        $pravaLozinka = $red["lozinka"];
        if(strcmp($lozinka, $pravaLozinka) == 0) { 
          $ispravniKredencijali = true;
          $_SESSION["tip"] = "rk";
        }
      } else {
        $upit = "SELECT * FROM zaposleni WHERE korisnickoIme = '$korisnickoIme'";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        if($red = mysqli_fetch_array($rezultat)) {
          $pravaLozinka = $red["lozinka"];
          if(strcmp($lozinka, $pravaLozinka) == 0) { 
            $ispravniKredencijali = true;
            $_SESSION["tip"] = $red["tip"];
          }
        }
      }
      mysqli_close($konekcija);
    }
    if($ispravniKredencijali) {
      $_SESSION["korisnickoIme"] = $korisnickoIme;
      $_SESSION["lozinka"] = $lozinka;
      $_SESSION["ulogovan"] = true;
      switch($_SESSION["tip"]) {
        case "rk": header("Location: korisnik.php"); exit(); break;
        case "o": header("Location: operater.php"); exit(); break;
        case "k": header("Location: kontrolor.php"); exit(); break;
      }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>LOGOVANJE</title>
  </head>
  <body>
    <?php include("nav.php"); ?>
    <div class="container" style="margin-top: 20px;">
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
        <?php
            if(isset($_REQUEST["ulogujSe"])) {
              if(!$svePopunjeno) {
                ?>
                  <div class="row justify-content-center">
                    <div class="alert alert-danger text-center col-lg-6 col-md-9">
                        <strong>SVA POLJA FORME MORAJU BITI POPUNJENA!</strong>
                    </div>
                  </div>
                <?php
              } else if(!$ispravniKredencijali) {
                ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-6 col-md-9">
                    <strong>POGREŠNI KREDENCIJALI (KORISNIČKO IME I/ILI LOZINKA)!</strong>
                  </div>
                </div>
                <?php
              }
            }
            ?>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="emailLogovanje">KORISNIČKO IME ILI EMAIL ADRESA</label>
                  <input type="text" name="korisnickoIme" class="form-control form-control-lg" id="korisnickoImeLogovanje" placeholder="unesite korisničko ime ili email" value="<?php if(isset($_REQUEST["ulogujSe"])) print $_REQUEST["korisnickoIme"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9" id="lozinka">
                  <label for="lozinkaLogovanje">LOZINKA</label>
                  <input type="password" name="lozinka" class="form-control form-control-lg" id="lozinkaLogovanje" placeholder="unesite lozinku">
                </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" name="ulogujSe" class="btn btn-secondary btn-lg" style="margin-top: 10px; margin-bottom: 30px;">ULOGUJ SE</button>
            </div>
        </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>