<?php namespace App\Controllers;

use App\Models\KarticaModel;
use App\Models\BoravakModel;
use App\Models\KaznaModel;
use App\Models\RacunModel;


/* 
 * 
 * autor: MIRKO STOJANOVIĆ 0703/2017
 * 
 * 
 * 
 * 
 * Operater controller 
 * 
 * 
 * 
 * klasa sadrži metode za prikaz odgovarajućih php stranica: 
 * 
 * kontrolnaTabla(), ulazakGost(), ulazakRegistrovani(), izlazak(),
 * 
 * kao i metode za sprovođenje samih funkcionalnosti: 
 * 
 * ulazakGosta(), ulazakRegistrovanog(), izlazakIzGaraze()
 * 
 * 
*/

class Operater extends Korisnik
{
    
        public function prikazi($page, $data) {
            echo view('sabloni/header_operater', $data);
            if($page != '') echo view("stranice/$page", $data);
            echo view('sabloni/footer_operater', $data);
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
        
        public function odjaviSe() {
            $session = session();
            $session->destroy();
            return redirect()->to(site_url('Gost/prijava'));
        }
    
        public function ulazakGost()
	{
                $data['naslov'] = 'ULAZAK GOST';
		$this->prikazi('ulazakGost', $data);
	}
        
        public function ulazakRegistrovani()
	{
                $data['naslov'] = 'ULAZAK REGISTROVANI';
		$this->prikazi('ulazakRegistrovani', $data);
	}
        
        public function izlazak()
	{
                $data['naslov'] = 'IZLAZAK';
		$this->prikazi('izlazak', $data);
	}
        

	private function proveraBoravka($kartice){

	}

	public function ulazakGosta(){
		$tablice = $this->request->getVar('brojTablica');

		$rules['brojTablica'] = 'required';
		$messages['brojTablica']['required'] = 'TABLICE NISU UNETE!';
		$poruka = '';
		$data['naslov'] = "ULAZAK GOST";

		if(!$this->validate($rules, $messages)){
			$poruka = $this->validator->getError('brojTablica');
		}
		else{
			//provera da li postoje te tablice u boravku ???? DA LI SE PODRAZUMEVA ISPRAVAN UNOS?
			$karticaModel = new KarticaModel();

			//insert kartice
			$idKartice = $karticaModel->dodajKarticu(null, null, null, $tablice);

			$data['usaoGost'] = $idKartice;

			//insert boravka
			$ulazakModel = new BoravakModel();
			$ulazakModel->dodajBoravak($idKartice);
			return redirect()->to(site_url('Operater/uspehOperater/1'));
		}

		
		if($poruka) $data['poruka'] = $poruka;
		
		$this->prikazi('ulazakGost', $data);
	}

	public function ulazakRegistrovanog(){
		$idKartice = $this->request->getVar('idKartice');

		$rules['idKartice'] = 'required';
		$messages['idKartice']['required'] = 'ID KARTICE NIJE UNET!';
		$poruka = '';

		if(!$this->validate($rules, $messages)){
			$poruka = $this->validator->getError('idKartice');
		}
		else{
			//provera da li postoji registrovani korisnik sa ovim ID-em
			$karticaModel = new KarticaModel();
			$kartica = $karticaModel->dohvatiKarticu($idKartice);

			if($kartica == null) $poruka = 'NE POSTOJI KARTICA SA UNETIM ID-em';
			else{
				if(!$kartica->idKorisnika) $poruka = 'KARTICA SE NE ODNOSI NA REGISTROVANOG KORISNIKA';
				else{
					//insert boravka
					$ulazakModel = new BoravakModel();
					$ulazakModel->dodajBoravak($idKartice);
					$data['usaoRegistrovani'] = 'Uspesan ulazak';
					return redirect()->to(site_url('Operater/uspehOperater/2'));
				}
			}

		}

		$data['naslov'] = "ULAZAK REGISTROVANI";
		if($poruka) $data['poruka'] = $poruka;
		
		$this->prikazi('ulazakRegistrovani', $data);
	}

	public function izlazakIzGaraze(){
		$idKartice = $this->request->getVar('idKartice');

		$rules['idKartice'] = 'required';
		$messages['idKartice']['required'] = 'ID KARTICE NIJE UNET!';
		$poruka = '';

		if(!$this->validate($rules, $messages)){
			$poruka = $this->validator->getError('idKartice');
		}
		else{
			//provera da li postoji korisnik sa ovim ID-em
			$karticaModel = new KarticaModel();
			$postojiKor = $karticaModel->dohvatiKarticu($idKartice);

			if($postojiKor == null) $poruka = 'NE POSTOJI KORISNIK SA OVIM ID-em!';
			else{
				$boravakM = new BoravakModel();
				$boravak = $boravakM->dohvatiBoravak($idKartice);
				if($boravak == null) {
					$data['poruka'] = "KORISNIK NIJE PARKIRAN!";
				}
				else{
					$poruka = 'Korisnik izasao';
					//provera da li registrovan ili ne
					if($postojiKor->idKorisnika == null) {

						//vreme provedeno + kazne
						$datumUl = $boravak->datumUlaska;
						$datumUl = explode('-', $datumUl);
						$vremeUl = $boravak->vremeUlaska;
						$vremeUl = explode(':', $vremeUl);

						$danUl = (int)$datumUl[2];
						$mesUl = (int)$datumUl[1];
						$godUl =  (int)$datumUl[0];

						$satUl = (int)$vremeUl[0];
						$minUl = (int)$vremeUl[1];
						$sekUl = (int)$vremeUl[2];

						$vremeUl = mktime($satUl, $minUl, $sekUl, $mesUl,  $danUl, $godUl);
						$vremeIzl = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));
						$brsati = round(($vremeIzl - $vremeUl) / 3600); 
						if($brsati == 0) $brsati = 1;

						$cena = $brsati*60; //60din sat
						$data['cena'] = $cena;

						//cena se sabira sa kaznama ako ih ima
						$kaznaM = new KaznaModel();
						$kazne = $kaznaM->dohvatiKazne($boravak->idBoravka);

						foreach($kazne as $kazna){
							$cena += $kazna->iznos;
						}
					}
					else{
						//gledaju se samo kazne ako ih ima
						$kaznaM = new KaznaModel();
						$kazne = $kaznaM->dohvatiKazne($boravak->idBoravka);

						$cena = 0;
						foreach($kazne as $kazna){
							$cena += $kazna->iznos;
						}

						$data['cena'] = $cena;
					}
					
					if($cena > 0){
						$data['datum'] = date('Y-m-d');
						$data['vreme'] = date('H:i:s');
						$data['iznos'] = $cena;
						$data['opis'] = "placanje izlaska";
						$rm = new RacunModel();
						$idRacuna = $rm->dodajRacun($data);
						$boravakM->updateRacun($boravak->idBoravka, $idRacuna);
					}
					$boravakM->izlazak($boravak->idBoravka);
					return redirect()->to(site_url("Operater/uspehOperater/3/$cena"));
				}
			}

		}

		$data['naslov'] = "IZLAZAK";
		if($poruka) $data['poruka'] = $poruka;
		
		$this->prikazi('izlazak', $data);
	}
	
	public function uspehOperater($id, $cena = null) {
		switch($id) {
			case '1': $naslov = 'ULAZAK GOST'; break;
			case '2': $naslov = 'ULAZAK REGISTROVANI'; break;
			case '3': $naslov = 'IZLAZAK'; break;
		}
		$data['naslov'] = $naslov;
		$data['cena'] = $cena;
		$this->prikazi('uspehOperater', $data);
	}
	//--------------------------------------------------------------------

}
