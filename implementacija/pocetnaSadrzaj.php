<!-- nesto o aplikaciji -->
<div class="container text-center" style="margin-top: 20px;">
    <div class="jumbotron" style="background-color: #e3f2fd;">
        <h2>PARKING APLIKACIJA</h2>
        <p class="lead">
          Aplikacija ima za cilj da simulira sistem naplate parkinga u javnim garažama. Osnovne 
          uloge u sistemu su: <strong>korisnik</strong> (gost i registrovani korisnik), <strong>kontrolor</strong> i <strong>operater</strong>. U nastavku je dat kratak opis svake od uloga.
        </p>
    </div>
</div>
<!-- opeater -->
<div class="container text-center" style="margin-top: 20px;">
    <div class="jumbotron" style="background-color: #e3f2fd;">
        <h3>OPERATER</h3>
        <p class="lead">
          Uloga operatera je centralna uloga u sistemu. Osnovne funkcije operatera su: evidencija svakog ulaska i izlaska sa parkinga, registracija 
          novih korisnika, izdavanje kartica i računa, produžetak važenja kartica, evidencija gubitka kartice (uz izdavanje duplikata) 
          kao i evidencija svih uplata i isplata.
        </p>
    </div>
</div>
<!-- kontrolor -->
<div class="container text-center" style="margin-top: 20px;">
    <div class="jumbotron" style="background-color: #e3f2fd;">
        <h3>KONTROLOR</h3>
        <p class="lead">
          Kontrolor ima zadatak da evidentira kazne za nepropisno parkiranje. Na osnovu broja registarskih tablica automobila i tipa prekršaja, 
          kontrolor evidentira kaznu u sistemu. On takođe može na osnovu broja registarskih tablica, proveriti da li postoji validna kartica u sistemu 
          koja se odnosi na taj automobil.
        </p>
    </div>
</div>
<!-- korisnik -->
<div class="container text-center" style="margin-top: 20px;">
    <div class="jumbotron" style="background-color: #e3f2fd;">
        <h3>KORISNIK</h3>
        <p class="lead">
          U aplikaciji razlikujemo dva tipa korisnika: goste i registrovane korisnike.
          Gosti su korisnici koji mogu koristiti osnovne mogućnosti parkinga, dok registrovani korisnici poseduju svoj personalni nalog.
          Putem naloga registrovani korisnici mogu produžiti period važenja svoje kartice i promeniti lozinku. Lično kod operatera mogu 
          preuzeti svoju karticu, prijaviti gubitak kartice, izvaditi duplikat u slučaju izbgubljene kartice, uplatiti ili podići 
          izvestan novčani iznos sa svoje kartice.
        </p>
    </div>
</div>