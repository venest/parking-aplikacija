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
        <a class="navbar-brand" href=<?php echo site_url('Registrovani/pocetna'); ?>><i class="fas fa-parking fa-4x fa-nav font-plavi"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php if($naslov == 'POČETNA') echo 'active'; ?>" href=<?php echo site_url('Registrovani/pocetna'); ?>>Početna</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($naslov == 'TIPOVI KORISNIKA') echo 'active'; ?>" href=<?php echo site_url('Registrovani/tipoviKorisnika'); ?>>Tipovi korisnika</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($naslov == 'CENOVNIK') echo 'active'; ?>" href=<?php echo site_url('Registrovani/cenovnik'); ?>>Cenovnik</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if($naslov == 'KONTAKT') echo 'active'; ?>" href=<?php echo site_url('Registrovani/kontakt'); ?>>Kontakt</a>
            </li>
          </ul> 
          <ul class="navbar-nav ml-auto">
            <li>
            <div class="dropdown">
              <a class="nav-link dropdown-toggle <?php if($naslov != 'POČETNA' && $naslov != 'TIPOVI KORISNIKA' && $naslov != 'CENOVNIK' && $naslov != 'KONTAKT') echo 'active'; ?>" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                    $session = session();
                    echo $session->get('korisnickoIme'); 
                ?>
              </a>

              <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item pt-3 pb-3" href=<?php echo site_url('Registrovani/kontrolnaTabla'); ?>>KONTROLNA TABLA</a>
                <a class="dropdown-item pt-3 pb-3" href=<?php echo site_url('Registrovani/odjaviSe'); ?>>ODJAVI SE</a>
              </div>
            </div>
            </li>
          </ul> 
        </div>
    </nav>
    <?php
        if($naslov != 'POČETNA' && $naslov != 'TIPOVI KORISNIKA' && $naslov != 'CENOVNIK' && $naslov != 'KONTAKT') { ?>
                <div class="container-fluid">
    <div class="row">
        <div class="col-12 mt-2 mb-2">
            <button class="btn side-nav-toggler d-md-none" type="button" data-toggle="collapse" data-target="#side-nav" aria-expanded="false">
                <i class="fas fa-th-large fa-3x font-plavi"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="collapse text-center d-md-block" id="side-nav">
                <div class="list-group text-center mb-2">
                    <a href=<?php echo site_url('Registrovani/profil'); ?> class="list-group-item list-group-item-action py-4 <?php if($naslov == 'PROFIL') echo 'active'; ?>">PROFIL</a>
                    <a href=<?php echo site_url('Registrovani/promenaLozinke'); ?> class="list-group-item list-group-item-action py-4 <?php if($naslov == 'PROMENA LOZINKE') echo 'active'; ?>">PROMENA LOZINKE</a>
                    <a href=<?php echo site_url('Registrovani/kartice'); ?> class="list-group-item list-group-item-action py-4 <?php if($naslov == 'KARTICE') echo 'active'; ?>">KARTICE</a>
                    <a href=<?php echo site_url('Registrovani/obnovaKartice'); ?> class="list-group-item list-group-item-action py-4 <?php if($naslov == 'OBNOVA KARTICE') echo 'active'; ?>">OBNOVA KARTICE</a>
                    <a href=<?php echo site_url('Registrovani/transfer'); ?> class="list-group-item list-group-item-action py-4 <?php if($naslov == 'TRANSFER') echo 'active'; ?>">TRANSFER</a>
                </div>
            </div>
        </div> <?php
  } ?>

