<?php

  // autor: Veljko Nestorovic 0039/2017

  session_start();
  if(isset($_SESSION["ulogovan"]))  { 
    switch($_SESSION["tip"]) {
      case "rk": header("Location: korisnik.php"); exit(); break;
      case "o": header("Location: operater.php"); exit(); break;
      case "k": header("Location: kontrolor.php"); exit(); break;
      case "a": header("Location: admin.php"); exit(); break;
    }
  }
  if(isset($_REQUEST["ulogujSe"])) {
    $korisnickoIme = $_REQUEST["korisnickoIme"];
    $lozinka = $_REQUEST["lozinka"];
    $korisnickoImeOk = true;
    $lozinkaOk = true;
    $kredencijaliOk = true;
    if($korisnickoIme == "") $korisnickoImeOk = false; 
    else if($lozinka == "") $lozinkaOk = false; 
    else {
      $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom"); 
      $upit = "SELECT * FROM registrovani WHERE email = '$korisnickoIme'";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      if($red = mysqli_fetch_array($rezultat)) {
        $pravaLozinka = $red["lozinka"];
        if($lozinka == $pravaLozinka) { 
          $_SESSION["tip"] = "rk";
        } else $kredencijaliOk = false;
      } else {
        $upit = "SELECT * FROM zaposleni WHERE korisnickoIme = '$korisnickoIme'";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        if($red = mysqli_fetch_array($rezultat)) {
          $pravaLozinka = $red["lozinka"];
          if($lozinka == $pravaLozinka) { 
            $_SESSION["tip"] = $red["tip"];
          } else $kredencijaliOk = false;
        } else $kredencijaliOk = false;
      }
      mysqli_close($konekcija);
    }
    if($korisnickoImeOk && $lozinkaOk && $kredencijaliOk) {
      $_SESSION["korisnickoIme"] = $korisnickoIme;
      $_SESSION["lozinka"] = $lozinka;
      $_SESSION["ulogovan"] = true;
      switch($_SESSION["tip"]) {
        case "rk": header("Location: korisnik.php"); exit(); break;
        case "o": header("Location: operater.php"); exit(); break;
        case "k": header("Location: kontrolor.php"); exit(); break;
        case "a": header("Location: admin.php"); exit(); break;
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
    <?php include("navIndex.php"); ?>
    <div class="container">
      <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center py-4">
          <h4>Logovanje</h4>
        </div>
        <?php
        if(isset($_REQUEST["ulogujSe"])) {
          if(!$korisnickoImeOk) { ?>            
            <div class="row justify-content-center">
              <div class="alert alert-danger text-center col-xl-6 col-md-9">
                <strong>UNESITE KORISNIČKO IME (EMAIL ADRESU).</strong>
              </div>
            </div>  <?php
          } else if(!$lozinkaOk) { ?>
            <div class="row justify-content-center">
              <div class="alert alert-danger text-center col-xl-6 col-md-9">
                <strong>UNESITE LOZINKU.</strong>
              </div>
            </div> <?php
          } else if(!$kredencijaliOk) { ?>
            <div class="row justify-content-center">
              <div class="alert alert-danger text-center col-xl-6 col-md-9">
                <strong>KORISNIČKO IME I/ILI LOZINKA SU POGREŠNI.</strong><br>
                <strong>MOLIMO VAS POKUŠAJTE PONOVO.</strong>
              </div>
            </div> <?php
          }
        } ?>
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="form-group col-xl-6 col-md-9">
                  <label for="korisnickoIme">KORISNIČKO IME ILI EMAIL ADRESA</label>
                  <input type="text" name="korisnickoIme" class="form-control form-control-lg" id="korisnickoIme" placeholder="unesite korisničko ime ili email" value="<?php if(isset($_REQUEST["ulogujSe"])) print $_REQUEST["korisnickoIme"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-xl-6 col-md-9" id="lozinka">
                  <label for="lozinka">LOZINKA</label>
                  <input type="password" name="lozinka" class="form-control form-control-lg" id="lozinka" placeholder="unesite lozinku">
                </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-xl-6 col-md-9">
              <button type="submit" name="ulogujSe" class="btn btn-plavi btn-block mt-3 py-3">ULOGUJ SE</button>
            </div>
            </div>
        </form>
        <div class="row justify-content-center mt-4">
          <h5> <a href="registracija.php" class="link-registruj-se"> Nemate nalog? Registrujte se. </a> </h5>
        </div>
        </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>