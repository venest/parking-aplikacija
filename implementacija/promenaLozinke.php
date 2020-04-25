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
    <div class="container-fluid">
        <?php include("korisnikHeder.php"); ?>
    </div>
    <div class="container">
    <div class="jumbotron bg-siva">
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <?php
            if(isset($_REQUEST["promeniLozinku"])) {
             if(!$svePopunjeno) {
            ?>
                <div class="row justify-content-center">
                    <div class="alert alert-danger text-center col-lg-6 col-md-9">
                        <strong>SVA POLJA FORME MORAJU BITI POPUNJENA!</strong>
                    </div>
                </div>
            <?php
             } else if(!$staraOk) {
            ?>
                <div class="row justify-content-center">
                    <div class="alert alert-danger text-center col-lg-6 col-md-9">
                        <strong>STARA LOZINKA NIJE KOREKTNA!</strong>
                    </div>
                </div>
            <?php
             } else if(!$novaOk) {
            ?>
                <div class="row justify-content-center">
                    <div class="alert alert-danger text-center col-lg-6 col-md-9">
                        <strong>POTVRDA NOVE LOZINKE NIJE USPELA!</strong>
                    </div>
                </div>
            <?php
             } else {
            ?>
                <div class="row justify-content-center">
                    <div class="alert alert-success text-center col-lg-6 col-md-9">
                        <strong>USPEŠNO STE PROMENILI LOZINKU!</strong>
                    </div>
                </div>
            <?php
             }
            }
            ?>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="staraLozinka">STARA LOZINKA</label>
                  <input type="password" class="form-control form-control-lg" id="staraLozinka" name="staraLozinka" placeholder="unesite staru lozinku" value="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9" id="lozinka">
                  <label for="novaLozinka">NOVA LOZINKA</label>
                  <input type="password" class="form-control form-control-lg" id="novaLozinka" name="novaLozinka" placeholder="unesite novu lozinku" value="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9" id="lozinka">
                  <label for="novaLozinkaPonovo">PONOVITE NOVU LOZINKU</label>
                  <input type="password" class="form-control form-control-lg" id="novaLozinkaPonovo" name="novaLozinkaPonovo" placeholder="unesite novu lozinku" value="">
                </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" name="promeniLozinku" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">PROMENI LOZINKU</button>
            </div>
        </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>