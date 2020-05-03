<!-- admin -->
<div class="jumbotron mb-1 text-center">
  <h4 class="display-4 mb-5">ADMIN</h4>
  <p class="lead">
    Uloga admina je centralna uloga u sistemu. Osnovne funkcije admina su: izdavanje i obnova kartica, 
    evidencija gubitka kartice (uz izdavanje duplikata), kao i evidencija svih uplata i isplata. <br>
    Admin je zadužen za izdavanje kartice registrovanom korisniku na određeni period (dan, sedmica, mesec) na osnovu email adrese
    i broja tablica automobila. <br>
    Registrovani korisnici mogu obnoviti svoje kartice kod admina na određeni period (dan, sedmica, mesec), a takođe mogu uplatiti
    ili podići izvestan novčani iznos sa svoje kartice. <br>
    Uloga admina je i evidencija svakog gubitka kartice, i tom prilikom na osnovu email adrese i broja tablica admin korisniku 
    izdaje duplikat izgubljene kartice. <br>
  </p>
</div>
<!-- opeater -->
<div class="jumbotron mb-1 text-center">
  <h4 class="display-4 mb-5">OPERATER</h4>
  <p class="lead">
    Zadatak operatera je da evidentrira svaki ulazak i izlazak sa parkinga. <br> 
    Prilikom svake evidencije ulaska i izlaska  iz garaže operater u sistemu evidentira datum i vreme ulaska, odnosno izlaska. <br>
    Operater gostu prilikom ulaska u garažu izdaje karticu na osnovu broja registarskih oznaka automobila, dok mu prilikom izlaska sa
    parkinga ispostavlja račun na osnovu broja sati provedenih na parkingu i eventualnih kazni. <br>
    Pri ulasku registrovanog korisnika u garažu operater proverava validnost kartice, dok pri izlasku na osnovu ID-ja kartice 
    ispostavlja korisniku račun na osnovu eventualnih kazni (ukoliko ih je bilo).
  </p>
</div>
<!-- kontrolor -->
<div class="jumbotron mb-1 text-center">
  <h4 class="display-4 mb-5">KONTROLOR</h4>
  <p class="lead">
    Kontrolor ima zadatak da evidentira kazne za nepropisno parkiranje. Na osnovu broja registarskih tablica automobila i tipa prekršaja, 
    kontrolor evidentira kaznu u sistemu. On takođe može na osnovu broja registarskih tablica, proveriti da li postoji validna kartica u sistemu 
    koja se odnosi na taj automobil.
  </p>
</div>
<!-- korisnik -->
<div class="jumbotron mb-1 text-center">
  <h4 class="display-4 mb-5">KORISNIK</h4>
  <p class="lead">
    U aplikaciji razlikujemo dva tipa korisnika usluga parking garaže: <strong>gost</strong> i <strong>registrovani korisnik</strong>. <br>
    Gosti su korisnici koji mogu koristiti osnovne mogućnosti parkinga. To podrazumeva da gost po dolasku na parking dobija 
    karticu na osnovu registarskih oznaka automobila, dok mu se pri izlasku sa parkinga ispostavlja račun na osnovu broja sati 
    provedenih na parkingu. <br> 
    Registrovani korisnici poseduju svoj personalni nalog.
    Funkcije koje su na raspolaganju svakom korisniku nakon prijave na nalog (logovanja) su: izmena profila, promena lozinke, 
    pregled svih kartica sa podacima o stanju i periodu važenja, obnova kartice, kao i transfer novca između svojih kartica.
    Lično kod admina korisnici koji su se prethodno registrovali mogu preuzeti svoju karticu. Takođe kod admina,
    registrovani korisnici koji imaju kartice mogu uplatiti ili podići izvestan novčani iznos sa svoje kartice kao i
    prijaviti gubitak kartice uz izdavanje duplikata. 
  </p>
</div>