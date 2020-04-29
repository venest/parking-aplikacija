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
    $upit = "SELECT * FROM registrovani WHERE email = '$email'";
    $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
    $red = mysqli_fetch_array($rezultat);
    $idKorisnika = $red["idKorisnika"];
    $ime = $red["ime"];
    $prezime = $red["prezime"];
    $grad = $red["grad"];
    $adresa = $red["adresa"];
    $telefon = $red["telefon"];
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
    <div class="container text-center mt-3">
    <table class="table table-hover">
    <tr>
        <td><strong>IME:</strong> <?php print $ime; ?> </td>
        <td><strong>PREZIME:</strong> <?php print $prezime; ?> </td>
    </tr>
    <tr>
        <td><strong>GRAD:</strong> <?php print $grad; ?> </td>
        <td><strong>ADRESA:</strong>  <?php print $adresa; ?> </td>
    </tr>
    <tr>
        <td><strong>TELEFON:</strong> <?php print $telefon; ?> </td>
        <td><strong>EMAIL:</strong>  <?php print $email; ?> </td>
    </tr>
    </table>
        <div class="row">
            <div class="col-lg-6">
                <a href="urediProfil.php">
                    <div class="alert alert-plavi pt-4 pb-4">
                        <h5><i class="fas fa-user-edit fa-beli"></i> UREDI PROFIL</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="promenaLozinke.php">
                    <div class="alert alert-plavi pt-4 pb-4">
                        <h5><i class="fas fa-key fa-beli"></i> PROMENA LOZINKE</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>