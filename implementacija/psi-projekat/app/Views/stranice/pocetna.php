<div class="container">
    <!-- nesto o aplikaciji -->
    <div class="jumbotron text-center">
        <h4 class="display-4 mb-5">PARKING APLIKACIJA</h4>
        <p class="lead">
            Parking aplikacija je aplikacija koja simulira sistem naplate parkinga u javnim garažama.
            Osnovne uloge u sistemu su: <strong>admin</strong>, <strong>operater</strong>, 
            <strong>kontrolor</strong>, <strong>gost</strong> i <strong>registrovani korisnik</strong>. <br>
            Pri svakom ulasku i izlasku iz garaže, bez obzira na to da li se radi o gostu ili registrovanom korisniku, 
            u sistemu se evidentiraju datum i vreme ulaska, odnosno izlaska. <br>
            Svakom gostu, pri ulasku na parking, operater izdaje karticu na osnovu broja registarskih tablica automobila, 
            dok mu pri izlasku operater ispostavlja račun na osnovu broja sati provedenih na parkingu i eventualnih kazni (za nepropisno parkiranje). <br>
            Registrovani korisnik, pri ulasku na parking, ima obavezu da operateru pokaže svoju karticu 
            kako bi se u sistemu evidentirali odgovarajući podaci (datum i vreme ulaska), dok mu pri izlasku operater ispostavlja račun 
            na osnovu eventualnih kazni (ukoliko ih je bilo). <br>
            Da bi gost stekao privilegije registrovanog korisnika, potrebno je prvo da se registruje putem sajta, 
            a zatim i da preuzme svoju parking karticu (kod admina). <br>
            Registrovani korisnik može obnoviti svoju karticu na određeni period (dan, sedmica, mesec), 
            bez obzira da li je reč o kartici kojoj je istekao period važenja ili ne. 
            To može obaviti na dva načina: putem svog naloga (ukoliko ima dovoljno sredstava na konkretnoj kartici) ili 
            plaćanjem kod admina. <br>
            Još neke od mogućnosti koje registrovani korisnik dobija nakon uspešne prijave na nalog su: 
            izmena profila, promena lozinke, pregled svih kartica sa detaljnim podacima o svakoj od njih, 
            transfer sredstava sa jedne svoje kartice na drugu i kao što je već rečeno obnova kartice na određeni period 
            (dan, sedmica, mesec). <br>
            Registrovani korisnik može uplatiti izvestan novčani iznos na svoju karticu plaćanjem kod admina. 
            On takođe može tražiti i isplatu određenih sredstava sa svoje parking kartice, za šta je takođe zadužen admin. <br>
            U slučaju gubitka kartice, i gost i registrovani korisnik treba da se obrate adminu. <br>
            Sistem će omogućiti i kontrolu parkiranja, koju obavlja zaposleni sa ulogom kontrolora. <br>
            Kontrolor može, na osnovu broja registarskih tablica automobila, da proveri da li postoji validna kartica 
            registrovanog korisnika koja se odnosi na taj automobil. 
            U slučaju da kartica nije validna u sistemu se evidentira kazna, koja će biti dodata na račun koji 
            registrovani korisnik plaća prilikom izlaska. <br>
            Još jedan zadatak kontrolora jeste da vrši proveru da li su automobili regularno parkirani 
            (parkiranje na mestu za invalide, parkiranje na mestu za trudnice, zauzimanje više parking mesta). 
            Za svaki od ovih prekršaja kontrolor takođe evidentira kaznu. 
            Kazna će biti dodata na račun koji korisnik plaća prilikom izlaska. <br>
            Zaposleni sa ulogom operatera ima zadatak da evidentira svaki ulazak i izlazak iz garaže. <br>
            U sistemu postoji još jedna uloga, a to je uloga admina. 
            Zaposleni sa ovom ulogom ima najveća ovlašćenja i to je centralna uloga u sistemu.<br>
            Osnovne funkcionalnosti admina su: izdavanje i obnova kartice, evidencija gubitka kartice (uz izdavanje duplikata) 
            kao i evidencija svih uplata i isplata.
    </div>   
</div>

