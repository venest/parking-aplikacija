<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class KontrolorFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();
        if(!$session->get('ulogovan')) {
            return redirect()->to(site_url('Gost/'));
        } else if($session->get('tip') != 'k') {
            switch ($session->get('tip')) {
                case 'a':  return redirect()->to(site_url('Admin/')); break;
                case 'rk': return redirect()->to(site_url('Registrovani/')); break;
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

