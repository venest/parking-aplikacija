<?php

namespace App\Controllers;

use App\Models\RegistrovaniModel;
use App\Models\KarticaModel;
use App\Models\RacunModel;
use App\Models\UplataModel;
use App\Models\IsplataModel;
use App\Models\ObnovaModel;
use App\Models\IzdavanjeModel;

define('CENA_DAN', 200);
define('CENA_SEDMICA', 800);
define('CENA_MESEC', 2000);
define('CENA_IZDAVANJE', 1000);


date_default_timezone_set('Europe/Belgrade');

class Admin extends Korisnik {

    public function prikazi($page, $data) {
        echo view('sabloni/header_admin', $data);
        if ($page != '')
            echo view("stranice/$page", $data);
        echo view('sabloni/footer_admin', $data);
    }

    public function index() {
        $data['naslov'] = 'KONTROLNA TABLA';
        $this->prikazi('', $data);
    }

    public function kontrolnaTabla() {
        $data['naslov'] = 'KONTROLNA TABLA';
        $this->prikazi('', $data);
    }

    public function odjaviSe() {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('Gost/prijava'));
    }

    public function uplata() {
        $data['naslov'] = 'UPLATA';
        $this->prikazi('uplata', $data);
    }

    public function isplata() {
        $data['naslov'] = 'ISPLATA';
        $this->prikazi('isplata', $data);
    }

    public function gubitakKartice() {
        $data['naslov'] = 'GUBITAK KARTICE';
        $this->prikazi('gubitakKartice', $data);
    }

    public function izdavanjeKartice() {
        $data['naslov'] = 'IZDAVANJE KARTICE';
        $this->prikazi('izdavanjeKartice', $data);
    }

    public function obnovaKartice() {
        $data['naslov'] = 'OBNOVA KARTICE';
        $this->prikazi('obnovaKarticeOperater', $data);
    }

    public function izdavanjeKarticeSubmit() {
        
            $email = $this->request->getVar('email');
            $tablice = $this->request->getVar('tablice');
            $stanje=$this->request->getVar('iznos');
            $period = $this->request->getVar('period');
        
            $rules['email'] = 'required';
            $messages['email']['required'] = 'UNESITE EMAIL.';
            $rules['tablice'] = 'required';
            $messages['tablice']['required'] = 'UNESITE TABLICE.';
            $rules['iznos'] = 'required|decimal|greater_than[0.0]';
            $messages['iznos']['required'] = 'UNESITE IZNOS.';
            $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
            $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';
              if(!$this->validate($rules, $messages)) {
                if($this->validator->hasError('email')) $poruka = $this->validator->getError ('email');
                else if($this->validator->hasError('tablice')) $poruka = $this->validator->getError ('tablice');
                else if($this->validator->hasError('iznos')) $poruka = $this->validator->getError ('iznos');
              } else {
                
                $rm = new RegistrovaniModel();
                $kor = $rm->dohvatiKorisnika($email);
                
                if ($kor==null){
                    $poruka = 'NE POSTOJI KORISNIK SA UNETIM EMAIL-OM.';
                } else {
                               $idKor=$kor->idKorisnika;
                                switch ($period) {
                                case 'dan': $cena = CENA_DAN;
                                    break;
                                case 'sedmica': $cena = CENA_SEDMICA;
                                    break;
                                case 'mesec': $cena = CENA_MESEC;
                                    break;
                            }
                            $cena += CENA_IZDAVANJE;

                            if($stanje < $cena) {
                                    $poruka = 'NEMA DOVOLJNO SREDSTAVA ZA ŽELJENE OPCIJE.';
                                } else {
                                        $datumTekuci = explode('-', date('Y-m-d'));
                                        $danTekuci = (int) $datumTekuci[2];
                                        $mesecTekuci = (int) $datumTekuci[1];
                                        $godinaTekuca = (int) $datumTekuci[0];
                                        $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                                        switch ($period) {
                                            case 'dan': $sekunde = 24 * 60 * 60;
                                                $datumTekuciUnix += $sekunde;
                                                break;
                                            case 'sedmica': $sekunde = 7 * 24 * 60 * 60;
                                                $datumTekuciUnix += $sekunde;
                                                break;
                                            case 'mesec':
                                                if ($mesecTekuci == 12)
                                                    $godinaTekuca++;
                                                $mesecTekuci = ($mesecTekuci + 1) % 12;
                                                $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                                                break;
                                        }
                                        $km = new KarticaModel();
                                        $idKar = $km->dodajKarticu(date('Y-m-d', $datumTekuciUnix), $stanje-$cena, $idKor, $tablice);

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

                                         $um=new UplataModel();
                                         $dataUplata['idKartice']=$idKar; 
                                         $dataUplata['idRacuna']=$idRac2;
                                         $um->dodajUplatu($dataUplata);
           
                                         return redirect()->to(site_url('Admin/uspehAdmin/1'));
            }
            }
            }
        $data['naslov'] = 'IZDAVANJE KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('izdavanjeKartice', $data);
    }

    public function obnovaKarticeSubmit() {

        $idKartice = $this->request->getVar('idKartice');
        $period = $this->request->getVar('period');


        switch ($period) {
            case 'dan': $cena = CENA_DAN;
                break;
            case 'sedmica': $cena = CENA_SEDMICA;
                break;
            case 'mesec': $cena = CENA_MESEC;
                break;
        }
        $km = new KarticaModel();
        $kartica = $km->dohvatiKarticu($idKartice);
        $poruka = '';
        //if($kartica==null)
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
                case 'dan': $sekunde = 24 * 60 * 60;
                    $datum += $sekunde;
                    break;
                case 'sedmica': $sekunde = 7 * 24 * 60 * 60;
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

        $data['naslov'] = 'OBNOVA KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('obnovaKarticeOperater', $data);
    }

    public function gubitakKarticeSubmit() {
          $email = $this->request->getVar('email');
          $tablice = $this->request->getVar('tablice');
          $rules['email'] = 'required';
          $messages['email']['required'] = 'UNESITE EMAIL.';
          $rules['tablice'] = 'required';
          $messages['tablice']['required'] = 'UNESITE TABLICE.';
          $poruka='';
           if(!$this->validate($rules, $messages)) {
                if($this->validator->hasError('email')) $poruka = $this->validator->getError ('email');
                else if($this->validator->hasError('tablice')) $poruka = $this->validator->getError ('tablice');
           } else{
                $rm = new RegistrovaniModel();
                $kor = $rm->dohvatiKorisnika($email);
          
                if ($kor==null){
                    $poruka = 'NE POSTOJI KORISNIK SA UNETIM EMAIL-OM.';
                } else {
                     $idKor=$kor->idKorisnika;
                    $km=new KarticaModel();
                    $kartica=$km->nadjiKarticu($tablice, $idKor);
                    if ($kartica==null){
                        $poruka='NE POSTOJI KARTICA ZA UNETE PODATKE.';
                    } else{
                      $preostaliNovac=$kartica->stanje;
                      if($preostaliNovac>0){
                       $data['datum'] = date('Y-m-d');
                       $data['vreme'] = date('H:i:s');
                       $data['iznos'] = $preostaliNovac;
                       $data['opis'] = 'isplata zbog gubitka';
                       $rm = new RacunModel();
                      $idRacuna = $rm->dodajRacun($data);
                      $im=new IsplataModel();
                      $data['idKartice']=$kartica->idKartice;
                      $data['idRacuna']=$idRacuna;
                      $im->dodajIsplatu($data);
                     //$im->dodajIsplatu($kartica->idKartice,$idRacuna); //bolje je da se data sklapa u samom modelu, a ne ovde
                      }
                      
                      $km->obrisi($kartica); //bolje bi bilo da se status postavi na izgubljena
                      
                      //$this->uspehAdmin(5, $poruka);
                      return redirect()->to(site_url("Admin/uspehAdmin/5/$preostaliNovac"));
                    }
                }
           }
           
        $data['naslov'] = 'GUBITAK KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('gubitakKartice', $data);
        
          
    }
    
    public function isplataSaKarticeSubmit() {
        //dohvatanje id kartice i validacija unetih podataka
        $idKartice = $this->request->getVar("idKartice");
        $rules['iznos'] = 'required|decimal|greater_than[0.0]';
        $messages['iznos']['required'] = 'UNESITE IZNOS';
        $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS';
        $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN';

        $poruka = "";
        if (!$this->validate($rules, $messages)) {
            $poruka = $this->validator->getError('iznos');
        } else {
            //pravljenje modela za prihvatanje podataka iz baze
            $km = new KarticaModel();
            $rm = new RacunModel();
            $im = new IsplataModel();


            $karticaIsplata = $km->dohvatiKarticu($idKartice);
            $iznos = (double) $this->request->getVar('iznos');

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
                        $data['opis'] = "Isplata sa kartice";
                        $idRacuna = $rm->dodajRacun($data);

                        //dodavanje isplate i upis u bazu u tabelu Isplata 
                        $data['idKartice'] = $idKartice;
                        $data['idRacuna'] = $idRacuna;
                        $im->dodajIsplatu($data);
                        return redirect()->to(site_url('Admin/uspehAdmin/4'));
                    } else
                        $poruka = "NA KARTICI NEMA DOVOLJNO SREDSTAVA. POKUSAJTE ISPLATU MANJE SUME.";
                } else
                    $poruka = "KARTICA SA DATIM ID PRIPADA GOSTU I NE MOZE SE IZVRSITI ISPLATA";
            } else
                $poruka = "KARTICA SA DATIM ID NE POSTOJI U BAZI.";
        }
        $session = session();
        $data['vrednost']=$idKartice;
        $data['naslov'] = 'ISPLATA SREDSTAVA SA KARTICE';
        $data['poruka'] = $poruka;
        $this->prikazi('isplata', $data);
    }
    
    public function uplataNaKarticuSubmit() {
        //dohvatanje id kartice i validacija unetih podataka
        $idKartice = $this->request->getVar('idKartice');
        $rules['iznos'] = 'required|decimal|greater_than[0.0]';
        $messages['iznos']['required'] = 'UNESITE IZNOS.';
        $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
        $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';

        $poruka = "";
        if (!$this->validate($rules, $messages)) {
            $poruka = $this->validator->getError('iznos');
        } else {
            //pravljenje modela za prihvatanje podataka iz baze
            $km = new KarticaModel();
            $rm = new RacunModel();
            $um = new UplataModel();

            $karticaUplata = $km->dohvatiKarticu($idKartice);
            $iznos = (double) $this->request->getVar('iznos');
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
                    $data['opis'] = "Uplata na karticu";
                    $idRacuna = $rm->dodajRacun($data);

                    //dodavanje uplate i upis u bazu u tabelu uplata 
                    $data['idKartice'] = $idKartice;
                    $data['idRacuna'] = $idRacuna;
                    $um->dodajUplatu($data);
                    return redirect()->to(site_url('Admin/uspehAdmin/3'));
                } else {
                    $poruka = "KARTICA SA DATIM ID PRIPADA GOSTU I NE MOZE SE IZVRSITI UPLATA";
                }
            } else {
                $poruka = "KARTICA SA DATIM ID NE POSTOJI U BAZI";
            }
        }
        $session = session();
        $data['vrednost']=$idKartice;
        $data['naslov'] = 'UPLATA SREDSTAVA NA KARTICU';
        $data['poruka'] = $poruka;
        $this->prikazi('uplata', $data);
    }

    public function uspehAdmin($id,$preostaliNovac=null) {
        $poruka=null;
        switch ($id) {

            case '1': $naslov = 'IZDAVANJE KARTICE - USPEH';
                break;
            case '2': $naslov = 'OBNOVA KARTICE - USPEH';
                break;
            case '3': $naslov = 'UPLATA - USPEH';
                break;
            case '4': $naslov = 'ISPLATA - USPEH';
                break;
            case '5': $naslov = 'GUBITAK KARTICE - USPEH';
                $poruka='Novac za isplatu: '.$preostaliNovac.' DIN';
                break;
        }
        
        $data['naslov'] = $naslov;
        $data['poruka']=$poruka;
        $this->prikazi('uspehAdmin', $data);
    }

    //--------------------------------------------------------------------
}
