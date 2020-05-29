<?php namespace App\Models;

use CodeIgniter\Model;

/*
 * 
 * ZaposleniModel
 * 
 * klasa sadrži metode koje služe za izvršavanje 
 * 
 * osnovnih upita nad tabelom ZAPOSLENI
 * 
 * 
 */

class ZaposleniModel extends Model
{
    protected $table      = 'zaposleni';
    protected $primaryKey = 'idZaposlenog';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['korisnickoIme', 'lozinka', 'tip'];
    
    public function dohvatiZaposlenog($korisnickoIme) {
        return $this->where('korisnickoIme', $korisnickoIme)->first();
    }
}