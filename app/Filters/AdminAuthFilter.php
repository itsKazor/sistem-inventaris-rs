<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $params = null)
    {
        $session = session();
        if (!$session->get('is_logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to(base_url('admin/login'))->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $params = null)
    {
        // Do nothing
    }
}
