<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Usuarios extends BaseController
{
    // Mostrar formulario y listado de usuarios
    public function index()
    {
        $modelo = new UsuarioModel();

        $datos['usuarios'] = $modelo->findAll();

        return view('usuarios/index', $datos);
    }

    // Guardar un nuevo usuario
    public function guardar()
    {
        $modelo = new UsuarioModel();

        $nombre = trim((string) $this->request->getPost('nombre'));
        $usuario = trim((string) $this->request->getPost('usuario'));
        $password = (string) $this->request->getPost('password');

        if ($nombre === '' || $usuario === '' || $password === '') {
            return redirect()->back()->withInput();
        }

        $datos = [
            'nombre'   => $nombre,
            'usuario'  => $usuario,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $modelo->insert($datos);

        return redirect()->to(site_url('usuarios'));
    }

    // Mostrar formulario para editar usuario
    public function editar($id)
    {
        $modelo = new UsuarioModel();

        $usuario = $modelo->find($id);

        if (!$usuario) {
            throw PageNotFoundException::forPageNotFound();
        }

        $datos['usuario'] = $usuario;

        return view('usuarios/editar', $datos);
    }

    // Actualizar información del usuario
    public function actualizar($id)
    {
        $modelo = new UsuarioModel();

        $usuarioActual = $modelo->find($id);

        if (!$usuarioActual) {
            throw PageNotFoundException::forPageNotFound();
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        $usuario = trim((string) $this->request->getPost('usuario'));
        $password = (string) $this->request->getPost('password');

        if ($nombre === '' || $usuario === '') {
            return redirect()->back()->withInput();
        }

        $datos = [
            'nombre'  => $nombre,
            'usuario' => $usuario
        ];

        // Actualizar contraseña solo si se escribe una nueva
        if ($password !== '') {
            $datos['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $modelo->update($id, $datos);

        return redirect()->to(site_url('usuarios'));
    }

    // Eliminar usuario
    public function eliminar($id)
    {
        $modelo = new UsuarioModel();

        // Buscar usuario por ID
        $usuario = $modelo->find($id);

        // Verificar si existe
        if (!$usuario) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Eliminar usuario de MySQL
        $modelo->delete($id);

        // Regresar al listado
        return redirect()->to(site_url('usuarios'));
    }
}
