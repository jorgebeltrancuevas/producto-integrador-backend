
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de usuarios - Producto integrador Backend</title>

    <link rel="stylesheet" href="<?= esc(base_url('css/tema.css'), 'attr') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: var(--marfil);
        }

        .contenedor {
            max-width: 800px;
            margin: auto;
            background: var(--superficie);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(16,59,40,0.08);
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .encabezado h1 {
            margin-bottom: 5px;
        }

        .subtitulo {
            color: var(--texto-secundario);
            margin-top: 5px;
        }

        .bienvenida {
            background: var(--verde-suave);
            color: var(--verde-profundo);
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .formulario-registro input {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid var(--borde-control);
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
        }

        button {
            padding: 10px 20px;
            background: var(--verde-oscuro);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .btn-salir {
            background: var(--texto-secundario);
            white-space: nowrap;
        }

        .btn-borrar {
            background: var(--peligro);
            padding: 8px 12px;
        }

        .btn-editar {
            color: var(--verde-oscuro);
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-editar:hover {
            text-decoration: underline;
        }

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid var(--borde-control);
            padding: 10px;
            text-align: left;
        }

        th {
            background: var(--verde-oscuro);
            color: white;
        }

        .acciones {
            white-space: nowrap;
        }

        .formulario-inline {
            display: inline;
        }

        @media (max-width: 600px) {
            body {
                margin: 15px;
            }

            .contenedor {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <!-- ENCABEZADO Y CERRAR SESIÓN -->
    <div class="encabezado">

        <div>
            <h1>Sistema de registro de usuarios</h1>
            <p class="subtitulo">
                Producto integrador - Lenguajes de programación Backend
            </p>
        </div>

        <form action="<?= site_url('login/salir') ?>" method="post">
            <?= csrf_field() ?>

            <button type="submit" class="btn-salir">
                Cerrar sesión
            </button>
        </form>

    </div>

    <!-- BIENVENIDA -->
    <div class="bienvenida">
        Bienvenido,
        <strong><?= esc(session()->get('nombre') ?? 'Usuario') ?></strong>.
        Has iniciado sesión correctamente.
    </div>

    <!-- REGISTRAR USUARIO -->
    <h2>Registrar usuario</h2>

    <form
        class="formulario-registro"
        action="<?= site_url('usuarios/guardar') ?>"
        method="post"
    >
        <?= csrf_field() ?>

        <label for="nombre">Nombre:</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            required
        >

        <label for="usuario">Usuario:</label>
        <input
            type="text"
            id="usuario"
            name="usuario"
            required
        >

        <label for="password">Contraseña:</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <button type="submit">
            Guardar usuario
        </button>
    </form>

    <!-- LISTADO DE USUARIOS -->
    <h2>Usuarios registrados</h2>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= esc($usuario['id']) ?></td>
                        <td><?= esc($usuario['nombre']) ?></td>
                        <td><?= esc($usuario['usuario']) ?></td>

                        <td class="acciones">

                            <!-- EDITAR -->
                            <a
                                class="btn-editar"
                                href="<?= site_url('usuarios/editar/' . $usuario['id']) ?>"
                            >
                                Editar
                            </a>

                            <!-- BORRAR -->
                            <form
                                class="formulario-inline"
                                action="<?= site_url('usuarios/eliminar/' . $usuario['id']) ?>"
                                method="post"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');"
                            >
                                <?= csrf_field() ?>

                                <button
                                    type="submit"
                                    class="btn-borrar"
                                >
                                    Borrar
                                </button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
