<?php namespace App\Controllers;

class Operater extends BaseController
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
        
        public function izlogujSe() {
            $session = session();
            $session->destroy();
            return redirect()->to(site_url('Gost/logovanje'));
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
