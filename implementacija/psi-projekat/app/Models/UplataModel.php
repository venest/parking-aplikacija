<?php namespace App\Models;

use CodeIgniter\Model;

class UplataModel extends Model
{
    protected $table      = 'uplata';
    protected $primaryKey = 'idUplate';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idUplate', 'idKartice', 'idRacuna'];
    
    public function dodajUplatu($data) {
        $this->insert($data);
    }
    
}
