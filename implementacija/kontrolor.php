<?php
  session_start();
  $korisnickoIme = $_SESSION["korisnickoIme"];
  if(!isset($_SESSION["ulogovan"])) { 
    header("Location: logovanje.php");
    exit();
  }
  if(isset($_REQUEST["izlogujSe"])) {
    unset($_SESSION["korisnickoIme"]);
    unset($_SESSION["lozinka"]);
    unset($_SESSION["ulogovan"]);
    unset($_SESSION["tip"]);
    session_destroy();
    header("Location: logovanje.php");
    exit(); 
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>KONTROLOR</title>
  </head>
  <body>
    <div class="container text-center" style="margin-top: 20px;">
      <?php include("kontrolorHeder.php"); include("kontrolorSadrzaj.php"); ?>
      <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <div class="row justify-content-center">
          <button type="submit" name="izlogujSe" class="btn btn-secondary btn-lg" style="margin-top: 20px; margin-bottom: 30px;">IZLOGUJ SE</button>
        </div>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>