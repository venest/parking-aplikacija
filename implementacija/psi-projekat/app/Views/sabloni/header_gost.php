<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- selectpicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- nas css -->
    <link rel="stylesheet" href=<?php echo site_url('css/stil.css'); ?>>
    
    <title><?php echo $naslov; ?></title>
    
  </head>
  <body>
    <nav class="navbar navbar-expand-xl navbar-light bg-white">
    <a class="navbar-brand" href="/"><i class="fas fa-parking fa-4x fa-nav font-plavi"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
          <li class="nav-item">
          <a class="nav-link <?php if($naslov == 'POČETNA') echo 'active'; ?>" href=<?php echo site_url('Gost/pocetna'); ?>>Početna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($naslov == 'TIPOVI KORISNIKA') echo 'active'; ?>" href=<?php echo site_url('Gost/tipoviKorisnika'); ?>>Tipovi korisnika</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($naslov == 'CENOVNIK') echo 'active'; ?>" href=<?php echo site_url('Gost/cenovnik'); ?>>Cenovnik</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($naslov == 'KONTAKT') echo 'active'; ?>" href=<?php echo site_url('Gost/kontakt'); ?>>Kontakt</a>
        </li>
      </ul> 
      <ul class="navbar-nav ml-auto">
        <li>
          <a class="nav-link <?php if($naslov == 'LOGOVANJE') echo 'active'; ?>" href=<?php echo site_url('Gost/logovanje'); ?>>Uloguj se</a>
        </li>
      </ul> 
    </div>
    </nav>

