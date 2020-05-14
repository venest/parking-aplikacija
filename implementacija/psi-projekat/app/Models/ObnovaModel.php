<?php namespace App\Models;

use CodeIgniter\Model;

class ObnovaModel extends Model
{
    protected $table      = 'obnova';
    protected $primaryKey = 'idObnove';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idObnove', 'idKartice', 'idRacuna'];
    
    public function dodajObnovu($data) {
        $this->insert($data);
    }
    
}

