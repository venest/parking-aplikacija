<?php

namespace App\Models;

use CodeIgniter\Model;

class KarticaModel extends Model {

    protected $table = 'kartica';
    protected $primaryKey = 'idKartice';
    protected $returnType = 'object';
    protected $allowedFields = ['idKartice', 'automobil', 'idKorisnika', 'vaziDo', 'stanje'];

    public function dohvatiKarticu($id) {
        return $this->find($id);
    }

    public function dohvatiSveKartice($idKorisnika) {
        return $this->where('idKorisnika', $idKorisnika)->findAll();
    }

    public function izmeniStanje($id, $stanje) {
        $data['stanje'] = $stanje;
        $this->update($id, $data);
    }

    public function izmeniDatumVazenja($id, $datum) {
        $data['vaziDo'] = $datum;
        $this->update($id, $data);
    }

    public function dodajKarticu($datumDo,$stanje,$idKor,$auto) {
        $data['vaziDo'] = $datumDo;
        $data['stanje'] = $stanje;
        $data['idKorisnika'] = $idKor;
        $data['automobil'] = $auto;
        
         $this->insert($data);
         return $this->getInsertID();
    }
    
    public function nadjiKarticu($tablice, $idKor){
        return $this->where('automobil', $tablice)->where('idKorisnika',$idKor)->first();
    }
    
    public function obrisi($kartica) {
        $this->delete($kartica->idKartice);   
    }

}
