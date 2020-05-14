<?php namespace App\Models;

use CodeIgniter\Model;

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