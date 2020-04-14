<?php
    session_start();
    if(!isset($_SESSION["ulogovan"])) { 
      header("Location: logovanje.php");
      exit();
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
    if(isset($_REQUEST["sacuvajIzmene"])) {
        $novoIme = $_REQUEST["ime"];
        $novoPrezime = $_REQUEST["prezime"];
        $noviGrad = $_REQUEST["grad"];
        $novaAdresa = $_REQUEST["adresa"];
        $noviTelefon = $_REQUEST["telefon"];
        $noviEmail = $_REQUEST["email"];
        $svePopunjeno = false;
        $emailOk = false;
        if(strcmp($noviEmail, "") != 0 && strcmp($novoIme, "") != 0 && strcmp($novoPrezime, "") != 0 && strcmp($noviGrad, "") != 0 && strcmp($novaAdresa, "") != 0 && strcmp($noviTelefon, "") != 0) {
            $svePopunjeno = true;
            if(strcmp($email, $noviEmail) != 0) {
              $upit = "SELECT * FROM registrovani WHERE email = '$noviEmail'";
              $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
              $red = mysqli_fetch_array($rezultat); 
              if(!$red) $emailOk = true;
            } else $emailOk = true;
            if($emailOk) {
              $upit = "UPDATE registrovani SET email = '$noviEmail', ime = '$novoIme', prezime = '$novoPrezime', grad = '$noviGrad', adresa = '$novaAdresa', telefon = '$noviTelefon' WHERE idKorisnika = '$idKorisnika'";
              $rezultat = mysqli_query($konekcija, $upit) or die("neuspesno izvrsavanje upita");
              $_SESSION["korisnickoIme"] = $noviEmail;
            }
        }
    }
?>
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
        <form method="POST" action="urediProfil.php" autocomplete="off">
        <?php
            if(isset($_REQUEST["sacuvajIzmene"])) {
              if(!$svePopunjeno) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-6 col-md-9">
                    <strong>SVA POLJA FORME MORAJU BITI POPUNJENA!</strong>
                  </div>
                </div> <?php
              } else if(!$emailOk) { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-danger text-center col-lg-6 col-md-9">
                    <strong>UNETI EMAIL VEĆ POSTOJI U SISTEMU!</strong>
                  </div>
                </div> <?php
              } else { ?>
                <div class="row justify-content-center">
                  <div class="alert alert-success text-center col-lg-6 col-md-9">
                    <strong>IZMENE SU SAČUVANE!</strong>
                  </div>
                </div> <?php
              }
            }
            ?>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="ime">EMAIL ADRESA</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $email; else print $noviEmail; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="ime">IME</label>
                  <input type="text" name="ime" class="form-control" id="ime" placeholder="Ime" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $ime; else print $novoIme; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="prezime">PREZIME</label>
                  <input type="text" name="prezime" class="form-control" id="prezime" placeholder="Prezime" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $prezime; else print $novoPrezime; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="grad">GRAD</label>
                  <input type="text" name="grad" class="form-control" id="grad" placeholder="Grad" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $grad; else print $noviGrad; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="adresa">ADRESA</label>
                  <input type="text" name="adresa" class="form-control" id="adresa" placeholder="Ulica i broj" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $adresa; else print $novaAdresa; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="form-group col-lg-6 col-md-9">
                  <label for="telefon">TELEFON</label>
                  <input type="text" name="telefon" class="form-control" id="telefon" placeholder="Telefon" value="<?php if(!isset($_REQUEST["sacuvajIzmene"])) print $telefon; else print $noviTelefon; ?>">
                </div>
            </div>
            <div class="row justify-content-center">
              <button type="submit" name="sacuvajIzmene" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">SAČUVAJ IZMENE</button>
            </div>
          </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>