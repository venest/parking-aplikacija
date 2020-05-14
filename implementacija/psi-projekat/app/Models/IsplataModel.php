<?php namespace App\Models;

use CodeIgniter\Model;

class IsplataModel extends Model
{
    protected $table      = 'isplata';
    protected $primaryKey = 'idIsplate';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idIsplate', 'idKartice', 'idRacuna'];
    
    public function dodajIsplatu($data) {
        $this->insert($data);
    }
    
}
