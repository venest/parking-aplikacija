<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();
        if(!$session->get('ulogovan')) {
            return redirect()->to(site_url('Gost/'));
        } else if($session->get('tip') != 'a') {
            switch ($session->get('tip')) {
                case 'rk':  return redirect()->to(site_url('Registrovani/')); break;
                case 'k': return redirect()->to(site_url('Kontrolor/')); break;
                case 'o':  return redirect()->to(site_url('Operater/')); break;
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}

