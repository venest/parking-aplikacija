<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class GostFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $session = session();
        if($session->get('ulogovan')) {
            $tip = $session->get('tip');
            switch ($tip) {
                case 'rk': return redirect()->to(site_url('Registrovani/')); break;
                case 'a': return redirect()->to(site_url('Admin/')); break;
                case 'o': return redirect()->to(site_url('Operater/')); break;
                case 'k': return redirect()->to(site_url('Kontrolor/')); break;
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}

