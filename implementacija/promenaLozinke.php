<?php

    // autor: Veljko Nestorovic 0039/2017

    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
        header("Location: logovanje.php");
        exit();
    }
    $email = $_SESSION["korisnickoIme"];
    $stara = $_SESSION["lozinka"];
    if(isset($_REQUEST["promeniLozinku"])) {
        $unetaStara = $_REQUEST["staraLozinka"];
        $nova = $_REQUEST["novaLozinka"];
        $novaPonovo = $_REQUEST["novaLozinkaPonovo"];
        $staraOk = false;
        $novaOk = false;
        $svePopunjeno = false;
        if(strcmp($unetaStara, "") != 0 && strcmp($nova, "") != 0 && strcmp($novaPonovo, "") != 0) {
            $svePopunjeno = true;
            if(strcmp($stara, $unetaStara) == 0) $staraOk = true;
            if(strcmp($nova, $novaPonovo) == 0) $novaOk = true;
            if($staraOk && $novaOk) {
                $konekcija = mysqli_connect("localhost", "root", "", "parking_aplikacija") or die("neuspesna konekcija sa bazom"); 
                $upit = "UPDATE registrovani SET lozinka = '$nova' WHERE email = '$email'";
                $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
                $_SESSION["lozinka"] = $nova;
                mysqli_close($konekcija);
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
                    <a href="profil.php" class="list-group-item list-group-item-action py-4">PROFIL</a>
                    <a href="promenaLozinke.php" class="list-group-item list-group-item-action py-4 active">PROMENA LOZINKE</a>
                    <a href="kartice.php" class="list-group-item list-group-item-action py-4">KARTICE</a>
                    <a href="obnovaKartice.php" class="list-group-item list-group-item-action py-4">OBNOVA KARTICE</a>
                    <a href="transfer.php" class="list-group-item list-group-item-action py-4">TRANSFER</a>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Promena lozinke</h4>
                </div>
            <?php
            if(isset($_REQUEST["promeniLozinku"])) {
                if(!$svePopunjeno) { ?>
                    <div class="row justify-content-center">
                        <div class="alert alert-danger text-center col-lg-9">
                            <strong>SVA POLJA FORME MORAJU BITI POPUNJENA.</strong>
                        </div>
                    </div>
                <?php
                } else if(!$staraOk) { ?>
                    <div class="row justify-content-center">
                        <div class="alert alert-danger text-center col-lg-9">
                            <strong>STARA LOZINKA NIJE KOREKTNA.</strong>
                        </div>
                    </div>
                <?php
                } else if(!$novaOk) { ?>
                    <div class="row justify-content-center">
                        <div class="alert alert-danger text-center col-lg-9">
                            <strong>POTVRDA NOVE LOZINKE NIJE USPELA.</strong>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="row justify-content-center">
                        <div class="alert alert-success text-center col-lg-9">
                            <strong>USPEŠNO STE PROMENILI LOZINKU.</strong>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
            <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="staraLozinka">STARA LOZINKA</label>
                        <input type="password" class="form-control form-control-lg" id="staraLozinka" name="staraLozinka" placeholder="unesite staru lozinku" value="">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="novaLozinka">NOVA LOZINKA</label>
                        <input type="password" class="form-control form-control-lg" id="novaLozinka" name="novaLozinka" placeholder="unesite novu lozinku" value="">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                        <label for="novaLozinkaPonovo">PONOVITE NOVU LOZINKU</label>
                        <input type="password" class="form-control form-control-lg" id="novaLozinkaPonovo" name="novaLozinkaPonovo" placeholder="unesite novu lozinku" value="">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <button type="submit" name="promeniLozinku" class="btn btn-plavi btn-block mt-3 py-3">PROMENI LOZINKU</button>
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