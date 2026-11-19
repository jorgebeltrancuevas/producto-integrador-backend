<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    ) {
        // Verificar si el usuario inició sesión
        if (!session()->get('logueado')) {

            // Si no tiene sesión, enviarlo al Login
            return redirect()->to(site_url('login'))
                ->with(
                    'error',
                    'Debes iniciar sesión para acceder.'
                );
        }

        // Permitir el acceso si tiene sesión
        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // No necesitamos modificar la respuesta
    }
}
