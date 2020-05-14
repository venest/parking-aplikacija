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

class Admin extends BaseController {

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

    public function izlogujSe() {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('Gost/logovanje'));
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

    public function pocetna() {
        $data['naslov'] = 'POČETNA';
        $this->prikazi('pocetna', $data);
    }

    public function tipoviKorisnika() {
        $data['naslov'] = 'TIPOVI KORISNIKA';
        $this->prikazi('tipoviKorisnika', $data);
    }

    public function cenovnik() {
        $data['naslov'] = 'CENOVNIK';
        $this->prikazi('cenovnik', $data);
    }

    public function kontakt() {
        $data['naslov'] = 'KONTAKT';
        $this->prikazi('kontakt', $data);
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
                                        $idKar =$km->dodajKarticu(date('Y-m-d', $datumTekuciUnix), $stanje-$cena, $idKor, $tablice);

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
