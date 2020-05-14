<?php namespace App\Models;

use CodeIgniter\Model;

class RacunModel extends Model
{
    protected $table      = 'racun';
    protected $primaryKey = 'idRacuna';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idRacuna', 'datum', 'vreme', 'iznos', 'opis'];
    
    public function dodajRacun($data) {
        $this->insert($data);
        return $this->getInsertID();
    }
    
}
