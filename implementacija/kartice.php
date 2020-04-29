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
    <?php include("navKorisnik.php"); ?>
    <div class="container text-center mt-3">
    <?php
    if(!$red) { ?>
        <div class="alert alert-warning">
            <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
        </div>
    <?php 
    } else { ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">AUTOMOBIL</th>
            <th scope="col">VAŽI DO</th>
            <th scope="col">STANJE</th>
        </tr>
        </thead>
    <tbody>
    <?php
        do {
            $idKartice = $red["idKartice"];
            $automobil = $red["automobil"];
            $datumDo = $red["datumVazenja"];
            $niz = explode("-", $datumDo);
            $dan = $niz[2];
            $mesec = $niz[1];
            $godina = $niz[0];
            $vazenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina);
            $trenutnoUnix = time();
            $vazeca = ($vazenjeUnix >= $trenutnoUnix) ? true : false;
            $iznos = $red["iznos"]; ?>
            <tr class=<?php $vazeca ? print "table-success" : print "table-danger"; ?>>
            <th scope="row"> <?php print "$idKartice"; ?> </th>
            <td><?php print "$automobil"; ?></td>
            <td><?php print "$dan."."$mesec."."$godina."; ?></td>
            <td><?php print "$iznos"; ?></td>
            </tr>
    <?php
        } while ($red = mysqli_fetch_array($rezultat));
    } mysqli_close($konekcija); ?>
    </tbody>
    </table>
    <div class="row">
        <div class="col-lg-6">
            <a href="transfer.php">
                <div class="alert alert-plavi pt-4 pb-4">
                    <h5><i class="fas fa-coins fa-beli"></i> TRANSFER NOVCA</h5>
                </div>
            </a>
        </div>
        <div class="col-lg-6">
            <a href="produzetak.php">
                <div class="alert alert-plavi pt-4 pb-4">
                    <h5><i class="fas fa-id-card fa-beli"></i> PRODUŽETAK VAŽENJA KARTICE</h5>
                </div>
            </a>
        </div>
    </div> 
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>