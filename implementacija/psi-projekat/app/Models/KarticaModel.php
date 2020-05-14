<?php namespace App\Models;

use CodeIgniter\Model;

class KarticaModel extends Model
{
    protected $table      = 'kartica';
    protected $primaryKey = 'idKartice';

    protected $returnType     = 'object';
    
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
    
}
