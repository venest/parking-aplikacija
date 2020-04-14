<?php
    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
      header("Location: logovanje.php");
      exit();
    }
    $email = $_SESSION["korisnickoIme"];
    $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom");
    $upit = "SELECT idKorisnika FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"]; 
    $upit = "SELECT * FROM kartica WHERE idKorisnika = '$idKorisnika'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    while($red = mysqli_fetch_array($rezultat)) {
        $idKartice = (int) $red["idKartice"];
        $kartica[$idKartice] = $red["automobil"];
    }
?>
<!-- autor: Veljko Nestorovic 0039/2017 -->
<!doctype html>
<html lang="en">
<head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>Parking Aplikacija</title>
</head>
<body>
    <div class="container" style="margin-top: 20px;">
    <?php include("korisnikHeder.php"); ?>
    <form method="POST" action="produzetak.php" autocomplete="off">
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="idKartice">ID KARTICE</label>
              <select class="form-control" name="idKartice" id="idKartice"> <?php
                foreach($kartica as $idKartice=>$tablice) { ?>
                    <option value="<?php print "idKartice"; ?>"> <?php print "$idKartice - $tablice"; ?></option> <?php
                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9 col-lg-6">
            <div class="form-group">
              <label for="datum">DATUM PRODUŽENJA (DATUM DO)</label>
              <input type="text" class="form-control" id="datum" placeholder="dan.mesec.godina">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <button type="submit" name="potvrdiProduzenje" class="btn btn-secondary btn-lg" style="margin-top: 10px; margin-bottom: 20px;">POTVRDI</button>
        </div>
        </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>