<?php
    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
        header("Location: logovanje.php");
        exit();
    }
    $email = $_SESSION["korisnickoIme"];
    $stara = $_SESSION["lozinka"];
    if(isset($_REQUEST["promenaLozinke"])) {
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

<!-- autor: Veljko Nestorovic 0039/2017 -->
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>Korisnik</title>
  </head>
  <body>
    <div class="container" style="margin-top: 20px;">
        <?php include("korisnikHeder.php"); ?>
        <form method="POST" action="promenaLozinke.php">
        <?php
            if(isset($_REQUEST["promenaLozinke"])) {
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
                  <input type="password" class="form-control" id="staraLozinka" name="staraLozinka" placeholder="Stara lozinka" value="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9" id="lozinka">
                  <label for="inputPassword4">NOVA LOZINKA</label>
                  <input type="password" class="form-control" id="novaLozinka" name="novaLozinka" placeholder="Nova lozinka" value="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9" id="lozinka">
                  <label for="inputPassword4">PONOVITE NOVU LOZINKU</label>
                  <input type="password" class="form-control" id="novaLozinkaPonovo" name="novaLozinkaPonovo" placeholder="Nova lozinka" value="">
                </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" name="promenaLozinke" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">PROMENA LOZINKE</button>
            </div>
        </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>