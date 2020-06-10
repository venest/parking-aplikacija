<?php


namespace App\Controllers;

use App\Models\RegistrovaniModel;
use App\Models\KarticaModel;
use App\Models\RacunModel;
use App\Models\UplataModel;
use App\Models\IsplataModel;
use App\Models\ObnovaModel;
use App\Models\IzdavanjeModel;
use App\Models\BoravakModel;
use App\Models\KaznaModel;

define('CENA_DAN', 200);
define('CENA_SEDMICA', 800);
define('CENA_MESEC', 2000);
define('CENA_IZDAVANJE', 1000);


date_default_timezone_set('Europe/Belgrade');


/* 
 * 
 * autori:
 * 
 * MARINA SPASIĆ 0689/2017
 * 
 * PETAR PETROVIĆ 0538/2017
 * 
 * 
 * 
 * Admin controller 
 * 
 * 
 * 
 * klasa sadrži metode za prikaz odgovarajućih php stranica: 
 * 
 * kontrolnaTabla(), izdavanjeKartice(), obnovaKartice(), uplata(), isplata(), gubitakKartice(), 
 * 
 * kao i metode za sprovođenje samih funkcionalnosti: 
 * 
 * izdavanjeKarticeSubmit(), obnovaKarticeSubmit(), gubitakKarticeSubmit(),
 * 
 * uplataNaKarticuSubmit(), isplataSaKarticeSubmit()
 * 
 * 
*/


class Admin extends Korisnik
{

    public function prikazi($page, $data)
    {
        echo view('sabloni/header_admin', $data);
        if ($page != '')
            echo view("stranice/$page", $data);
        echo view('sabloni/footer_admin', $data);
    }

    public function index()
    {
        $data['naslov'] = 'KONTROLNA TABLA';
        $this->prikazi('', $data);
    }

    public function kontrolnaTabla()
    {
        $data['naslov'] = 'KONTROLNA TABLA';
        $this->prikazi('', $data);
    }

    public function odjaviSe()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('Gost/prijava'));
    }

    public function izdavanjeKartice()
    {
        $data['naslov'] = 'IZDAVANJE KARTICE';
        $this->prikazi('izdavanjeKartice', $data);
    }

    public function obnovaKartice()
    {
        $data['naslov'] = 'OBNOVA KARTICE';
        $this->prikazi('obnovaKarticeAdmin', $data);
    }

    public function uplata()
    {
        $data['naslov'] = 'UPLATA';
        $this->prikazi('uplata', $data);
    }

    public function isplata()
    {
        $data['naslov'] = 'ISPLATA';
        $this->prikazi('isplata', $data);
    }

    public function gubitakKartice()
    {
        $data['naslov'] = 'GUBITAK KARTICE';
        $this->prikazi('gubitakKartice', $data);
    }

    /*
    izdavanje kartice registrovanom korisniku
    koristi email, tablice, iznos za uplacivanje i period produzenja
    */
    public function izdavanjeKarticeSubmit()
    {

        $email = $this->request->getVar('email');
        $tablice = $this->request->getVar('tablice');
        $stanje = $this->request->getVar('iznos');
        $period = $this->request->getVar('period');

        $rules['email'] = 'required';
        $messages['email']['required'] = 'UNESITE EMAIL.';
        $rules['tablice'] = 'required';
        $messages['tablice']['required'] = 'UNESITE TABLICE.';
        $rules['iznos'] = 'required|decimal|greater_than[0.0]';
        $messages['iznos']['required'] = 'UNESITE IZNOS.';
        $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
        $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';
        if (!$this->validate($rules, $messages)) {
            if ($this->validator->hasError('email')) $poruka = $this->validator->getError('email');
            else if ($this->validator->hasError('tablice')) $poruka = $this->validator->getError('tablice');
            else if ($this->validator->hasError('iznos')) $poruka = $this->validator->getError('iznos');
        } else {


            $rm = new RegistrovaniModel();
            $kor = $rm->dohvatiKorisnika($email);

            if ($kor == null) {
                $poruka = 'NE POSTOJI KORISNIK SA UNETIM EMAIL-OM.';
            } else {

                $idKor = $kor->idKorisnika;

                $km = new KarticaModel();
                $karticaPostojeca = $km->nadjiKarticu($tablice, $idKor);
                if ($karticaPostojeca != null) {
                    $poruka = 'VEĆ POSTOJI KARTICA IZDATA ZA UNETOG KORISNIKA I TABLICE';
                } else {

                    switch ($period) {
                        case 'dan':
                            $cena = CENA_DAN;
                            break;
                        case 'sedmica':
                            $cena = CENA_SEDMICA;
                            break;
                        case 'mesec':
                            $cena = CENA_MESEC;
                            break;
                    }

                    //var_dump($period);

                    $cena += CENA_IZDAVANJE;

                    if ($stanje < $cena) {
                        $poruka = "NEMA DOVOLJNO SREDSTAVA ZA ŽELJENE OPCIJE. <br> POTREBNI IZNOS JE: $cena DIN";
                    } else {
                        $datumTekuci = explode('-', date('Y-m-d'));
                        $danTekuci = (int) $datumTekuci[2];
                        $mesecTekuci = (int) $datumTekuci[1];
                        $godinaTekuca = (int) $datumTekuci[0];
                        $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                        switch ($period) {
                            case 'dan':
                                $sekunde = 24 * 60 * 60;
                                $datumTekuciUnix += $sekunde;
                                break;
                            case 'sedmica':
                                $sekunde = 7 * 24 * 60 * 60;
                                $datumTekuciUnix += $sekunde;
                                break;
                            case 'mesec':
                                if ($mesecTekuci == 12)
                                    $godinaTekuca++;
                                $mesecTekuci = ($mesecTekuci + 1) % 12;
                                $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                                break;
                        }
                        //  $km = new KarticaModel();
                        $idKar = $km->dodajKarticu(date('Y-m-d', $datumTekuciUnix), $stanje - $cena, $idKor, $tablice);

                        //racun za izdavanje i prvu dopunu
                        $rm = new RacunModel();
                        $data['datum'] = date('Y-m-d');
                        $data['vreme'] = date('H:i:s');
                        $data['iznos'] = $cena;
                        $data['opis'] = 'izdavanje i pocetna dopuna ' . $period;
                        $idRac1 = $rm->dodajRacun($data);

                        $im = new IzdavanjeModel();
                        $im->dodajIzdavanje($idKar, $idRac1);

                        //racun za uplatu
                        $data['datum'] = date('Y-m-d');
                        $data['vreme'] = date('H:i:s');
                        $data['iznos'] = $stanje;
                        $data['opis'] = 'uplata';
                        $idRac2 = $rm->dodajRacun($data);

                        $um = new UplataModel();
                        $dataUplata['idKartice'] = $idKar;
                        $dataUplata['idRacuna'] = $idRac2;
                        $um->dodajUplatu($dataUplata);

                        return redirect()->to(site_url('Admin/uspehAdmin/1'));
                    }
                }
            }
        }
        $data['naslov'] = 'IZDAVANJE KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('izdavanjeKartice', $data);
    }


    /* 
    obnova kartice registrovanom korisniku
    koristi id kartice i period produzenja
     */
    public function obnovaKarticeSubmit()
    {

        $idKartice = $this->request->getVar('idKartice');
        $period = $this->request->getVar('period');

        $rules['idKartice'] = 'required';
        $messages['idKartice']['required'] = 'UNESITE ID KARTICE.';

        $poruka = '';
        if (!$this->validate($rules, $messages)) {
            if ($this->validator->hasError('idKartice')) $poruka = $this->validator->getError('idKartice');
        } else {
            switch ($period) {
                case 'dan':
                    $cena = CENA_DAN;
                    break;
                case 'sedmica':
                    $cena = CENA_SEDMICA;
                    break;
                case 'mesec':
                    $cena = CENA_MESEC;
                    break;
            }
            $km = new KarticaModel();
            $kartica = $km->dohvatiKarticu($idKartice);
            if ($kartica == null) {
                $poruka = 'KARTICA SA UNETIM ID-JEM NE POSTOJI.';
            } else {

                if ($kartica->stanje == null) {
                    $poruka = 'UNETI ID KARTICE SE ODNOSI NA GOSTA.';
                } else {

                    if ($kartica->stanje < $cena) {
                        $poruka = 'NEMATE DOVOLJNO SREDSTAVA NA IZABRANOJ KARTICI.';
                    } else {
                        // azuriranje stanja na kartici
                        $km->izmeniStanje($idKartice, $kartica->stanje - $cena);
                        // azuriranje datuma vazenja
                        $datumDo = explode('-', $kartica->vaziDo);
                        $danDo = (int) $datumDo[2];
                        $mesecDo = (int) $datumDo[1];
                        $godinaDo = (int) $datumDo[0];
                        $datumDoUnix = mktime(0, 0, 0, $mesecDo, $danDo, $godinaDo);
                        $datumTekuci = explode('-', date('Y-m-d'));
                        $danTekuci = (int) $datumTekuci[2];
                        $mesecTekuci = (int) $datumTekuci[1];
                        $godinaTekuca = (int) $datumTekuci[0];
                        $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                        if ($datumDoUnix > $datumTekuciUnix) {
                            $datum = $datumDoUnix;
                            $dan = $danDo;
                            $mesec = $mesecDo;
                            $godina = $godinaDo;
                        } else {
                            $datum = $datumTekuciUnix;
                            $dan = $danTekuci;
                            $mesec = $mesecTekuci;
                            $godina = $godinaTekuca;
                        }
                        switch ($period) {
                            case 'dan':
                                $sekunde = 24 * 60 * 60;
                                $datum += $sekunde;
                                break;
                            case 'sedmica':
                                $sekunde = 7 * 24 * 60 * 60;
                                $datum += $sekunde;
                                break;
                            case 'mesec':
                                if ($mesec == 12)
                                    $godina++;
                                $mesec = ($mesec + 1) % 12;
                                $datum = mktime(0, 0, 0, $mesec, $dan, $godina);
                                break;
                        }
                        $km->izmeniDatumVazenja($idKartice, date('Y-m-d', $datum));
                        // dodavanje racuna
                        $data['datum'] = date('Y-m-d');
                        $data['vreme'] = date('H:i:s');
                        $data['iznos'] = $cena;
                        $data['opis'] = 'obnova ' . $period;
                        $rm = new RacunModel();
                        $idRacuna = $rm->dodajRacun($data);
                        // dodavanje obnove
                        $om = new ObnovaModel();
                        $data['idRacuna'] = $idRacuna;
                        $data['idKartice'] = $idKartice;
                        $om->dodajObnovu($data);

                        return redirect()->to(site_url('Admin/uspehAdmin/2'));
                    }
                }
            }
        }

        $data['naslov'] = 'OBNOVA KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('obnovaKarticeAdmin', $data);
    }

    public function isplataSaKarticeSubmit()
    {
        //dohvatanje id kartice i validacija unetih podataka
        $idKartice = $this->request->getVar("idKartice");
        $rules['idKartice'] = 'required';
        $messages['idKartice']['required'] = 'UNESITE ID KARTICE.';
        $rules['iznos'] = 'required|decimal|greater_than[0.0]';
        $messages['iznos']['required'] = 'UNESITE IZNOS.';
        $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
        $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';

        $poruka = "";
        if (!$this->validate($rules, $messages)) {
            if ($this->validator->hasError('idKartice')) $poruka = $this->validator->getError('idKartice');
            else if ($this->validator->hasError('iznos')) $poruka = $this->validator->getError('iznos');
        } else {
            //pravljenje modela za prihvatanje podataka iz baze
            $km = new KarticaModel();
            $rm = new RacunModel();
            $im = new IsplataModel();


            $karticaIsplata = $km->dohvatiKarticu($idKartice);
            $iznos = (float) $this->request->getVar('iznos');

            if ($karticaIsplata != null) {
                //ako je pronadjena kartica u bazi onda vrsi dalju proveru

                if ($karticaIsplata->stanje != null) { //u slucaju da je u pitanju kartica gosta ispisi poruku o gresci
                    if ($karticaIsplata->stanje >= $iznos) {
                        //promena stanja u bazi za karticu sa datim ID-em
                        $km->izmeniStanje($idKartice, $karticaIsplata->stanje - $iznos);

                        //izdavanje racuna i upis u bazu tabelu Racun

                        $data['datum'] = date("Y-m-d");
                        $data['vreme'] = date("H:i:s");
                        $data['iznos'] = $iznos;
                        $data['opis'] = "isplata";
                        $idRacuna = $rm->dodajRacun($data);

                        //dodavanje isplate i upis u bazu u tabelu Isplata 
                        $data['idKartice'] = $idKartice;
                        $data['idRacuna'] = $idRacuna;
                        $im->dodajIsplatu($data);
                        return redirect()->to(site_url('Admin/uspehAdmin/4'));
                    } else
                        $poruka = "NA KARTICI NEMA DOVOLJNO SREDSTAVA. POKUŠAJTE ISPLATU MANJE SUME.";
                } else
                    $poruka = "KARTICA SA UNETIM ID-JEM PRIPADA GOSTU I NE MOŽE SE IZVRŠITI ISPLATA.";
            } else
                $poruka = "KARTICA SA UNETIM ID-JEM NE POSTOJI U BAZI.";
        }
        $data['vrednost'] = $idKartice;
        $data['naslov'] = 'ISPLATA';
        $data['poruka'] = $poruka;
        $this->prikazi('isplata', $data);
    }

    public function uplataNaKarticuSubmit()
    {
        //dohvatanje id kartice i validacija unetih podataka
        $idKartice = $this->request->getVar('idKartice');
        $rules['idKartice'] = 'required';
        $messages['idKartice']['required'] = 'UNESITE ID KARTICE.';
        $rules['iznos'] = 'required|decimal|greater_than[0.0]';
        $messages['iznos']['required'] = 'UNESITE IZNOS.';
        $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
        $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';

        $poruka = "";
        if (!$this->validate($rules, $messages)) {
            if ($this->validator->hasError('idKartice')) $poruka = $this->validator->getError('idKartice');
            else if ($this->validator->hasError('iznos')) $poruka = $this->validator->getError('iznos');
        } else {
            //pravljenje modela za prihvatanje podataka iz baze
            $km = new KarticaModel();
            $rm = new RacunModel();
            $um = new UplataModel();

            $karticaUplata = $km->dohvatiKarticu($idKartice);
            $iznos = (float) $this->request->getVar('iznos');
            //azuriranje stanja na kartici
            if ($karticaUplata != null) {
                //ako je pronadjena kartica u bazi onda vrsi dalju proveru

                if ($karticaUplata->stanje != null) {
                    // u slucaju da je u pitanju gost kolona stanje u odgovarajucoj tabeli ima vrednost null

                    $km->izmeniStanje($idKartice, $karticaUplata->stanje + $iznos);
                    //izdavanje racuna i upis u tabelu
                    $data['datum'] = date("Y-m-d");
                    $data['vreme'] = date("H:i:s");
                    $data['iznos'] = $iznos;
                    $data['opis'] = "uplata";
                    $idRacuna = $rm->dodajRacun($data);

                    //dodavanje uplate i upis u bazu u tabelu uplata 
                    $data['idKartice'] = $idKartice;
                    $data['idRacuna'] = $idRacuna;
                    $um->dodajUplatu($data);
                    return redirect()->to(site_url('Admin/uspehAdmin/3'));
                } else {
                    $poruka = "KARTICA SA UNETIM ID-JEM PRIPADA GOSTU I NE MOZE SE IZVRSITI UPLATA.";
                }
            } else {
                $poruka = "KARTICA SA UNETIM ID-JEM NE POSTOJI U BAZI.";
            }
        }
        $data['vrednost'] = $idKartice;
        $data['naslov'] = 'UPLATA';
        $data['poruka'] = $poruka;
        $this->prikazi('uplata', $data);
    }


    /* 
    gubitak kartice gosta ili registrovanog korisnika
    koristi tablice i email (za registrovanog korisnika)
    */
    public function gubitakKarticeSubmit()
    {
        $email = $this->request->getVar('email');
        $tablice = $this->request->getVar('tablice');
        //  $rules['email'] = 'required';
        //$messages['email']['required'] = 'UNESITE EMAIL.'; 
        $rules['tablice'] = 'required';
        $messages['tablice']['required'] = 'UNESITE TABLICE.';
        $poruka = '';
        if (!$this->validate($rules, $messages)) {
            //  if($this->validator->hasError('email')) $poruka = $this->validator->getError ('email');
            if ($this->validator->hasError('tablice'))
                $poruka = $this->validator->getError('tablice');
        } else {

            if ($email != null) {  //registrovani

                $rm = new RegistrovaniModel();
                $kor = $rm->dohvatiKorisnika($email);

                if ($kor == null) {
                    $poruka = 'NE POSTOJI KORISNIK SA UNETIM EMAIL-OM.';
                } else {
                    $idKor = $kor->idKorisnika;
                    $km = new KarticaModel();
                    $kartica = $km->nadjiKarticu($tablice, $idKor);
                    if ($kartica == null) {
                        $poruka = 'NE POSTOJI KARTICA ZA UNETE PODATKE.';
                    } else {

                        $idKartice = $kartica->idKartice;

                        $boravakM = new BoravakModel();
                        $boravak = $boravakM->dohvatiBoravak($idKartice);
                        $cena = 0;
                        if ($boravak == null) {
                            $data['poruka0'] = "KORISNIK NIJE PARKIRAN!";
                            $poruka0 = "KORISNIK NIJE PARKIRAN!";
                        } else {
                            $data['poruka0'] = 'Korisnik izasao iz garaze';
                            $poruka0 = 'Korisnik izasao iz garaze';
                            $kaznaM = new KaznaModel();
                            $kazne = $kaznaM->dohvatiKazne($boravak->idBoravka);


                            foreach ($kazne as $kazna) {
                                $cena += $kazna->iznos;
                            }

                            $data['cena'] = $cena;


                            if ($cena > 0) {
                                $data['datum'] = date('Y-m-d');
                                $data['vreme'] = date('H:i:s');
                                $data['iznos'] = $cena;
                                $data['opis'] = "placanje izlaska";
                                $rm = new RacunModel();
                                $idRacuna = $rm->dodajRacun($data);
                                $boravakM->updateRacun($boravak->idBoravka, $idRacuna);
                            }
                            $boravakM->izlazak($boravak->idBoravka);
                            //return redirect()->to(site_url("Operater/uspehOperater/3/$cena"));
                        }

                        $preostaliNovac = $kartica->stanje;
                        if ($preostaliNovac > 0) {
                            $data['datum'] = date('Y-m-d');
                            $data['vreme'] = date('H:i:s');
                            $data['iznos'] = $preostaliNovac;
                            $data['opis'] = 'isplata zbog gubitka';
                            $rm = new RacunModel();
                            $idRacuna = $rm->dodajRacun($data);
                            $im = new IsplataModel();
                            $data['idKartice'] = $kartica->idKartice;
                            $data['idRacuna'] = $idRacuna;
                            $im->dodajIsplatu($data);

                            //$im->dodajIsplatu($kartica->idKartice,$idRacuna); //bolje je da se data sklapa u samom modelu, a ne ovde
                        }

                        $km->obrisi($kartica);

                        // $preostaliNovac = -$cena;

                        //$this->uspehAdmin(5, $poruka);
                        return redirect()->to(site_url("Admin/uspehAdmin/5/$preostaliNovac/$cena"));
                    }
                }
            } else {  //gost
                $mk = new KarticaModel();
                $kartice = $mk->nadjiKarticuTablice($tablice);
                if ($kartice) {

                    $bm = new \App\Models\BoravakModel();
                    $karticaUnutra = null;
                    // $boravak;

                    foreach ($kartice as $kartica) {

                        if ($bm->dohvatiBoravak($kartica->idKartice)) {
                            $karticaUnutra = $kartica;
                            break;
                        }
                    }

                    if ($karticaUnutra) {

                        if ($karticaUnutra->stanje != null) { //gost sigurno

                            $boravak = $bm->dohvatiBoravak($karticaUnutra->idKartice);

                            //vreme provedeno + kazne
                            $datumUl = $boravak->datumUlaska;
                            $datumUl = explode('-', $datumUl);
                            $vremeUl = $boravak->vremeUlaska;
                            $vremeUl = explode(':', $vremeUl);

                            $danUl = (int) $datumUl[2];
                            $mesUl = (int) $datumUl[1];
                            $godUl = (int) $datumUl[0];

                            $satUl = (int) $vremeUl[0];
                            $minUl = (int) $vremeUl[1];
                            $sekUl = (int) $vremeUl[2];

                            $vremeUl = mktime($satUl, $minUl, $sekUl, $mesUl, $danUl, $godUl);
                            $vremeIzl = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));
                            $brsati = round(($vremeIzl - $vremeUl) / 3600);
                           
                            $brsati++;

                            $cena = $brsati * 60; //60din sat
                            $data['cena'] = $cena;

                            //cena se sabira sa kaznama ako ih ima
                            $kaznaM = new KaznaModel();
                            $kazne = $kaznaM->dohvatiKazne($boravak->idBoravka);

                            foreach ($kazne as $kazna) {
                                $cena += $kazna->iznos;
                            }

                            $km = new KarticaModel();
                            $bm->izlazak($boravak->idBoravka);
                            $km->obrisi($karticaUnutra);

                            $preostaliNovac = 0;
                            return redirect()->to(site_url("Admin/uspehAdmin/5/$preostaliNovac/$cena"));
                        } else {
                            $poruka = 'KARTICA SE ODNOSI NA REGISTROVANOG KORISNIKA. UNESITE MAIL';
                        }
                    } else {


                        $poruka = "AUTOMOBIL SA UNETIM TABLICAMA NIJE U GARAŽI.";
                    }
                } else {
                    $poruka = "NE POSTOJI KARTICA ZA UNETE TABLICE.";
                }
            }
        }

        $data['naslov'] = 'GUBITAK KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('gubitakKartice', $data);
    }

    public function uspehAdmin($id, $preostaliNovac = null, $cena = null)
    {
        $poruka = null;
        switch ($id) {

            case '1':
                $naslov = 'IZDAVANJE KARTICE - USPEH';
                break;
            case '2':
                $naslov = 'OBNOVA KARTICE - USPEH';
                break;
            case '3':
                $naslov = 'UPLATA - USPEH';
                break;
            case '4':
                $naslov = 'ISPLATA - USPEH';
                break;
            case '5':
                $naslov = 'GUBITAK KARTICE - USPEH';

                $poruka = 'Novac za uplatu: ' . $cena . ' DIN<br/>' . ' Novac za isplatu: ' . $preostaliNovac . ' DIN';


                break;
        }

        $data['naslov'] = $naslov;
        $data['poruka'] = $poruka;
        $this->prikazi('uspehAdmin', $data);
    }

    //--------------------------------------------------------------------
}
