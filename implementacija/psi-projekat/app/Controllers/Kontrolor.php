<?php

namespace App\Controllers;

use App\Models\BoravakModel;
use App\Models\KarticaModel;
use App\Models\KaznaModel;

class Kontrolor extends Korisnik {

    public function prikazi($page, $data) {
        echo view('sabloni/header_kontrolor', $data);
        if ($page != '')
            echo view("stranice/$page", $data);
        echo view('sabloni/footer_kontrolor', $data);
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

    public function kazna() {
        $data['naslov'] = 'KAZNA';
        $this->prikazi('kazna', $data);
    }

    public function provera() {
        $data['naslov'] = 'PROVERA';
        $this->prikazi('provera', $data);
    }

    public function proveraAutomobila() {
        //dohvatanje i provera unetih podataka
        $tablice = $this->request->getVar('tablice');
        $rules['tablice'] = 'required';
        $messages['tablice']['required'] = "UNESITE REGISTARSKI BROJ TABLICA.";
        $poruka = "";
        $boravak = null;
        if (!$this->validate($rules, $messages)) {
            $poruka = $this->validator->getError('tablice');
        } else {
            $pm = new BoravakModel();
            $km = new KarticaModel();

            //dohvatanje svih kartica koje imaju veze sa unetim tablicama
            $kartice = $km->nadjiKarticuTablice($tablice);
            if ($kartice != null) {
                //iteriranje i dohvatanje boravka cije je vreme izlaska null za karticu sa zadatim tablicama
                foreach ($kartice as $key) {
                    $boravak = $pm->dohvatiUlazBezIzlaza($key->idKartice);
                    if ($boravak != null) {
                        $kartica = $km->dohvatiKarticu($key->idKartice);

                        //pravljenje poruke za ispis kontroloru
                        $_SESSION['poruka'] = "ID kartice: {$boravak->idKartice}<br/>";
                        $_SESSION['poruka'] .= "Datum i vreme ulaska: {$boravak->datumUlaska}" . " " . "{$boravak->vremeUlaska}<br/>";
                        if ($boravak->datumIzlaska && $boravak->vremeIzlaska) {
                            $_SESSION['poruka'] .= "Datum i vreme izlaska: {$boravak->datumIzlaska}" . " " . "{$boravak->vremeIzlaska}<br/>";
                        } else {
                            $_SESSION['poruka'] .= "Datum i vreme izlaska: Automobil se nalazi u garazi<br/>";
                        }

                        if ($kartica->stanje != null) {

                            $_SESSION['poruka'] .= "Trajanje kartice: {$kartica->vaziDo}<br/><br/>";

                            //tekuci datum
                            $datumTekuci = explode('-', date('Y-m-d'));
                            $danTekuci = (int) $datumTekuci[2];
                            $mesecTekuci = (int) $datumTekuci[1];
                            $godinaTekuca = (int) $datumTekuci[0];
                            $datumTekuciUnix = mktime(0, 0, 0, $mesecTekuci, $danTekuci, $godinaTekuca);
                            //datum vazenja kartice
                            $datumVazenja = explode('-', $kartica->vaziDo);
                            $danVazenja = (int) $datumVazenja[2];
                            $mesecVazenja = (int) $datumVazenja[1];
                            $godinaVazenja = (int) $datumVazenja[0];
                            $datumVazenjaUnix = mktime(0, 0, 0, $mesecVazenja, $danVazenja, $godinaVazenja);

                            if ($datumVazenjaUnix < $datumTekuciUnix) {
                                //izvrsi kaznu ako je nevalidna kartica
                                $this->kazniNevalidnog($boravak);
                                $_SESSION['poruka'] .= "KORISNIK JE KAZNJEN ZBOG ISTEKA VALIDNOSTI KARTICE.<br/>";
                            } else {
                                $_SESSION['poruka'] .= "KORISNIK IMA VALIDNU KARTICU.<br/>";
                            }
                        } else {
                            $_SESSION['poruka'] .= "Trajanje kartice: Kartica je izdata gostu<br/>";
                        }

                        return redirect()->to(site_url("Kontrolor/uspehKontrolor/1"));
                    }
                }
                $poruka = "Automobil registarski oznaka {$tablice} nije evidentiran da trenutno boravi u garaži.";
            } else {
                $poruka = "Automobil registarski oznaka {$tablice} ne postoji.";
            }
        }
        $data['naslov'] = 'PROVERA';
        $data['poruka'] = $poruka;
        $this->prikazi('provera', $data);
    }

    public function evidentirajKaznu() {
        //dohvatanje i provera unetih podataka
        $tablice = $this->request->getVar('tablice');
        $tipKazne = $this->request->getVar('tipPrekrsaja');
        $rules['tablice'] = 'required';
        $messages['tablice']['required'] = "UNESITE REGISTARSKI BROJ TABLICA.";
        switch ($tipKazne) {
            case 'prva': $iznos = 1200;
                $tip = "PARKIRANJE NA MESTU ZA INVALIDE.";
                break;
            case 'druga': $iznos = 1500;
                $tip = "PARKIRANJE NA MESTU ZA TRUDNICE.";
                break;
            case 'treca': $iznos = 2000;
                $tip = "ZAUZIMANJE VISE MESTA";
                break;
        }

        $poruka = "";
        $boravak = null;
        if (!$this->validate($rules, $messages)) {
            $poruka = $this->validator->getError('tablice');
        } else {
            $pm = new BoravakModel();
            $km = new KarticaModel();
            $kaznaModel = new KaznaModel();

            //dohvatanje svih kartica za date tablice 
            $kartice = $km->nadjiKarticuTablice($tablice);
            if ($kartice != null) {
                foreach ($kartice as $key) {
                    /* pronalazak boravka cije je vreme izlaska null na osnovu kartice za date tablice
                     * jer se moze samo kazniti vozilo koje trenutno boravi na parkingu */
                    $boravak = $pm->dohvatiUlazBezIzlaza($key->idKartice);
                    if ($boravak != null) {
                        //evidentiranje kazne 
                        $data['idBoravka'] = $boravak->idBoravka;
                        $data['tipPrekrsaja'] = $tip;
                        $data['iznos'] = $iznos;
                        $kaznaModel->dodajKaznu($data);
                        return redirect()->to(site_url("Kontrolor/uspehKontrolor/2"));
                    }
                }
                $poruka = "Automobil registarskih oznaka {$tablice} nije evidentiran da trenutno boravi u garaži.";
            } else {
                $poruka = "Automobil registarskih oznaka {$tablice} ne postoji.";
            }
        }

        $data['naslov'] = 'KAZNA';
        $data['poruka'] = $poruka;
        $this->prikazi('kazna', $data);
    }

    public function kazniNevalidnog($boravak) {
        /* U slucaju da je registrovan korisnik trenutno parkiran sa nevalidnom karticom
         * evidentirace mu se odgovarajuca kazna */
        $kaznaModel = new KaznaModel();
        $data['idBoravka'] = $boravak->idBoravka;
        $data['tipPrekrsaja'] = "PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.";
        $data['iznos'] = 1500;
        $kaznaModel->dodajKaznu($data);
    }

    public function uspehKontrolor($id) {
        $poruka = null;
        switch ($id) {

            case '1': $naslov = 'PROVERA - USPEH';
                break;
            case '2': $naslov = 'KAZNA - USPEH';
                break;
        }

        $data['naslov'] = $naslov;
        $data['poruka'] = $poruka;
        $this->prikazi('uspehKontrolor', $data);
    }

    //--------------------------------------------------------------------
}
