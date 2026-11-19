# Producto Integrador Backend

Proyecto de Lenguajes de Programación Backend desarrollado con CodeIgniter 4 y el patrón Modelo–Vista–Controlador (MVC). Incluye un panel de administración de usuarios, una galería de imágenes privada y un módulo de generación de documentos.

## Tecnologías

- PHP 8.2 o superior, CodeIgniter 4 y Composer.
- MySQL o MariaDB, Apache y phpMyAdmin en XAMPP.
- HTML y CSS para la interfaz.

## Funcionalidades

- **Administrador:** puede listar, crear, editar y eliminar cuentas.
- **Usuario:** puede subir, ver, cambiar de categoría y eliminar sus propias imágenes. La galería del administrador también está limitada a sus propias imágenes.
- **Documentos:** genera archivos Word, Excel, PDF y PNG.
- **Seguridad:** inicio y cierre de sesión, permisos por rol y protección CSRF en los formularios.

## Instalación en XAMPP

### 1. Descargar el proyecto

En GitHub, abre **Code → Download ZIP** y extrae el archivo en `C:\xampp\htdocs\`. Renombra la carpeta extraída a `producto_integrador_backend` si tiene un sufijo como `-main`.

Si tienes Git instalado, también puedes abrir PowerShell y clonar el proyecto directamente en esa ubicación:

```powershell
cd C:\xampp\htdocs
git clone https://github.com/jorgebeltrancuevas/producto-integrador-backend.git producto_integrador_backend
```

Si el repositorio es privado, inicia sesión con una cuenta que tenga acceso.

### 2. Instalar dependencias

En el panel de XAMPP, inicia **Apache** y **MySQL**. Con Composer instalado, abre PowerShell en la carpeta del proyecto y ejecuta:

```powershell
cd C:\xampp\htdocs\producto_integrador_backend
composer install --no-dev
```

Si Composer indica que falta una extensión de PHP, actívala en el `php.ini` de XAMPP. La aplicación usa `mysqli` para la base de datos, `gd` para las imágenes y `zip` para los documentos de Office, entre otras extensiones.

### 3. Crear la base de datos e importar el SQL

1. Abre `http://localhost/phpmyadmin/`. Si Apache está configurado en el puerto 8080, usa `http://localhost:8080/phpmyadmin/`.
2. Crea una base de datos vacía llamada `producto_integrador_backend` y selecciónala.
3. En **Importar**, selecciona [`producto_integrador_hosting.sql`](producto_integrador_hosting.sql). Deja el formato **SQL** y pulsa **Continuar**.
4. Comprueba que aparezcan las tablas `usuarios` e `imagenes`. Ambas empiezan vacías.

### 4. Configurar `.env`

En la raíz del proyecto, junto a `composer.json`, crea un archivo llamado `.env` con esta configuración de ejemplo:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost/producto_integrador_backend/public/'
app.indexPage = 'index.php'

database.default.hostname = 127.0.0.1
database.default.database = producto_integrador_backend
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
database.default.port = 3306
```

Ajusta el usuario y la contraseña de MySQL a tu instalación. El valor vacío es para una cuenta local configurada sin contraseña. Si Apache usa el puerto 8080, agrega `:8080` después de `localhost` en `app.baseURL`. Si MySQL usa el puerto 3307, cambia `database.default.port` a `3307`. Los puertos de Apache y MySQL se configuran por separado.

Confirma que PHP pueda escribir en `writable/` y que exista `writable/session/`. Si hace falta crear la carpeta de sesiones, ejecuta `New-Item -ItemType Directory -Force writable/session` desde la raíz del proyecto.

### 5. Crear una cuenta de prueba local

1. En PowerShell, genera una contraseña aleatoria y su hash con el PHP de XAMPP:

   ```powershell
   & 'C:\xampp\php\php.exe' -r '$password = bin2hex(random_bytes(12)); echo $password, PHP_EOL, password_hash($password, PASSWORD_DEFAULT), PHP_EOL;'
   ```

2. Guarda la primera línea de la salida para iniciar sesión. Copia la segunda línea, que es el hash completo.
3. En phpMyAdmin, selecciona la base local y abre la pestaña **SQL**. En la consulta siguiente, sustituye `PEGA_AQUI_EL_HASH` por la segunda línea y ejecuta la consulta:

   ```sql
   INSERT INTO usuarios (nombre, usuario, password, rol)
   VALUES ('Cuenta de prueba', 'DEMO_LOCAL', 'PEGA_AQUI_EL_HASH', 'usuario');
   ```

Para probar el módulo **Usuarios**, puedes crear una segunda cuenta local con otro nombre de usuario, el rol `admin` y su propia contraseña generada con el mismo comando.

### 6. Abrir la aplicación

Abre `http://localhost/producto_integrador_backend/public/index.php/login`. Si Apache usa el puerto 8080, abre `http://localhost:8080/producto_integrador_backend/public/index.php/login`.

Inicia sesión con `DEMO_LOCAL` y la contraseña generada. Desde el panel, abre **Imágenes** para probar la galería.

## Autor

Jorge Mitchell Beltrán Cuevas
