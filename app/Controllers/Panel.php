<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Panel extends BaseController
{
    // Mostrar el menú principal
    public function index()
    {
        return view('panel/index', [
            'esAdministrador' => (new UsuarioModel())->esAdministrador((int) session()->get('usuario_id')),
        ]);
    }
}
