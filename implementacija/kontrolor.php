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

<!-- autor: Veljko Nestorovic 0039/2017 -->
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" href="stil.css">
    <title>Kontrolor</title>
  </head>
  <body>
    <div class="container text-center" style="margin-top: 20px;">
      <?php include("kontrolorHeder.php"); ?>
      <form method="POST" action="kontrolor.php">
        <?php include("kontrolorSadrzaj.php"); ?>
      </form>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>