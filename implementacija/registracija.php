<?php

  // autor: Veljko Nestorovic 0039/2017

  if(isset($_REQUEST["registrujSe"])) {
    $ime = $_REQUEST["ime"];
    $prezime = $_REQUEST["prezime"];
    $email = $_REQUEST["email"];
    $lozinka = $_REQUEST["lozinka"];
    $ponovljenaLozinka = $_REQUEST["ponovljenaLozinka"];
    $grad = $_REQUEST["grad"];
    $adresa = $_REQUEST["adresa"];
    $telefon = $_REQUEST["telefon"];
    $svePopunjeno = false;
    $ispravanEmail = false;
    $lozinkaOk = false;
    if(strcmp($ime, "") != 0 && strcmp($prezime, "") != 0 && strcmp($email, "") != 0 && strcmp($lozinka, "") != 0 && strcmp($ponovljenaLozinka, "") != 0 && strcmp($grad, "") != 0 && strcmp($adresa, "") != 0 && strcmp($telefon, "") != 0) {
      $svePopunjeno = true;
      $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom");
      $upit = "SELECT * FROM registrovani WHERE email = '$email'";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      $red = mysqli_fetch_array($rezultat);
      if(!$red) { 
        $ispravanEmail = true;
        if(strcmp($lozinka, $ponovljenaLozinka) == 0) {
          $lozinkaOk = true;
          $upit = "INSERT INTO registrovani (ime, prezime, email, lozinka, grad, adresa, telefon) values ('$ime', '$prezime', '$email', '$lozinka', '$grad', '$adresa', '$telefon')";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        }
      }
      mysqli_close($konekcija);
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>REGISTRACIJA</title>
  </head>
  <body>
    <?php include("navIndex.php"); ?>
    <div class="container">
      <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center pt-4 pb-4">
          <h4>Registracija</h4>
        </div>
      <?php
            if(isset($_REQUEST["registrujSe"])) {
              if(!$svePopunjeno) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-6 col-md-9">
                    <strong>SVA POLJA FORME MORAJU BITI POPUNJENA!</strong>
                  </div>
                </div> <?php
              } else if(!$ispravanEmail) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-6 col-md-9">
                    <strong>UNETI EMAIL VEĆ POSTOJI U SISTEMU!</strong>
                  </div>
                </div> <?php
              } else if(!$lozinkaOk) { ?>
                  <div class="row justify-content-center">
                    <div class="alert alert-danger text-center col-lg-6 col-md-9">
                      <strong>POTVRDA LOZINKE NIJE USPELA!</strong>
                    </div>
                  </div> <?php                 
                }
                else { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-success text-center col-lg-6 col-md-9">
                    <strong>USPEŠNO STE SE REGISTROVALI!</strong>
                  </div>
                </div> <?php
              }
            }
            ?>
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="ime">IME</label>
                  <input type="text" name="ime" class="form-control form-control-lg" id="ime" placeholder="unesite ime" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["ime"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="prezime">PREZIME</label>
                  <input type="text" name="prezime" class="form-control form-control-lg" id="prezime" placeholder="unesite prezime" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["prezime"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="email">EMAIL ADRESA</label>
                <input type="email" name="email" class="form-control form-control-lg" id="emailRegistracija" placeholder="unesite email" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["email"];?>">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="password">LOZINKA</label>
                <input type="password" name="lozinka" class="form-control form-control-lg" id="lozinkaRegistracija" placeholder="unesite lozinku">
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="form-group col-lg-6 col-md-9">
                <label for="ponovljenPassword">PONOVITE LOZINKU</label>
                <input type="password" name="ponovljenaLozinka" class="form-control form-control-lg" id="ponovljenaLozinkaRegistracija" placeholder="unesite lozinku">
              </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="grad">GRAD</label>
                  <input type="text" name="grad" class="form-control form-control-lg" id="grad" placeholder="unesite grad" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["grad"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="adresa">ADRESA</label>
                  <input type="text" name="adresa" class="form-control form-control-lg" id="adresa" placeholder="unesite ulicu i broj" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["adresa"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="telefon">TELEFON</label>
                  <input type="text" name="telefon" class="form-control form-control-lg" id="telefon" placeholder="unesite telefon" value="<?php if(isset($_REQUEST["registrujSe"])) print $_REQUEST["telefon"];?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-6 col-md-9">
              <button type="submit" name="registrujSe" class="btn btn-plavi btn-block mt-3 pt-3 pb-3">REGISTRUJ SE</button>
            </div>
            </div>
          </form>
          </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>