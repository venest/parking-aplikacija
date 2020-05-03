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
          $upit = "SELECT stanje FROM kartica WHERE idKartice = $idKarticeSa";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          $red = mysqli_fetch_array($rezultat);
          $stanjeKarticaSa = $red["stanje"];
          $upit = "SELECT stanje FROM kartica WHERE idKartice = $idKarticeNa";
          $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
          $red = mysqli_fetch_array($rezultat);
          $stanjeKarticaNa = $red["stanje"];
          $iznosIsplate = (double) $iznos;
          if($stanjeKarticaSa >= $iznosIsplate) {
            $imaDovoljno = true;
            $stanjeKarticaSa -= $iznosIsplate;
            $stanjeKarticaNa += $iznosIsplate;
            // azuriranje iznosa na karticama
            $upit = "UPDATE kartica SET stanje = $stanjeKarticaSa WHERE idKartice = $idKarticeSa";
            $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
            $upit = "UPDATE kartica SET stanje = $stanjeKarticaNa WHERE idKartice = $idKarticeNa";
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
        $kartica[$idKartice] = $red["automobil"].", ".$red["stanje"]." RSD";
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
        <a href="obnovaKartice.php" class="list-group-item list-group-item-action py-4">OBNOVA KARTICE</a>
        <a href="transfer.php" class="list-group-item list-group-item-action py-4 active">TRANSFER</a>
    </div>
</div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Transfer</h4>
                </div>
            <?php
            if(isset($_REQUEST["potvrdiTransfer"]))  {
              if(!$imaKartica) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong>
                  </div>
                </div> <?php
              } else if(!$iznosKorektan) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>POLJE IZNOS NIJE KOREKTNO POPUNJENO.</strong>
                  </div>
                </div> <?php
              } else if(!$razliciteKartice) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>ID KARTCE SA I ID KARTICE NA MORAJU BITI RAZLIČITI.</strong>
                  </div>
                </div> <?php
              } else if(!$imaDovoljno) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-9">
                    <strong>NA KARTICI SA KOJE SE OBAVLJA TRANSFER NEMA DOVOLJNO SREDSTAVA.</strong>
                  </div>
                </div> <?php
              } else { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-success text-center col-lg-9">
                    <strong>USPEŠNO OBAVLJEN TRANSFER.</strong>
                  </div>
                </div> <?php
              }
            } ?>
            <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
              <div class="row justify-content-center">
                <div class="col-lg-9">
                  <div class="form-group">
                    <label for="idKarticeSa">KARTICA SA</label>
                    <select class="form-control form-control-lg" name="idKarticeSa" id="idKarticeSa"> <?php
                      foreach($kartica as $idKartice=>$opis) { ?>
                        <option value="<?php print "$idKartice"; ?>" class="py-4"> <?php print $opis; ?> </option> <?php
                      } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-lg-9">
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
                <div class="col-lg-9">
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
                <div class="col-lg-9">
                  <button type="submit" name="potvrdiTransfer" class="btn btn-plavi btn-block mt-3 px-5 py-3">POTVRDI</button>
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