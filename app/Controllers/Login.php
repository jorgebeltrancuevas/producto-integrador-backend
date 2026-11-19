<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
    // Mostrar formulario de acceso
    public function index()
    {
        if (session()->get('usuario_id')) {
            return redirect()->to(site_url('panel'));
        }

        return view('login');
    }

    // Validar usuario y contraseña
    public function autenticar()
    {
        $usuario = trim((string) $this->request->getPost('usuario'));
        $password = (string) $this->request->getPost('password');

        $modelo = new UsuarioModel();

        $datos = $modelo
            ->where('usuario', $usuario)
            ->first();

        if (!$datos || !password_verify($password, $datos['password'])) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Usuario o contraseña incorrectos.');
        }

        // Crear sesión segura
        session()->regenerate();

        session()->set([
            'usuario_id' => $datos['id'],
            'usuario' => $datos['usuario'],
            'nombre' => $datos['nombre'],
            'logueado' => true
        ]);

        // Cookie para recordar el usuario
        if ($this->request->getPost('recordar')) {
            $this->response->setCookie(
                'usuario_recordado',
                $datos['usuario'],
                60 * 60 * 24 * 7,
                '',
                '/',
                '',
                false,
                true,
                'Lax'
            );
        } else {
            $this->response->deleteCookie('usuario_recordado');
        }

        return redirect()->to(site_url('panel'));
    }

    // Cerrar sesión
    public function salir()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
