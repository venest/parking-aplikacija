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
    <div class="container-fluid mb-2">
   <?php include("operaterHeder.php"); ?>
   </div> 
   <div class="container-fluid text-center">
   <?php include("operaterSadrzaj.php"); ?> 
   </div>
    <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
      <div class="row justify-content-center">
        <button type="submit" name="izlogujSe" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">IZLOGUJ SE</button>
      </div>
    </form>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>