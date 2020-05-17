<?php namespace App\Controllers;

class Kontrolor extends BaseController
{
    
        public function prikazi($page, $data) {
            echo view('sabloni/header_kontrolor', $data);
            if($page != '') echo view("stranice/$page", $data);
            echo view('sabloni/footer_kontrolor', $data);
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
        
        public function kazna()
	{
                $data['naslov'] = 'KAZNA';
		$this->prikazi('kazna', $data);
	}
        
        public function provera()
	{
                $data['naslov'] = 'PROVERA';
		$this->prikazi('provera', $data);
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
