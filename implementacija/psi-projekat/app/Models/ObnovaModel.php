<?php namespace App\Models;

use CodeIgniter\Model;

/*
 * 
 * ObnovaModel
 * 
 * klasa sadrži metode koje služe za izvršavanje 
 * 
 * osnovnih upita nad tabelom OBNOVA
 * 
 * 
 */

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

