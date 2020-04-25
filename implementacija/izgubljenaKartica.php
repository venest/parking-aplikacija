<?php
  session_start();
  $korisnickoIme = $_SESSION["korisnickoIme"];
  if(!isset($_SESSION["ulogovan"])) { 
    header("Location: logovanje.php");
    exit();
  } 
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include("bootstrapHeder.php"); ?>
    <link rel="stylesheet" type="text/css" href="stil.css">
    <title>OPERATER</title>
  </head>
  <body>
    <div class="container-fluid">
      <?php include("operaterHeder.php"); ?>
    </div>
    <div class="container">
    <div class="jumbotron bg-siva">
      <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
        <div class="row justify-content-center">
          <div class="form-group col-lg-6 col-md-9" id="lozinka">
            <label for="idKartice">ID KARTICE</label>
            <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice" placeholder="unesite ID kartice">
          </div>
        </div>
        <div class="row justify-content-center">
            <button type="submit" name="evidentirajGubitak" class="btn btn-plavi btn-lg mt-3 pr-5 pl-5 pt-3 pb-3">EVIDENTIRAJ GUBITAK</button>
          </div>
      </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
  </body>
</html>