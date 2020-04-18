<?php

    // autor: Veljko Nestorovic 0039/2017

    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
        header("Location: logovanje.php");
        exit;
    }
    if(isset($_REQUEST["izlogujSe"])) {
        unset($_SESSION["ulogovan"]);
        unset($_SESSION["korisnickoIme"]);
        unset($_SESSION["lozinka"]);
        unset($_SESSION["tip"]);
        session_destroy();
        header("Location: logovanje.php");
        exit;
    }
    $email = $_SESSION["korisnickoIme"];
    $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom");
    $upit = "SELECT idKorisnika FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"]; 
    $upit = "SELECT * FROM kartica WHERE idKorisnika = '$idKorisnika'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
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
    <?php include("korisnikHeder.php"); include("korisnikSadrzaj.php"); 
    if(!$red) { ?>
        <div class="alert alert-warning text-center">
            <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
        </div>
    <?php 
    } else { ?>
    <table class="table table-bordered text-center" style="background-color: #e3f2fd;">
        <tr>
            <td>ID KARTICE</td>
            <td>AUTOMOBIL</td>
            <td>DATUM DO</td>
            <td>IZNOS</td>
        </tr>
    <?php
        do {
            $idKartice = $red["idKartice"];
            $automobil = $red["automobil"];
            $datumDo = $red["datumVazenja"];
            $niz = explode("-", $datumDo);
            $dan = $niz[2];
            $mesec = $niz[1];
            $godina = $niz[0];
            $iznos = $red["iznos"]; ?>
            <tr>
            <td><?php print "$idKartice"; ?></td>
            <td><?php print "$automobil"; ?></td>
            <td><?php print "$dan."."$mesec."."$godina."; ?></td>
            <td><?php print "$iznos"; ?></td>
            </tr>
    <?php
        } while ($red = mysqli_fetch_array($rezultat));
    } mysqli_close($konekcija); ?>
    </table>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <div class="row justify-content-center">
            <button type="submit" name="izlogujSe" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">IZLOGUJ SE</button>
        </div>
    </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>