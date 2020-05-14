<?php namespace App\Models;

use CodeIgniter\Model;

class IzdavanjeModel extends Model
{
    protected $table      = 'izdavanje';
    protected $primaryKey = 'idKartice';

    protected $returnType = 'object';
    
    protected $allowedFields = ['idKartice', 'idRacuna'];
    
    
    public function dodajIzdavanje($idKar,$idRac) {
        $data['idKartice']=$idKar;
        $data['idRacuna']=$idRac;
        $this->insert($data);
        
    }
}