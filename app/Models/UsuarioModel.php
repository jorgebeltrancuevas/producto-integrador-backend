<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'usuario',
        'password'
    ];

    protected $useTimestamps = false;

    protected $returnType = 'array';

    public function esAdministrador(int $id): bool
    {
        $usuario = $this->find($id);

        return ($usuario['rol'] ?? null) === 'admin';
    }
}
