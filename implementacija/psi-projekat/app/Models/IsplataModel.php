<?php namespace App\Models;

use CodeIgniter\Model;

/*
 * 
 * IsplataModel
 * 
 * klasa sadrži metode koje služe za izvršavanje 
 * 
 * osnovnih upita nad tabelom ISPLATA
 * 
 * 
 */

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
