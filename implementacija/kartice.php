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
    <div class="container-fluid">
    <?php include("kontrolnaTablaDugme.php"); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
        <div class="collapse text-center d-md-block" id="side-nav">
    <h5 class="my-4">KONTROLNA TABLA</h5>
    <div class="list-group text-center mb-2">
        <a href="profil.php" class="list-group-item list-group-item-action py-4">PROFIL</a>
        <a href="promenaLozinke.php" class="list-group-item list-group-item-action py-4">PROMENA LOZINKE</a>
        <a href="kartice.php" class="list-group-item list-group-item-action py-4 active">KARTICE</a>
        <a href="obnovaKartice.php" class="list-group-item list-group-item-action py-4">OBNOVA KARTICE</a>
        <a href="transfer.php" class="list-group-item list-group-item-action py-4">TRANSFER</a>
    </div>
</div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Kartice</h4>
                </div>
                <?php
                if(!$red) { ?>
                    <div class="alert alert-warning text-center">
                        <h4><strong>NAŽALOST U SISTEMU NE POSTOJI NI JEDNA KARTICA KOJA SE ODNOSI NA VAS.</strong></h4>
                    </div>
                <?php 
                } else { ?>
                <table class="table table-hover">
                <thead>
                    <tr class="table-light">
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
                    $datumDo = $red["vaziDo"];
                    $niz = explode("-", $datumDo);
                    $dan = $niz[2];
                    $mesec = $niz[1];
                    $godina = $niz[0];
                    $vazenjeUnix = mktime(0, 0, 0, $mesec, $dan, $godina);
                    $trenutnoUnix = time();
                    $vazeca = ($vazenjeUnix >= $trenutnoUnix) ? true : false;
                    $iznos = $red["stanje"]; ?>
                    <tr class=<?php $vazeca ? print "table-success" : print "table-danger"; ?>>
                    <th scope="row"> <?php print "$idKartice"; ?> </th>
                    <td><?php print "$automobil"; ?></td>
                    <td><?php print "$dan."."$mesec."."$godina."; ?></td>
                    <td><?php print "$iznos"; ?></td>
                    </tr>
                <?php
                } while ($red = mysqli_fetch_array($rezultat));
                } 
                mysqli_close($konekcija); ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
</body>