<nav class="navbar navbar-expand-xl navbar-light bg-white">
    <a class="navbar-brand" href="index.php"><i class="fas fa-parking fa-4x fa-nav font-plavi"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Početna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tipoviKorisnika.php">Tipovi korisnika</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cenovnik.php">Cenovnik</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kontakt.php">Kontakt</a>
        </li>
      </ul> 
      <ul class="navbar-nav ml-auto">
        <li>
        <div class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php print $korisnickoIme; ?>
          </a>

          <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item pt-3 pb-3" href="kontrolor.php">KONTROLNA TABLA</a>
            <a class="dropdown-item pt-3 pb-3" href="kontrolor.php?izlogujSe=true">IZLOGUJ SE</a>
          </div>
        </div>
        </li>
      </ul> 
    </div>
</nav>