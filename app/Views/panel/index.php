<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel principal - Producto integrador Backend</title>

    <link rel="stylesheet" href="<?= esc(base_url('css/tema.css'), 'attr') ?>">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--marfil);
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1050px;
            margin: 35px auto;
            background: var(--superficie);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(16,59,40,0.08);
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitulo {
            color: var(--texto-secundario);
            margin-top: 0;
        }

        .bienvenida {
            background: var(--verde-suave);
            color: var(--verde-profundo);
            padding: 18px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .modulos {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
            margin-top: 25px;
        }

        .tarjeta {
            border: 1px solid var(--borde);
            border-top: 3px solid var(--verde);
            border-radius: 10px;
            padding: 28px 20px;
            text-align: center;
            background: var(--marfil);
        }

        .icono {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .tarjeta h2 {
            margin: 12px 0;
        }

        .tarjeta p {
            color: var(--texto-secundario);
            line-height: 1.5;
            min-height: 65px;
        }

        .boton, button {
            display: inline-block;
            padding: 12px 18px;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .boton {
            width: 100%;
            margin-top: 12px;
        }

        .boton:hover, button:hover {
            opacity: 0.9;
        }

        .usuarios {
            background: var(--verde-oscuro);
        }

        .imagenes {
            background: var(--amarillo);
            color: var(--verde-profundo);
        }

        .documentos {
            background: var(--verde-oscuro);
        }

        .salir {
            background: var(--texto-secundario);
        }

        .pie {
            margin-top: 35px;
            text-align: center;
            color: var(--texto-secundario);
            font-size: 13px;
            border-top: 1px solid var(--borde);
            padding-top: 20px;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .contenedor {
                margin: 10px auto;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <!-- ENCABEZADO -->
    <div class="encabezado">
        <div>
            <h1>Sistema de administración MVC</h1>
            <p class="subtitulo">
                Producto integrador -
                Lenguajes de programación Backend
            </p>
        </div>

        <form action="<?= site_url('login/salir') ?>" method="post">
            <?= csrf_field() ?>

            <button type="submit" class="salir">
                Cerrar sesión
            </button>
        </form>
    </div>

    <!-- BIENVENIDA -->
    <div class="bienvenida">
        Bienvenido,
        <strong>
            <?= esc(session()->get('nombre') ?? 'Usuario') ?>
        </strong>.
        Selecciona el módulo que deseas utilizar.
    </div>

    <!-- MÓDULOS -->
    <div class="modulos">

        <?php if ($esAdministrador): ?>
        <!-- USUARIOS -->
        <div class="tarjeta">
            <div class="icono">👥</div>

            <h2>Usuarios</h2>

            <p>
                Registrar, consultar, editar
                y eliminar usuarios del sistema.
            </p>

            <a
                href="<?= site_url('usuarios') ?>"
                class="boton usuarios"
            >
                Administrar usuarios
            </a>
        </div>
        <?php endif; ?>

        <!-- IMÁGENES -->
        <div class="tarjeta">
            <div class="icono">🖼️</div>

            <h2>Imágenes</h2>

            <p>
                Subir, visualizar, organizar
                y eliminar imágenes.
            </p>

            <a
                href="<?= site_url('imagenes') ?>"
                class="boton imagenes"
            >
                Administrar imágenes
            </a>
        </div>

        <!-- DOCUMENTOS -->
        <div class="tarjeta">
            <div class="icono">📁</div>

            <h2>Documentos</h2>

            <p>
                Generar y descargar archivos
                Word, Excel, PDF y PNG.
            </p>

            <a
                href="<?= site_url('documentos') ?>"
                class="boton documentos"
            >
                Generar documentos
            </a>
        </div>

    </div>

    <!-- PIE DE PÁGINA -->
    <div class="pie">
        Proyecto desarrollado con PHP,
        CodeIgniter 4 y MySQL.
        <p>
            IH726 - Lenguajes de programación Backend
        </p>
    </div>

</div>

</body>
</html>
