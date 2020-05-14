<?php namespace App\Controllers;

class Admin extends BaseController
{
        public function prikazi($page, $data) {
            echo view('sabloni/header_admin', $data);
            if($page != '') echo view("stranice/$page", $data);
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
        
        public function izlogujSe() {
            $session = session();
            $session->destroy();
            return redirect()->to(site_url('Gost/logovanje'));
        }
        
        public function izdavanjeKartice()
	{
                $data['naslov'] = 'IZDAVANJE KARTICE';
		$this->prikazi('izdavanjeKartice', $data);
	}
        
        public function obnovaKartice()
	{
                $data['naslov'] = 'OBNOVA KARTICE';
		$this->prikazi('obnovaKarticeOperater', $data);
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
        

	//--------------------------------------------------------------------

}
