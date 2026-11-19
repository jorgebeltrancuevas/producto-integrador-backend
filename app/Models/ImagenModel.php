<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenModel extends Model
{
    // Tabla de la base de datos
    protected $table = 'imagenes';

    // Llave primaria
    protected $primaryKey = 'id';

    // Tipo de datos que devolverá
    protected $returnType = 'array';

    // Campos que se pueden registrar o modificar
    protected $allowedFields = [
        'nombre_archivo',
        'categoria',
        'usuario_id'
    ];

    // La fecha se genera automáticamente en MySQL
    protected $useTimestamps = false;

    // Utilizar identificadores autoincrementales
    protected $useAutoIncrement = true;
}
