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
    <title>OPERATER</title>
  </head>
  <body>
    <?php include("navOperater.php"); ?>
    <div class="container text-center mt-3">
      <?php include("operaterSadrzaj.php"); ?> 
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>