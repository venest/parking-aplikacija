<?php

    // autor: Veljko Nestorovic 0039/2017
    
    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
      header("Location: logovanje.php");
      exit();
    }
    // date_default_timezone_set('Europe/Belgrade');
    $email = $_SESSION["korisnickoIme"];
    $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom");
    // nadji id korisnika
    $upit = "SELECT idKorisnika FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"]; 
    // proveri da li korisnik uopste ima koju karticu
    $upit = "SELECT * FROM kartica WHERE idKorisnika = $idKorisnika";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $imaKartica = true;
    if(!$red) $imaKartica = false;
    if(isset($_REQUEST["potvrdiTransfer"]) && $imaKartica) {
      $idKarticeSa = (integer) $_REQUEST["idKarticeSa"];
      $idKarticeNa = (integer) $_REQUEST["idKarticeNa"];
      $iznos = $_REQUEST["iznos"];
      $iznosKorektan = false;
      $razliciteKartice = false;
      $imaDovoljno = false;
      if(is_numeric($iznos)) {
        $iznosKorektan = true;
        if($idKarticeSa != $idKarticeNa) {
          $razliciteKartice = true;
          $upit = "SELECT iznos FROM kartica WHERE idKartice = $idKarticeSa";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          $red = mysqli_fetch_array($rezultat);
          $iznosKarticaSa = $red["iznos"];
          $upit = "SELECT iznos FROM kartica WHERE idKartice = $idKarticeNa";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          $red = mysqli_fetch_array($rezultat);
          $iznosKarticaNa = $red["iznos"];
          $iznosIsplate = (double) $iznos;
          if($iznosKarticaSa >= $iznosIsplate) {
            $imaDovoljno = true;
            $iznosKarticaSa -= $iznosIsplate;
            $iznosKarticaNa += $iznosIsplate;
            // azuriranje iznosa na karticama
            $upit = "UPDATE kartica SET iznos = $iznosKarticaSa WHERE idKartice = $idKarticeSa";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $upit = "UPDATE kartica SET iznos = $iznosKarticaNa WHERE idKartice = $idKarticeNa";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            // evidentiranje isplate i racuna za isplatu
            $datumBaza = date("Y-m-d");
            $vremeBaza = date("H:i:s");
            $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza','$vremeBaza',$iznosIsplate,'isplata')";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $red = mysqli_fetch_array($rezultat);
            $idRacunaSa = $red["maxId"];
            $upit = "INSERT INTO isplata (idRacuna, idKartice) VALUES ($idRacunaSa, $idKarticeSa)";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            // evidentiranje uplate i racuna za uplatu
            $datumBaza = date("Y-m-d");
            $vremeBaza = date("H:i:s");
            $upit = "INSERT INTO racun (datum, vreme, iznos, opis) VALUES ('$datumBaza','$vremeBaza',$iznosIsplate,'uplata')";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $upit = "SELECT MAX(idRacuna) AS 'maxId' FROM racun";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $red = mysqli_fetch_array($rezultat);
            $idRacunaNa = $red["maxId"];
            $upit = "INSERT INTO uplata (idRacuna, idKartice) VALUES ($idRacunaNa, $idKarticeNa)";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          }
        }
      }
    }
    $upit = "SELECT * FROM kartica WHERE idKorisnika = $idKorisnika";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    while($red) {
        $idKartice = $red["idKartice"];
        $kartica[$idKartice] = $red["automobil"].", ".$red["iznos"]." RSD";
        $red = mysqli_fetch_array($rezultat);
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
    <div class="container" style="margin-top: 20px;">
    <?php include("korisnikHeder.php"); ?>
    <?php
      if(isset($_REQUEST["potvrdiTransfer"]))  {
        if(!$imaKartica) { ?>
          <div class="row justify-content-center">
          <div class="alert alert-danger text-center col-lg-6 col-md-9">
            <strong>U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS!</strong>
          </div>
        </div> <?php
        } else if(!$iznosKorektan) { ?>
          <div class="row justify-content-center">
            <div class="alert alert-danger text-center col-lg-6 col-md-9">
              <strong>POLJE IZNOS NIJE KOREKTNO POPUNJENO!</strong>
            </div>
          </div> <?php
        } else if(!$razliciteKartice) { ?>
          <div class="row justify-content-center">
            <div class="alert alert-danger text-center col-lg-6 col-md-9">
              <strong>ID KARTCE SA I ID KARTICE NA MORAJU BITI RAZLIČITI!</strong>
            </div>
          </div> <?php
        } else if(!$imaDovoljno) { ?>
          <div class="row justify-content-center">
            <div class="alert alert-danger text-center col-lg-6 col-md-9">
              <strong>NA KARTICI SA KOJE SE OBAVLJA TRANSFER NEMA DOVOLJNO SREDSTAVA!</strong>
            </div>
          </div> <?php
        } else { ?>
          <div class="row justify-content-center">
            <div class="alert alert-success text-center col-lg-6 col-md-9">
              <strong>USPEŠNO OBAVLJEN TRANSFER!</strong>
            </div>
          </div> <?php
        }
      }
    ?>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="idKarticeSa">KARTICA SA</label>
              <select class="form-control form-control-lg" name="idKarticeSa" id="idKarticeSa"> <?php
                foreach($kartica as $idKartice=>$opis) { ?>
                    <option value="<?php print "$idKartice"; ?>"> <?php print $opis; ?> </option> <?php
                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="idKarticeNa">KARTICE NA</label>
              <select class="form-control form-control-lg" name="idKarticeNa" id="idKarticeNa"> <?php
                foreach($kartica as $idKartice=>$opis) { ?>
                    <option value="<?php print "$idKartice"; ?>"> <?php print $opis; ?></option> <?php
                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="iznos">IZNOS</label>
              <div class="input-group">
                  <input type="text" class="form-control form-control-lg" name="iznos" id="iznos" placeholder="unesite iznos" value="<?php if(isset($_REQUEST["potvrdiTransfer"])) print $_REQUEST["iznos"]; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">RSD</span>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" name="potvrdiTransfer" class="btn btn-secondary btn-lg" style="margin-top: 10px; margin-bottom: 20px;">POTVRDI</button>
        </div>
    </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.13/dist/js/bootstrap-select.min.js"></script>
</body>
</html>