<?php namespace App\Controllers;

use App\Models\RegistrovaniModel;
use App\Models\ZaposleniModel;

/* 
 * 
 * autor: VELJKO NESTOROVIĆ 0039/2017
 * 
 * 
 * 
 * 
 * Gost controller 
 * 
 * 
 * 
 * klasa sadrži metode za prikaz odgovarajućih php stranica: 
 * 
 * prijava(), registracija(),
 * 
 * kao i metode za sprovođenje samih funkcionalnosti prijave i registracije: 
 * 
 * prijaviSe(), registrujSe()
 * 
 * 
*/


class Gost extends Korisnik
{
    
        public function prikazi($page, $data) {
            echo view('sabloni/header_gost', $data);
            echo view("stranice/$page", $data);
            echo view('sabloni/footer_gost', $data);
        }
        
	public function index()
	{
                $data['naslov'] = 'POČETNA';
		$this->prikazi('pocetna', $data);
	}
       

        public function prijava()
	{
                $data['naslov'] = 'PRIJAVA';
		$this->prikazi('prijava', $data);
	}
        
        public function registracija()
	{
                $data['naslov'] = 'REGISTRACIJA';
		$this->prikazi('registracija', $data);
	}
        
        public function prijaviSe()
	{
            $rules['korisnickoIme'] = 'required';
            $rules['lozinka'] = 'required';
            $messages['korisnickoIme']['required'] = 'UNESITE KORISNIČKO IME.';
            $messages['lozinka']['required'] = 'UNESITE LOZINKU.';
            $poruka = '';
            if(!$this->validate($rules, $messages)) {
                if($this->validator->hasError('korisnickoIme')) $poruka = $this->validator->getError ('korisnickoIme');
                else if($this->validator->hasError('lozinka')) $poruka = $this->validator->getError ('lozinka');
            } else {
                $korisnickoIme = $this->request->getVar('korisnickoIme');
                $lozinka = $this->request->getVar('lozinka');
                $rm = new RegistrovaniModel();
                $zm = new ZaposleniModel();
                $registrovani = $rm->dohvatiKorisnika($korisnickoIme);
                $zaposleni = $zm->dohvatiZaposlenog($korisnickoIme);
                if($registrovani != null && $registrovani->lozinka == $lozinka) {
                        $session = session();
                        $session->set('ulogovan', true);
                        $session->set('tip', 'rk');
                        $session->set('korisnickoIme', $korisnickoIme);
                        $session->set('lozinka', $lozinka);
                        return redirect()->to(site_url('Registrovani/'));
                } else if($zaposleni != null && $zaposleni->lozinka == $lozinka) {
                        $tip = $zaposleni->tip;
                        $session = session();
                        $session->set('ulogovan', true);
                        $session->set('tip', $tip);
                        $session->set('korisnickoIme', $korisnickoIme);
                        $session->set('lozinka', $lozinka);
                        switch($tip) {
                            case 'a': return redirect()->to(site_url('Admin/')); break; 
                            case 'o': return redirect()->to(site_url('Operater/')); break; 
                            case 'k': return redirect()->to(site_url('Kontrolor/')); break; 
                        }
                } else $poruka = 'KORISNIČKO IME I/ILI LOZINKA SU POGREŠNI.';
            }
            $data['poruka'] = $poruka;
            $data['naslov'] = 'PRIJAVA';
            echo $this->prikazi('prijava', $data);
        }
        
        public function registrujSe()
	{
            $rules['ime'] = 'required|alpha';
            $rules['prezime'] = 'required|alpha';
            $rules['grad'] = 'required|alpha_space';
            $rules['adresa'] = 'required|alpha_numeric_space';
            $rules['email'] = 'required|valid_email';
            $rules['telefon'] = 'required|numeric';
            $rules['lozinka'] = 'required|min_length[7]';
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
            $messages['lozinka']['required'] = 'UNESITE LOZINKU.';
            $messages['lozinka']['min_length'] = 'LOZINKA MORA SADRŽATI BAR 7 ZNAKOVA.';
            $poruka = '';
            if(!$this->validate($rules, $messages)) {
                if($this->validator->hasError('ime')) $poruka = $this->validator->getError ('ime');
                else if($this->validator->hasError('prezime')) $poruka = $this->validator->getError ('prezime');
                else if($this->validator->hasError('grad')) $poruka = $this->validator->getError ('grad');
                else if($this->validator->hasError('adresa')) $poruka = $this->validator->getError ('adresa');
                else if($this->validator->hasError('email')) $poruka = $this->validator->getError ('email');
                else if($this->validator->hasError('telefon')) $poruka = $this->validator->getError ('telefon');
                else if($this->validator->hasError('lozinka')) $poruka = $this->validator->getError ('lozinka');
            } else {
                $email = $this->request->getVar('email');
                $lozinka = $this->request->getVar('lozinka');
                $ponovljenaLozinka = $this->request->getVar('ponovljenaLozinka');
                $rm = new RegistrovaniModel();
                if($rm->dohvatiKorisnika($email)) {
                    $poruka = 'UNETI EMAIL VEĆ POSTOJI U SISTEMU.';
                } else if($lozinka != $ponovljenaLozinka) {
                    $poruka = 'POTVRDA LOZINKE NIJE USPELA.';
                } else {
                    $korisnik['email'] = $email;
                    $korisnik['lozinka'] = $lozinka;
                    $korisnik['ime'] = $this->request->getVar('ime');
                    $korisnik['prezime'] = $this->request->getVar('prezime');
                    $korisnik['grad'] = $this->request->getVar('grad');
                    $korisnik['adresa'] = $this->request->getVar('adresa');
                    $korisnik['telefon'] = $this->request->getVar('telefon');
                    $rm->dodajKorisnika($korisnik);
                    return redirect()->to(site_url('Gost/uspehRegistracija'));
                }
            }
            $data['poruka'] = $poruka;
            $data['naslov'] = 'REGISTRACIJA';
            echo $this->prikazi('registracija', $data);
	}
        
        public function uspehRegistracija() {
            $data['naslov'] = 'USPEŠNA REGISTRACIJA';
            echo $this->prikazi('uspehRegistracija', $data);
        }
	//--------------------------------------------------------------------

}
