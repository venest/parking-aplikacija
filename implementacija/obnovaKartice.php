<?php

    // autor: Veljko Nestorovic 0039/2017

    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
      header("Location: logovanje.php");
      exit();
    }
    // cene
    define('CENA_DAN', 200);
    define('CENA_SEDMICA', 800);
    define('CENA_MESEC', 2000);
    date_default_timezone_set('Europe/Belgrade');
    $email = $_SESSION["korisnickoIme"];
    $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom");
    // nadji id
    $upit = "SELECT idKorisnika FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"]; 
    // provera da li ima uopste neku karticu
    $upit = "SELECT * FROM kartica WHERE idKorisnika = $idKorisnika";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $imaKartica = true;
    if(!$red) $imaKartica = false;
    $korektanUnos = true;
    $imaDovoljno = false;
    $obnova = "";
    if(isset($_REQUEST["potvrdiObnovu"]) && $imaKartica) {
      
      if($_REQUEST["period"] == "dan") $obnova = "d";
      else if($_REQUEST["period"] == "sedmica") $obnova = "s";
      else if($_REQUEST["period"] == "mesec") $obnova = "m";

      $idKartice = (integer) $_REQUEST["idKartice"];
      $upit = "SELECT * FROM kartica WHERE idKartice = $idKartice";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      $red = mysqli_fetch_array($rezultat);
      // datum vazenja
      $datumVazenja = explode("-", $red["vaziDo"]);
      $stanjeNaKartici = $red["stanje"];
      $danVazenje = (integer) $datumVazenja[2];
      $mesecVazenje = (integer) $datumVazenja[1];
      $godinaVazenje = (integer) $datumVazenja[0];
      $datumVazenjaUnix = mktime(0, 0, 0, $mesecVazenje, $danVazenje, $godinaVazenje);
      // tekuci datum
      $tekucidatum = explode("-", date('Y-m-d'));
      $danTekuci = (integer) $tekucidatum[2];
      $mesecTekuci = (integer) $tekucidatum[1];
      $godinaTekuca = (integer) $tekucidatum[0];
      $tekuciDatumUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
      if($datumVazenjaUnix > $tekuciDatumUnix) {
        $dan = $danVazenje;
        $mesec = $mesecVazenje;
        $godina = $godinaVazenje;
        $datum = $datumVazenjaUnix;
      } else  {
        $dan = $danTekuci;
        $mesec = $mesecTekuci;
        $godina = $godinaTekuca;
        $datum = $tekuciDatumUnix;
      }
      switch($obnova) {
        case "d": $sekunde = 24 * 60 * 60; $iznosRacuna = CENA_DAN; break;
        case "s": $sekunde = 7 * 24 * 60 * 60; $iznosRacuna = CENA_SEDMICA; break;
        case "m":
          $sekunde = 0;
          $iznosRacuna = CENA_MESEC;
          if($mesec == 12) $godina++;
          $mesec = ($mesec + 1) % 12;
        break;
      }
      $datum += $sekunde;
      $imaDovoljno = false;
      if($stanjeNaKartici >= $iznosRacuna) {
        $imaDovoljno = true;
        // azuriramo stanje na kartici
        $stanjeNaKartici -= $iznosRacuna;
        $upit = "UPDATE kartica SET stanje = $stanjeNaKartici WHERE idKartice = $idKartice";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // azuriramo datum vazenja kartice
        $datumBaza = date('Y-m-d', $datum);
        $upit = "UPDATE kartica SET vaziDo = '$datumBaza' WHERE idKartice = $idKartice";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // insert-ujemo u tabelu racun
        $datumBaza = date('Y-m-d');
        $vremeBaza = date('H:i:s');
        $opisRacuna = "obnova ".$obnova;
        $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza', '$vremeBaza', $iznosRacuna, '$opisRacuna')";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // insert-ujemo u tabelu obnova
        $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        $red = mysqli_fetch_array($rezultat);
        $idRacuna = $red["maxId"];
        $upit = "INSERT INTO obnova (idKartice, idRacuna) VALUES ($idKartice, $idRacuna)";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      }
    } 
    $upit = "SELECT * FROM kartica WHERE idKorisnika = $idKorisnika";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    while($red = mysqli_fetch_array($rezultat)) {
        $idKartice = $red["idKartice"];
        $datumVazenja = explode("-", $red["vaziDo"]);
        $dan = (integer) $datumVazenja[2];
        $mesec = (integer) $datumVazenja[1];
        $godina = (integer) $datumVazenja[0];
        $kartica[$idKartice] = $red["automobil"].", ".$red["stanje"]." RSD, ".$dan.".".$mesec.".".$godina;
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
        <a href="profil.php" class="list-group-item list-group-item-action py-4">PROFIL</a>
        <a href="promenaLozinke.php" class="list-group-item list-group-item-action py-4">PROMENA LOZINKE</a>
        <a href="kartice.php" class="list-group-item list-group-item-action py-4">KARTICE</a>
        <a href="obnovaKartice.php" class="list-group-item list-group-item-action py-4 active">OBNOVA KARTICE</a>
        <a href="transfer.php" class="list-group-item list-group-item-action py-4">TRANSFER</a>
    </div>
</div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Obnova kartice</h4>
                </div>
            <?php
            if(isset($_REQUEST["potvrdiObnovu"])) {
              if(!$imaKartica) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS!</strong>
                  </div>
                </div> <?php
              } else if(!$korektanUnos) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>POLJE BROJ DANA (DATUM) NIJE KOREKTNO POPUNJENO!</strong>
                  </div>
                </div>  <?php
              } else if(!$imaDovoljno) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>NEMATE DOVOLJNO SREDSTAVA NA IZABRANOJ KARTICI!</strong>
                  </div>
                </div> <?php
              } else { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-success text-center col-lg-9">
                    <strong>USPEŠNO STE PRODUŽILI PERIOD VAŽENJA VAŠE KARTICE!</strong>
                  </div>
                </div> <?php
              }
            }
            ?>
            <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
              <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="idKartice">KARTICA</label>
                  <select class="form-control form-control-lg" name="idKartice"> <?php
                    foreach($kartica as $idKartice=>$opis) { ?>
                      <option value="<?php print $idKartice; ?>"> <?php print $opis; ?> </option> <?php
                    } ?>
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="period">PERIOD</label>
                  <select class="form-control form-control-lg" name="period">
                    <option value="dan">DAN, 200 RSD</option>
                    <option value="sedmica">SEDMICA, 800 RSD</option>
                    <option value="mesec">MESEC, 2000 RSD</option>
                  </select>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-lg-9">
                  <button type="submit" name="potvrdiObnovu" class="btn btn-plavi btn-block mt-3 py-3">POTVRDI</button>
                </div>
              </div>
            </form>
            </div>
        </div>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>
</html>