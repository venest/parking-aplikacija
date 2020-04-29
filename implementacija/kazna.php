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
    <div class="container">
    <div class="jumbotron pt-0 mb-1">
      <div class="row justify-content-center pt-4 pb-4">
          <h4>Kazna</h4>
        </div>
        <form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>" autocomplete="off">
          <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <div class="form-group">
                <label for="tablice">BROJ REGISTARSKIH TABLICA</label>
                <input type="text" class="form-control form-control-lg" name="tablice" id="tablice" placeholder="unesite broj tablica">
            </div>
          </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
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
            <div class="col-lg-6 col-md-9">
              <div class="form-group">
                <label for="iznos">IZNOS KAZNE</label>
                <div class="input-group">
                <input type="text" class="form-control form-control-lg" id="iznos" value="15000" readonly>
                <div class="input-group-append">
                  <span class="input-group-text">RSD</span>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
          <div class="col-lg-6 col-md-9">
            <button type="submit" name="evidentirajKaznu" class="btn btn-plavi btn-block mt-3 pt-3 pb-3">EVIDENTIRAJ KAZNU</button>
          </div>
          </div>
        </form>
    </div>
    </div>
    <?php include("bootstrapFuter.php"); ?>
    <script>
      function promena() {
        var opcija = document.getElementById("tipPrekrsaja").value;
        var tekst;
        kaznaTrudnice = 12000;
        kaznaInvalidi = 15000;
        kaznaViseMesta = 8000;
        switch(opcija) {
          case "prva": tekst = kaznaInvalidi; break;
          case "druga": tekst = kaznaTrudnice; break;
          case "treca": tekst = kaznaViseMesta; break;
        }
        document.getElementById("iznos").value = tekst;
      }
    </script>
  </body>
</html>