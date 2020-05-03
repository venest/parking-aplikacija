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
    <link rel="stylesheet" href="stil.css">
    <title>KONTROLOR</title>
  </head>
  <body>
    <?php include("navKontrolor.php"); ?>
    <div class="container-fluid">
    <?php include("kontrolnaTablaDugme.php"); ?>
    <div class="row">
        <div class="col-md-4 col-xs-12">
          <div class="collapse text-center d-md-block" id="side-nav">
            <h5 class="my-4">KONTROLNA TABLA</h5>
            <div class="list-group text-center mb-2">
              <a href="provera.php" class="list-group-item list-group-item-action py-4">PROVERA</a>
              <a href="kazna.php" class="list-group-item list-group-item-action py-4 active">KAZNA</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Kazna</h4>
                </div>
                <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <div class="form-group">
                        <label for="tablice">AUTOMOBIL</label>
                        <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite broj tablica">
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <div class="form-group">
                        <label for="tipPrekrsaja">TIP PREKRŠAJA</label>
                        <select class="form-control form-control-lg" name="tipPrekrsaja" id="tipPrekrsaja" onclick="promena()">
                          <option value="prva">PARKIRANJE NA MESTU ZA INVALIDE</option>
                          <option value="druga">PARKIRANJE NA MESTU ZA TRUDNICE</option>
                          <option value="treca">ZAUZIMANJE VIŠE PARKING MESTA</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" name="evidentirajKaznu" class="btn btn-plavi btn-block mt-3 py-3">EVIDENTIRAJ KAZNU</button>
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