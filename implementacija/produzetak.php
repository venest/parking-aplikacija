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
    $produzenje = "";
    if((isset($_REQUEST["produzenjeDan"]) || isset($_REQUEST["produzenjeSedmica"]) || isset($_REQUEST["produzenjeMesec"])) && $imaKartica) {
      
      if(isset($_REQUEST["produzenjeDan"])) $produzenje = "d";
      else if(isset($_REQUEST["produzenjeSedmica"])) $produzenje = "s";
      else if(isset($_REQUEST["produzenjeMesec"])) $produzenje = "m";

      $idKartice = (integer) $_REQUEST["idKartice"];
      $upit = "SELECT * FROM kartica WHERE idKartice = $idKartice";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      $red = mysqli_fetch_array($rezultat);
      $datumVazenja = explode("-", $red["datumVazenja"]);
      $stanjeNaKartici = $red["iznos"];
      $dan = (integer) $datumVazenja[2];
      $mesec = (integer) $datumVazenja[1];
      $godina = (integer) $datumVazenja[0];
      switch($produzenje) {
        case "d": $sekundeProduzenje = 24 * 60 * 60; $iznosRacuna = CENA_DAN; break;
        case "s": $sekundeProduzenje = 7 * 24 * 60 * 60; $iznosRacuna = CENA_SEDMICA; break;
        case "m":
          $sekundeProduzenje = 0;
          $iznosRacuna = CENA_MESEC;
          if($mesec == 12) $godina++;
          $mesec = ($mesec + 1) % 12;
        break;
      }
      $datumVazenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina) + $sekundeProduzenje;
      $imaDovoljno = false;
      if($stanjeNaKartici >= $iznosRacuna) {
        $imaDovoljno = true;
        // azuriramo stanje na kartici
        $stanjeNaKartici -= $iznosRacuna;
        $upit = "UPDATE kartica SET iznos = $stanjeNaKartici WHERE idKartice = $idKartice";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // azuriramo datum vazenja kartice
        $datumBaza = date('Y-m-d', $datumVazenjeUnix);
        $upit = "UPDATE kartica SET datumVazenja = '$datumBaza' WHERE idKartice = $idKartice";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // insert-ujemo u tabelu racun
        $datumBaza = date('Y-m-d');
        $vremeBaza = date('H:i:s');
        $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza', '$vremeBaza', $iznosRacuna, 'produzenje')";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        // insert-ujemo u tabelu produzenje
        $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        $red = mysqli_fetch_array($rezultat);
        $idRacuna = $red["maxId"];
        $datumBaza = date('Y-m-d', $datumVazenjeUnix);
        $upit = "INSERT INTO produzenje (idKartice, datumProduzetka, idRacuna) VALUES ($idKartice, '$datumBaza', $idRacuna)";
        $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      }
    } 
    else if(isset($_REQUEST["produzenjeProizvoljno"])  && $imaKartica) {
      $idKartice = (integer) $_REQUEST["idKartice"];
      $upit = "SELECT * FROM kartica WHERE idKartice = $idKartice";
      $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
      $red = mysqli_fetch_array($rezultat);
      $datumVazenja = explode("-", $red["datumVazenja"]);
      $stanjeNaKartici = $red["iznos"];
      $dan = (integer) $datumVazenja[2];
      $mesec = (integer) $datumVazenja[1];
      $godina = (integer) $datumVazenja[0];
      $datumVazenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina);
      $datum = explode(".", $_REQUEST["datum"]);
      $korektanUnos = false;
      $imaDovoljno = false;
      if(count($datum) == 4 && is_numeric($datum[0]) && is_numeric($datum[1]) && is_numeric($datum[2])) {
        $dan = (integer) $datum[0];
        $mesec = (integer) $datum[1];
        $godina = (integer) $datum[2];
        $datumProduzenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina);
        if(checkdate($mesec, $dan, $godina) && $datumProduzenjeUnix > $datumVazenjeUnix) {
          $korektanUnos = true;
          $brojDana = (integer) (($datumProduzenjeUnix - $datumVazenjeUnix) / (24 * 60 * 60));
          $iznosRacuna = $brojDana * CENA_DAN;
          if($stanjeNaKartici >= $iznosRacuna) {
            $imaDovoljno = true;
            $datumVazenjeUnix = $datumProduzenjeUnix;
            // azuriramo stanje na kartici
            $stanjeNaKartici -= $iznosRacuna;
            $upit = "UPDATE kartica SET iznos = $stanjeNaKartici WHERE idKartice = $idKartice";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            // azuriramo datum vazenja kartice
            $datumBaza = date('Y-m-d', $datumVazenjeUnix);
            $upit = "UPDATE kartica SET datumVazenja = '$datumBaza' WHERE idKartice = $idKartice";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            // insert-ujemo u tabelu racun
            $datumBaza = date('Y-m-d');
            $vremeBaza = date('H:i:s');
            $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza', '$vremeBaza', $iznosRacuna, 'produzenje')";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            // insert-ujemo u tabelu produzenje
            $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $red = mysqli_fetch_array($rezultat);
            $idRacuna = $red["maxId"];
            $datumBaza = date('Y-m-d', $datumVazenjeUnix);
            $upit = "INSERT INTO produzenje (idKartice, datumProduzetka, idRacuna) VALUES ($idKartice, '$datumBaza', $idRacuna)";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          }
        }
      } else if(count($datum) == 1 && is_numeric($_REQUEST["datum"])) {
        $brojDana = (integer) $_REQUEST["datum"];
        $korektanUnos = true;
        $datumVazenjeUnix += $brojDana * 24 * 60 * 60;
        $iznosRacuna = $brojDana * CENA_DAN;
        if($stanjeNaKartici >= $iznosRacuna) {
          $imaDovoljno = true;
          // azuriramo stanje na kartici
          $stanjeNaKartici -= $iznosRacuna;
          $upit = "UPDATE kartica SET iznos = $stanjeNaKartici WHERE idKartice = $idKartice";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          // azuriramo datum vazenja kartice
          $datumBaza = date('Y-m-d', $datumVazenjeUnix);
          $upit = "UPDATE kartica SET datumVazenja = '$datumBaza' WHERE idKartice = $idKartice";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          // insert-ujemo u tabelu racun
          $datumBaza = date('Y-m-d');
          $vremeBaza = date('H:i:s');
          $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza', '$vremeBaza', $iznosRacuna, 'produzenje')";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          // insert-ujemo u tabelu produzenje
          $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          $red = mysqli_fetch_array($rezultat);
          $idRacuna = $red["maxId"];
          $datumBaza = date('Y-m-d', $datumVazenjeUnix);
          $upit = "INSERT INTO produzenje (idKartice, datumProduzetka, idRacuna) VALUES ($idKartice, '$datumBaza', $idRacuna)";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
        }
      }
    }
    $upit = "SELECT * FROM kartica WHERE idKorisnika = $idKorisnika";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    while($red = mysqli_fetch_array($rezultat)) {
        $idKartice = $red["idKartice"];
        $datumVazenja = explode("-", $red["datumVazenja"]);
        $dan = (integer) $datumVazenja[2];
        $mesec = (integer) $datumVazenja[1];
        $godina = (integer) $datumVazenja[0];
        $kartica[$idKartice] = $red["automobil"].", ".$red["iznos"]." RSD, ".$dan.".".$mesec.".".$godina;
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
    <div class="container">
    <div class="jumbotron pt-0 mb-1">
        <div class="row justify-content-center pt-4 pb-4">
          <h4>Produžetak važenja kartice</h4>
        </div>
        <?php
    if(isset($_REQUEST["produzenjeDan"]) || isset($_REQUEST["produzenjeSedmica"]) || isset($_REQUEST["produzenjeMesec"]) || isset($_REQUEST["produzenjeProizvoljno"])) {
      if(!$imaKartica) { ?>
        <div class="row justify-content-center">
          <div class="alert alert-danger text-center col-lg-6 col-md-9">
            <strong>U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS!</strong>
          </div>
        </div> <?php
      } else if(!$korektanUnos) { ?>
        <div class="row justify-content-center">
          <div class="alert alert-danger text-center col-lg-6 col-md-9">
            <strong>POLJE BROJ DANA (DATUM) NIJE KOREKTNO POPUNJENO!</strong>
          </div>
        </div>  <?php
      } else if(!$imaDovoljno) { ?>
        <div class="row justify-content-center">
          <div class="alert alert-danger text-center col-lg-6 col-md-9">
            <strong>NEMATE DOVOLJNO SREDSTAVA NA IZABRANOJ KARTICI!</strong>
          </div>
        </div> <?php
      } else { ?>
        <div class="row justify-content-center">
        <div class="alert alert-success text-center col-lg-6 col-md-9">
          <strong>USPEŠNO STE PRODUŽILI PERIOD VAŽENJA VAŠE KARTICE!</strong>
        </div>
      </div> <?php
      }
    }
    ?>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
              <div class="form-group">
                <label for="idKartice">KARTICA</label>
                <select class="form-control form-control-lg" name="idKartice"> <?php
                  foreach($kartica as $idKartice=>$opis) { ?>
                      <option value="<?php print $idKartice; ?>"> <?php print $opis; ?> </option> <?php
                  } ?>
                </select>
              </div>
          </div>
        </div>
          <div class="row justify-content-center">
            <div class="alert alert-beli text-center col-lg-6 col-md-9">
              <h5>DAN</h5>
              <h2><strong>200 RSD</strong></h2>
              <button type="submit" name="produzenjeDan" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">POTVRDI</button>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="alert alert-beli text-center col-lg-6 col-md-9">
              <h5>SEDAM DANA</h5>
              <h2><strong>800 RSD</strong></h2>
                <button type="submit" name="produzenjeSedmica" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">POTVRDI</button>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="alert alert-beli text-center col-lg-6 col-md-9">
              <h5>MESEC DANA</h5>
              <h2><strong>2000 RSD</strong></h2>
                <button type="submit" name="produzenjeMesec" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">POTVRDI</button>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="alert alert-beli text-center col-lg-6 col-md-9">
              <h5>PROIZVOLJNO</h5>
              <h2><strong>200 RSD/DAN</strong></h2>
                <div class="form-group">
                  <label for="datum">BROJ DANA ILI DATUM</label>
                  <input type="text" name="datum" class="form-control form-control-lg" id="datum" placeholder="unesite broj dana ili datum (dan.mesec.godina.)" style="text-align: center" value="<?php if(isset($_REQUEST["produzenjeDan"]) || isset($_REQUEST["produzenjeSedmica"]) || isset($_REQUEST["produzenjeMesec"]) || isset($_REQUEST["produzenjeProizvoljno"])) print $_REQUEST["datum"]; ?>">
                </div>
                <button type="submit" name="produzenjeProizvoljno" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">POTVRDI</button>
            </div>
        </div>
      </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>
</html>