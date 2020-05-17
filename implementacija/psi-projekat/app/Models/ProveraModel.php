<?php namespace App\Models;

use CodeIgniter\Model;

class ProveraModel extends Model
{
    protected $table      = 'boravak';
    protected $primaryKey = 'idBoravka';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idBoravka', 'idKartice', 'datumUlaska', 'vremeUlaska', 'datumIzlaska','vremeIzlaska','idRacuna'];
    
    public function unutra($idK) {
        return $this->where('idKartice', $idK)->where('datumIzlaska',null)->where('vremeIzlaska',null)->first();
    }
    
    public function dohvatiUlazBezIzlaza($idK){
        return $this->where('idKartice',$idK)->where('datumIzlaska',null)->first();
    }
}