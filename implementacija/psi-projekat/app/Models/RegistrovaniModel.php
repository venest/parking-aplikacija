<?php namespace App\Models;

use CodeIgniter\Model;

/*
 * 
 * RegistrovaniModel
 * 
 * klasa sadrži metode koje služe za izvršavanje 
 * 
 * osnovnih upita nad tabelom REGISTROVANI
 * 
 * 
 */


class RegistrovaniModel extends Model
{
    protected $table      = 'registrovani';
    protected $primaryKey = 'idKorisnika';

    protected $returnType     = 'object';
    
    protected $allowedFields = ['idKorisnika', 'email', 'lozinka', 'ime', 'prezime', 'grad', 'adresa', 'telefon'];
    
    public function dohvatiKorisnika($email) {
        return $this->where('email', $email)->first();
    }
    public function dodajKorisnika($korisnik) {
        $this->insert($korisnik);
    }
    
    public function izmeniKorisnika($id, $data) {
        $this->update($id, $data);
    }
    
    public function izmeniLozinku($email, $lozinka) {
        $this->where('email', $email)->set('lozinka', $lozinka)->update();
    }
    
}
