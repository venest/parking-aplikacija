<?php namespace App\Controllers;

use App\Models\RegistrovaniModel;
use App\Models\KarticaModel;
use App\Models\RacunModel;
use App\Models\UplataModel;
use App\Models\IsplataModel;
use App\Models\ObnovaModel;

define('CENA_DAN', 200);
define('CENA_SEDMICA', 800);
define('CENA_MESEC', 2000);

date_default_timezone_set('Europe/Belgrade');

class Registrovani extends BaseController
{
    
        public function prikazi($page, $data) {
            echo view('sabloni/header_registrovani', $data);
            if($page != '') echo view("stranice/$page", $data);
            echo view('sabloni/footer_registrovani', $data);
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
        
        public function izlogujSe() {
            $session = session();
            $session->destroy();
            return redirect()->to(site_url('Gost/logovanje'));
        }
       
        
        public function promenaLozinke()
	{
                $data['naslov'] = 'PROMENA LOZINKE';
		$this->prikazi('promenaLozinke', $data);
	}
        
        public function kartice()
	{
                $session = session();
                $email = $session->get('korisnickoIme');
                $rm = new RegistrovaniModel();
                $km = new KarticaModel();
                $idKorisnika = $rm->dohvatiKorisnika($email)->idKorisnika;
                $data['naslov'] = 'KARTICE';
                $data['kartice'] = $km->dohvatiSveKartice($idKorisnika);
		$this->prikazi('kartice', $data);
	}
        
        public function obnovaKartice()
	{
                $session = session();
                $email = $session->get('korisnickoIme');
                $rm = new RegistrovaniModel();
                $km = new KarticaModel();
                $idKorisnika = $rm->dohvatiKorisnika($email)->idKorisnika;
                $data['naslov'] = 'OBNOVA KARTICE';
                $data['kartice'] = $km->dohvatiSveKartice($idKorisnika);
		$this->prikazi('obnovaKartice', $data);
	}
        
        public function transfer()
	{
                $data['naslov'] = 'TRANSFER';
                $session = session();
                $email = $session->get('korisnickoIme');
                $rm = new RegistrovaniModel();
                $km = new KarticaModel();
                $idKorisnika = $rm->dohvatiKorisnika($email)->idKorisnika;
                $data['kartice'] = $km->dohvatiSveKartice($idKorisnika);
		$this->prikazi('transfer', $data);
	}
        
        public function pocetna()
	{
                $data['naslov'] = 'POČETNA';
		$this->prikazi('pocetna', $data);
	}
        
        public function tipoviKorisnika()
	{
                $data['naslov'] = 'TIPOVI KORISNIKA';
		$this->prikazi('tipoviKorisnika', $data);
	}
        
        public function cenovnik()
	{
                $data['naslov'] = 'CENOVNIK';
		$this->prikazi('cenovnik', $data);
	}
        
        public function kontakt()
	{
                $data['naslov'] = 'KONTAKT';
		$this->prikazi('kontakt', $data);
	}
        
        public function promenaLozinkeSubmit() {
            $session = session();
            $email = $session->get('korisnickoIme');
            $rm = new RegistrovaniModel();
            $korisnik = $rm->dohvatiKorisnika($email);
            $lozinka = $korisnik->lozinka;
            $rules['staraLozinka'] = 'required';
            $rules['novaLozinka'] = 'required|min_length[7]';
            $messages['staraLozinka']['required'] = 'UNESITE STARU LOZINKU.';
            $messages['novaLozinka']['required'] = 'UNESITE NOVU LOZINKU.';
            $messages['novaLozinka']['min_length'] = 'NOVA LOZINKA MORA SADRŽATI BAR 7 ZNAKOVA.';
            $poruka = '';
            $this->validate($rules, $messages);
            if($this->validator->hasError('staraLozinka')) {
                $poruka = $this->validator->getError('staraLozinka');
            } else if($this->request->getVar('staraLozinka') == $lozinka) {
                if($this->validator->hasError('novaLozinka')) {
                    $poruka = $this->validator->getError('novaLozinka');
                } else if($this->request->getVar('novaLozinka') == $this->request->getVar('novaLozinkaPonovo')) {
                    $session->set('lozinka', $this->request->getVar('novaLozinka'));
                    $rm->izmeniLozinku($email, $this->request->getVar('novaLozinka'));
                    
                    return redirect()->to(site_url("Registrovani/uspehRegistrovani/2"));
                    
                } else $poruka = 'POTVRDA NOVE LOZINKE NIJE USPELA.';
            } else $poruka = 'STARA LOZINKA NIJE KOREKTNA.';
            $data['naslov'] = 'PROMENA LOZINKE';
            $data['poruka'] = $poruka;
            $this->prikazi('promenaLozinke', $data);
        }
        
        public function transferSubmit() {
            $idSa = (int) $this->request->getVar('idKarticeSa');
            $idNa = (int) $this->request->getVar('idKarticeNa');
            $rules['iznos'] = 'required|decimal|greater_than[0.0]';
            $messages['iznos']['required'] = 'UNESITE IZNOS.';
            $messages['iznos']['decimal'] = 'NEKOREKTAN UNOS ZA IZNOS.';
            $messages['iznos']['greater_than'] = 'IZNOS MORA BITI POZITIVAN.';
            $poruka = '';
            if(!$this->validate($rules, $messages)) {
                $poruka = $this->validator->getError('iznos');
            } else if($idSa != $idNa) {
                $km = new KarticaModel();
                $rm = new RacunModel();
                $um = new UplataModel();
                $im = new IsplataModel();
                $karticaSa = $km->dohvatiKarticu($idSa);
                $karticaNa = $km->dohvatiKarticu($idNa);
                $iznos = (double) $this->request->getVar('iznos');
                if($karticaSa->stanje >= $iznos) {
                    // azuriranje stanja na karticama
                    $km->izmeniStanje($idSa, $karticaSa->stanje - $iznos);
                    $km->izmeniStanje($idNa, $karticaNa->stanje + $iznos);
                    // dodavanje racuna
                    $data['datum'] = date('Y-m-d');
                    $data['vreme'] = date('H:i:s');
                    $data['iznos'] = $iznos;
                    $data['opis'] = 'transfer';
                    $idRacuna = $rm->dodajRacun($data);
                    // dodavanje uplate
                    $data['idKartice'] = $idNa;
                    $data['idRacuna'] = $idRacuna;
                    $um->dodajUplatu($data);
                    // dodavanje isplate
                    $data['idKartice'] = $idSa;
                    $data['idRacuna'] = $idRacuna;
                    $im->dodajIsplatu($data);
                    
                    return redirect()->to(site_url('Registrovani/uspehRegistrovani/4'));
                    
                } else $poruka = 'NEMATE DOVOLJNO SREDSTAVA ZA OZNAČENI TRANSFER.';
            } else $poruka = 'KARTICA SA I KARTICA NA MORAJU BITI RAZLIČITE.';
            $session = session();
            $email = $session->get('korisnickoIme');
            $rm = new RegistrovaniModel();
            $km = new KarticaModel();
            $idKorisnika = $rm->dohvatiKorisnika($email)->idKorisnika;
            $data['kartice'] = $km->dohvatiSveKartice($idKorisnika);
            $data['naslov'] = 'TRANSFER';
            $data['poruka'] = $poruka;
            $this->prikazi('transfer', $data);
        }
        
        public function obnovaKarticeSubmit() {
            $idKartice = (int) $this->request->getVar('idKartice');
            $period = $this->request->getVar('period');
            switch ($period) {
                case 'dan': $cena = CENA_DAN; break;
                case 'sedmica': $cena = CENA_SEDMICA; break;
                case 'mesec': $cena = CENA_MESEC; break;
            } 
            $km = new KarticaModel();
            $kartica = $km->dohvatiKarticu($idKartice);
            $poruka = '';
            if($kartica->stanje < $cena) {
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
                if($datumDoUnix > $datumTekuciUnix) {
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
                    case 'dan': $sekunde = 24 * 60 * 60;  $datum += $sekunde; break;
                    case 'sedmica': $sekunde = 7 * 24 * 60 * 60;  $datum += $sekunde; break;
                    case 'mesec':
                        if($mesec == 12) $godina++;
                        $mesec = ($mesec + 1) % 12;
                        $datum = mktime(0, 0, 0, $mesec, $dan, $godina);
                        break;
                }
                $km->izmeniDatumVazenja($idKartice, date('Y-m-d', $datum));
                // dodavanje racuna
                $data['datum'] = date('Y-m-d');
                $data['vreme'] = date('H:i:s');
                $data['iznos'] = $cena;
                $data['opis'] = 'obnova '.$period;
                $rm = new RacunModel();
                $idRacuna = $rm->dodajRacun($data);
                // dodavanje obnove
                $om = new ObnovaModel();
                $data['idRacuna'] = $idRacuna;
                $data['idKartice'] = $idKartice;
                $om->dodajObnovu($data);
                
                return redirect()->to(site_url('Registrovani/uspehRegistrovani/3'));
                
            }
            $session = session();
            $email = $session->get('korisnickoIme');
            $rm = new RegistrovaniModel();
            $idKorisnika = $rm->dohvatiKorisnika($email)->idKorisnika;
            $data['kartice'] = $km->dohvatiSveKartice($idKorisnika);
            $data['naslov'] = 'OBNOVA KARTICE';
            $data['poruka'] = $poruka;
            $this->prikazi('obnovaKartice', $data);
        }
        
        public function profil()
	{
                $session = session();
                $email = $session->get('korisnickoIme');
                $rm = new RegistrovaniModel();
                $korisnik = $rm->dohvatiKorisnika($email);
                $data['naslov'] = 'PROFIL';
                $data['korisnik'] = $korisnik;
                $data['pritisnuoDugme'] = false;
		$this->prikazi('profil', $data);
	}
        
        public function izmenaProfilaSubmit() {
            $session = session();
            $email = $session->get('korisnickoIme');
            $rm = new RegistrovaniModel();
            $korisnik = $rm->dohvatiKorisnika($email);
            $rules['ime'] = 'required|alpha';
            $rules['prezime'] = 'required|alpha';
            $rules['grad'] = 'required|alpha_space';
            $rules['adresa'] = 'required|alpha_numeric_space';
            $rules['email'] = 'required|valid_email';
            $rules['telefon'] = 'required|numeric';
            $messages['ime']['required'] = 'UNESITE IME.';
            $messages['ime']['alpha'] = 'NEKOREKTAN UNOS ZA IME.';
            $messages['prezime']['required'] = 'UNESITE PREZIME.';
            $messages['prezime']['alpha'] = 'NEKOREKTAN UNOS ZA PREZIME.';
            $messages['grad']['required'] = 'UNESITE GRAD.';
            $messages['grad']['alpha_space'] = 'NEKOREKTAN UNOS ZA GRAD.';
            $messages['adresa']['required'] = 'UNESITE ADRESU.';
            $messages['adresa']['alpha_numeric_space'] = 'NEKOREKTAN UNOS ZA ADRESU.';
            $messages['email']['required'] = 'UNESITE EMAIL.';
            $messages['email']['valid_email'] = 'POLJE EMAIL NE SADRŽI VALIDNU EMAIL ADRESU.';
            $messages['telefon']['required'] = 'UNESITE TELEFON.';
            $messages['telefon']['numeric'] = 'NEKOREKTAN UNOS ZA TELEFON.';
            if(!$this->validate($rules, $messages)) {
                if($this->validator->hasError('email')) $poruka = $this->validator->getError ('email');
                else if($this->validator->hasError('telefon')) $poruka = $this->validator->getError ('telefon');
                else if($this->validator->hasError('ime')) $poruka = $this->validator->getError ('ime');
                else if($this->validator->hasError('prezime')) $poruka = $this->validator->getError ('prezime');
                else if($this->validator->hasError('grad')) $poruka = $this->validator->getError ('grad');
                else if($this->validator->hasError('adresa')) $poruka = $this->validator->getError ('adresa');
            } else {
                if(!$rm->dohvatiKorisnika($this->request->getVar('email')) || $korisnik->email == $this->request->getVar('email')) {
                    $data['email'] = $this->request->getVar('email');
                    $data['telefon'] = $this->request->getVar('telefon');
                    $data['ime'] = $this->request->getVar('ime');
                    $data['prezime'] = $this->request->getVar('prezime');
                    $data['grad'] = $this->request->getVar('grad');
                    $data['adresa'] = $this->request->getVar('adresa');
                    $rm->izmeniKorisnika($korisnik->idKorisnika, $data);
                    
                    return redirect()->to(site_url('Registrovani/uspehRegistrovani/1'));
                    
                }
                else {
                  $poruka = 'UNETI EMAIL VEĆ POSTOJI U SISTEMU.';  
                }
            }
            $data['naslov'] = 'PROFIL';
            $data['poruka'] = $poruka;
            $data['pritisnuoDugme'] = true;
            $this->prikazi('profil', $data);
        }
        
        public function uspehRegistrovani($id) {
            switch($id) {
                case '1': $naslov = 'PROFIL - USPEH'; break;
                case '2': $naslov = 'PROMENA LOZINKE - USPEH'; break;
                case '3': $naslov = 'OBNOVA KARTICE - USPEH'; break;
                case '4': $naslov = 'TRANSFER - USPEH'; break;
            }
            $data['naslov'] = $naslov;
            $this->prikazi('uspehRegistrovani', $data);
        }

	//--------------------------------------------------------------------

}
