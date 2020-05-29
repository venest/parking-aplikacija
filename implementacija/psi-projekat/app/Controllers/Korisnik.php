<?php namespace App\Controllers;

/* 
 * 
 * Korisnik controller 
 * 
 * 
 * 
 * klasa sadrži metode za prikaz odgovarajućih php stranica: 
 * 
 * pocetna(), tipoviKorisnika(), cenovnik(), kontakt()
 * 
 * 
*/

class Korisnik extends BaseController
{
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
		$this->prikazi('kontakt', $data);;
	}

}
