<?php namespace App\Models;

use CodeIgniter\Model;

date_default_timezone_set('Europe/Belgrade');

class BoravakModel extends Model
{
  

    protected $table      = 'boravak';
    protected $primaryKey = 'idBoravka';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idBoravka', 'idKartice', 'datumUlaska', 'datumIzlaska', 'vremeUlaska', 'vremeIzlaska', 'idRacuna'];
    
    public function dodajBoravak($idKartice) {
        $data['idKartice'] = $idKartice;
        $data['datumUlaska'] = date('Y-m-d');
        $data['vremeUlaska'] = date('H:i:s');
        $data['datumIzlaska'] = null;
        $data['vremeIzlaska'] = null;
        $data['idRacuna'] = null;
      
        $this->insert($data); 
        return $this->getInsertID();  
    }

    public function updateRacun($idBoravka, $idRacuna){
        $data['idRacuna'] = $idRacuna;
        $this->update($idBoravka, $data);
    }

    //vraca boravak korisnika koja je jos u garazi
    public function dohvatiBoravak($idKartice){
        return $this->where('idKartice', $idKartice)->where('datumIzlaska', null)->first();
    }
    
    public function izlazak($idBoravka){
        $data['datumIzlaska'] = date('Y-m-d');
        $data['vremeIzlaska'] = date('H:i:s');
        $this->update($idBoravka, $data);
    }
    
    public function unutra($idK) {
        return $this->where('idKartice', $idK)->where('datumIzlaska',null)->where('vremeIzlaska',null)->first();
    }
    
    public function dohvatiUlazBezIzlaza($idK){
        return $this->where('idKartice',$idK)->where('datumIzlaska',null)->first();
    }
    
}
