<?php

    // autor: Veljko Nestorovic 0039/2017

    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
      header("Location: logovanje.php");
      exit();
    }
    if(isset($_REQUEST["izlogujSe"])) {
        unset($_SESSION["korisnickoIme"]);
        unset($_SESSION["lozinka"]);
        unset($_SESSION["ulogovan"]);
        unset($_SESSION["tip"]);
        session_destroy();
        header("Location: logovanje.php");
        exit(); 
      }
    $email = $_SESSION["korisnickoIme"];
    $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom"); 
    $upit = "SELECT * FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"];
    $ime = $red["ime"];
    $prezime = $red["prezime"];
    $grad = $red["grad"];
    $adresa = $red["adresa"];
    $telefon = $red["telefon"];
    if(isset($_REQUEST["sacuvajIzmene"])) {
        $novoIme = $_REQUEST["ime"];
        $novoPrezime = $_REQUEST["prezime"];
        $noviGrad = $_REQUEST["grad"];
        $novaAdresa = $_REQUEST["adresa"];
        $noviTelefon = $_REQUEST["telefon"];
        $noviEmail = $_REQUEST["email"];
        $svePopunjeno = false;
        $emailOk = false;
        if(strcmp($noviEmail, "") != 0 && strcmp($novoIme, "") != 0 && strcmp($novoPrezime, "") != 0 && strcmp($noviGrad, "") != 0 && strcmp($novaAdresa, "") != 0 && strcmp($noviTelefon, "") != 0) {
            $svePopunjeno = true;
            if(strcmp($email, $noviEmail) != 0) {
              $upit = "SELECT * FROM registrovani WHERE email = '$noviEmail'";
              $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
              $red = mysqli_fetch_array($rezultat); 
              if(!$red) $emailOk = true;
            } else $emailOk = true;
            if($emailOk) {
              $upit = "UPDATE registrovani SET email = '$noviEmail', ime = '$novoIme', prezime = '$novoPrezime', grad = '$noviGrad', adresa = '$novaAdresa', telefon = '$noviTelefon' WHERE idKorisnika = '$idKorisnika'";
              $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
              $_SESSION["korisnickoIme"] = $noviEmail;
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>KORISNIK</title>
</head>
<body>
    <?php include("navKorisnik.php"); ?>
    <div class="container-fluid">
    <?php include("kontrolnaTablaDugme.php"); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
          <div class="collapse text-center d-md-block" id="side-nav">
            <h5 class="my-4">KONTROLNA TABLA</h5>
            <div class="list-group text-center mb-2">
              <a href="profil.php" class="list-group-item list-group-item-action py-4 active">PROFIL</a>
              <a href="promenaLozinke.php" class="list-group-item list-group-item-action py-4">PROMENA LOZINKE</a>
              <a href="kartice.php" class="list-group-item list-group-item-action py-4">KARTICE</a>
              <a href="obnovaKartice.php" class="list-group-item list-group-item-action py-4">OBNOVA KARTICE</a>
              <a href="transfer.php" class="list-group-item list-group-item-action py-4">TRANSFER</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                  <div class="col">
                    <h4>Profil</h4>
                  </div>
                </div>
            <?php
            if(isset($_REQUEST["sacuvajIzmene"])) {
              if(!$svePopunjeno) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>SVA POLJA FORME MORAJU BITI POPUNJENA.</strong>
                  </div>
                </div> <?php
              } else if(!$emailOk) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>UNETI EMAIL VEĆ POSTOJI U SISTEMU.</strong>
                  </div>
                </div> <?php
              } else { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-success text-center col-lg-9">
                    <strong>IZMENE SU SAČUVANE.</strong>
                  </div>
                </div> <?php
              }
            }
            ?>
            <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="ime">EMAIL ADRESA</label>
                        <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="unesite email" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $email; else print $noviEmail; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="telefon">TELEFON</label>
                        <input type="text" name="telefon" class="form-control form-control-lg" id="telefon" placeholder="unesite telefon" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $telefon; else print $noviTelefon; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="ime">IME</label>
                        <input type="text" name="ime" class="form-control form-control-lg" id="ime" placeholder="unesite ime" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $ime; else print $novoIme; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="prezime">PREZIME</label>
                        <input type="text" name="prezime" class="form-control form-control-lg" id="prezime" placeholder="unesite prezime" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $prezime; else print $novoPrezime; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-6">
                        <label for="grad">GRAD</label>
                        <input type="text" name="grad" class="form-control form-control-lg" id="grad" placeholder="unesite grad" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $grad; else print $noviGrad; ?>">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="adresa">ADRESA</label>
                        <input type="text" name="adresa" class="form-control form-control-lg" id="adresa" placeholder="unesite ulicu i broj" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $adresa; else print $novaAdresa; ?>">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <button type="submit" name="sacuvajIzmene" class="btn btn-plavi btn-block mt-3 py-3">SAČUVAJ IZMENE</button>
                    </div>               
                </div>
            </form>
            </div>
        </div>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>