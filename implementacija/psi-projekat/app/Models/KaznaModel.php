<?php namespace App\Models;

use CodeIgniter\Model;

/*
 * 
 * KaznaModel
 * 
 * klasa sadrži metode koje služe za izvršavanje 
 * 
 * osnovnih upita nad tabelom KAZNA
 * 
 * 
 */

class KaznaModel extends Model
{
    protected $table      = 'kazna';
    protected $primaryKey = 'idKazne';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idKazne', 'idBoravka', 'tipPrekrsaja', 'iznos'];
    
    public function dodajKaznu($data) {
        $this->insert($data);
    }

    public function dohvatiKazne($idBoravka){
        return $this->where('idBoravka', $idBoravka)->findAll();
    }
    
}