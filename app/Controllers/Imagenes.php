<?php

namespace App\Controllers;

use App\Models\ImagenModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Imagenes extends BaseController
{
    private const TIPOS = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    private string $carpeta;

    private array $categorias = [
        'General',
        'Personal',
        'Trabajo',
        'Escuela'
    ];

    public function __construct()
    {
        $this->carpeta = WRITEPATH . 'uploads/imagenes/';
    }

    private function imagenesDelUsuario(): ImagenModel
    {
        return (new ImagenModel())->where('usuario_id', (int) session()->get('usuario_id'));
    }

    // Mostrar imágenes y filtrar por categoría
    public function index()
    {
        $categoria = (string) $this->request->getGet('categoria');

        if (
            $categoria !== '' &&
            !in_array($categoria, $this->categorias, true)
        ) {
            $categoria = '';
        }

        $consulta = $this->imagenesDelUsuario()->orderBy('fecha_subida', 'DESC');

        if ($categoria !== '') {
            $consulta->where('categoria', $categoria);
        }

        $registros = $consulta->findAll();

        $imagenes = [];

        foreach ($registros as $registro) {
            $nombre = $registro['nombre_archivo'];

            if (!preg_match(
                '/^[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp)$/i',
                $nombre
            )) {
                continue;
            }

            if (!is_file($this->carpeta . $nombre)) {
                continue;
            }

            $imagenes[] = [
                'id' => $registro['id'],
                'nombre' => $nombre,
                'categoria' => $registro['categoria'],
                'fecha_subida' => $registro['fecha_subida'],
                'url' => site_url('imagenes/ver/' . $registro['id'])
            ];
        }

        return view('imagenes/index', [
            'imagenes' => $imagenes,
            'categorias' => $this->categorias,
            'categoriaActual' => $categoria
        ]);
    }

    public function ver($id)
    {
        $imagen = $this->imagenesDelUsuario()->find($id);
        $nombre = $imagen['nombre_archivo'] ?? '';

        if (!preg_match('/^[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp)$/i', $nombre, $partes)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $ruta = $this->carpeta . $nombre;
        $contenido = is_file($ruta) ? file_get_contents($ruta) : false;
        if ($contenido === false) {
            throw PageNotFoundException::forPageNotFound();
        }

        $extension = strtolower($partes[1]);
        $tipo = array_search($extension === 'jpeg' ? 'jpg' : $extension, self::TIPOS, true);

        return $this->response->noCache()
            ->setContentType($tipo, '')
            ->setHeader('X-Content-Type-Options', 'nosniff')
            ->setBody($contenido);
    }

    // Subir imagen y registrarla en MySQL
    public function subir()
    {
        $archivo = $this->request->getFile('imagen');

        $categoria = (string) $this->request->getPost('categoria');

        if (!in_array($categoria, $this->categorias, true)) {
            $categoria = 'General';
        }

        if (!$archivo || !$archivo->isValid()) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'Selecciona una imagen válida.');
        }

        // Tamaño máximo: 5 MB
        if ($archivo->getSize() > 5 * 1024 * 1024) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'La imagen supera los 5 MB.');
        }

        // Formatos permitidos
        $mime = $archivo->getMimeType();

        if (!isset(self::TIPOS[$mime])) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'Formato de imagen no permitido.');
        }

        // Validar el contenido del archivo
        if (@getimagesize($archivo->getTempName()) === false) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'El archivo no es una imagen válida.');
        }

        // Crear carpeta si no existe
        if (!is_dir($this->carpeta) && !@mkdir($this->carpeta, 0755, true) && !is_dir($this->carpeta)) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'No se pudo crear la carpeta.');
        }

        // Generar nombre único
        $nombre = bin2hex(random_bytes(16))
            . '.' . self::TIPOS[$mime];

        // Guardar archivo
        try {
            $archivo->move($this->carpeta, $nombre);

            // Registrar imagen en MySQL
            $modelo = new ImagenModel();

            $resultado = $modelo->insert([
                'nombre_archivo' => $nombre,
                'categoria' => $categoria,
                'usuario_id' => (int) session()->get('usuario_id')
            ]);

            if ($resultado === false) {
                throw new \RuntimeException(
                    'No se pudo registrar la imagen.'
                );
            }

        } catch (\Throwable $e) {

            // Evitar archivos sin registro en la base de datos
            if (is_file($this->carpeta . $nombre)) {
                unlink($this->carpeta . $nombre);
            }

            log_message('error', $e->getMessage());

            return redirect()->to(site_url('imagenes'))
                ->with(
                    'error',
                    'No se pudo guardar la imagen.'
                );
        }

        return redirect()->to(site_url('imagenes'))
            ->with(
                'mensaje',
                'Imagen subida correctamente en la categoría '
                . $categoria . '.'
            );
    }

    // Cambiar categoría de una imagen
    public function organizar()
    {
        $id = (int) $this->request->getPost('id');
        $categoria = (string) $this->request->getPost('categoria');

        if (!in_array($categoria, $this->categorias, true)) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'Categoría no válida.');
        }

        $imagen = $this->imagenesDelUsuario()->find($id);

        if (!$imagen) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->imagenesDelUsuario()->update($id, [
            'categoria' => $categoria
        ]);

        return redirect()->to(site_url('imagenes'))
            ->with(
                'mensaje',
                'Categoría actualizada correctamente.'
            );
    }

    // Eliminar imagen y su registro
    public function eliminar()
    {
        $nombre = (string) $this->request->getPost('nombre');

        if (!preg_match(
            '/^[a-f0-9]{32}\.(jpg|jpeg|png|gif|webp)$/i',
            $nombre
        )) {
            throw PageNotFoundException::forPageNotFound();
        }

        $imagen = $this->imagenesDelUsuario()
            ->where('nombre_archivo', $nombre)
            ->first();

        if (!$imagen) {
            throw PageNotFoundException::forPageNotFound();
        }

        $ruta = $this->carpeta . $nombre;

        if (is_file($ruta) && !unlink($ruta)) {
            return redirect()->to(site_url('imagenes'))
                ->with('error', 'No se pudo eliminar el archivo.');
        }

        $this->imagenesDelUsuario()->delete($imagen['id']);

        return redirect()->to(site_url('imagenes'))
            ->with(
                'mensaje',
                'Imagen eliminada correctamente.'
            );
    }
}
