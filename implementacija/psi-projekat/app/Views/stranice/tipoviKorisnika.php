<div class="container">
    <!-- admin -->
    <div class="jumbotron mb-1 text-center">
        <h4 class="display-4 mb-5">ADMIN</h4>
        <p class="lead">
            Uloga admina je centralna uloga u sistemu. Osnovne funkcije admina su: izdavanje i obnova kartica, 
            evidencija gubitka kartice, kao i evidencija svih uplata i isplata. <br>
            Admin je zadužen za izdavanje kartice registrovanom korisniku na određeni period (dan, sedmica, mesec) 
            na osnovu email adrese, broja tablica automobila i početnog iznosa. <br>
            Registrovani korisnici mogu obnoviti svoje kartice kod admina na određeni period (dan, sedmica, mesec), 
            a takođe mogu uplatiti
            ili podići izvestan novčani iznos sa svoje parking kartice. <br>
            Jedna od uloga admina je i evidencija svakog gubitka kartice. <br>
        </p>
    </div>
    <!-- opeater -->
    <div class="jumbotron mb-1 text-center">
        <h4 class="display-4 mb-5">OPERATER</h4>
        <p class="lead">
            Zadatak operatera je da evidentrira svaki ulazak i izlazak sa parkinga. <br> 
            Prilikom svake evidencije ulaska i izlaska  iz garaže u sistemu se evidentiraju datum i vreme ulaska, odnosno izlaska. <br>
            Operater gostu prilikom ulaska u garažu izdaje karticu na osnovu broja registarskih oznaka automobila, 
            dok mu prilikom izlaska sa
            parkinga ispostavlja račun na osnovu broja sati provedenih na parkingu i eventualnih kazni za nepropisno parkiranje. <br>
            Pri ulasku registrovanog korisnika u garažu, operater od korisnika zahteva karticu, 
            kako bi se u sistemu evidentirali odgovarajući podaci,
            dok pri izlasku iz garaže, operater registrovanom korisniku ispostavlja račun 
            na osnovu eventualnih kazni (ukoliko ih je bilo).
        </p>
    </div>
    <!-- kontrolor -->
    <div class="jumbotron mb-1 text-center">
        <h4 class="display-4 mb-5">KONTROLOR</h4>
        <p class="lead">
            Jedan od zadataka kontrolora jeste da evidentira kazne za nepropisno parkiranje. <br>
            Na osnovu broja registarskih tablica automobila i tipa prekršaja, 
            kontrolor evidentira kaznu u sistemu, koja će korisniku biti naplaćena prilikom izlaska iz garaže. <br>
            On takođe može na osnovu broja registarskih tablica, proveriti da li postoji validna kartica 
            registrovanog korisnika koja se odnosi na taj automobil, a ukoliko se prilikom provere ispostavi da kartica nije validna, 
            u sistemu se evidentira kazna, koja će registrovanom korisniku biti naplaćena prilikom izlaska iz garaže.
        </p>
    </div>
    <!-- korisnik -->
    <div class="jumbotron mb-1 text-center">
        <h4 class="display-4 mb-5">KORISNIK</h4>
        <p class="lead">
            U aplikaciji razlikujemo dva tipa korisnika usluga parking garaže: 
            <strong>gost</strong> i <strong>registrovani korisnik</strong>. <br>
            Gosti su korisnici koji mogu koristiti osnovne mogućnosti parkinga. <br> 
            To podrazumeva da gost pri ulasku u garažu dobija karticu na osnovu broja registarskih tablica automobila, 
            dok mu se pri izlasku sa parkinga ispostavlja račun na osnovu broja sati provedenih na parkingu 
            i eventualnih kazni (za nepropisno parkiranje). <br> 
            Registrovani korisnici poseduju svoj personalni nalog. <br>
            Funkcije koje su na raspolaganju svakom korisniku nakon prijave na nalog su: izmena profila, promena lozinke, 
            pregled svih kartica sa detaljnim podacima o svakoj od njih, obnova kartice, kao i transfer novca između svojih kartica. <br>
            Lično kod admina korisnici, koji su se prethodno registrovali, mogu preuzeti svoju karticu. <br>
            Takođe kod admina, registrovani korisnici mogu uplatiti ili podići izvestan novčani iznos sa svoje parking kartice. 
        </p>
    </div>
</div>
