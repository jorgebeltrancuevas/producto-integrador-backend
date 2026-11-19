
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generación de documentos - MVC</title>

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
            max-width: 1000px;
            margin: auto;
            background: var(--superficie);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(16,59,40,0.08);
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitulo {
            color: var(--texto-secundario);
            margin-bottom: 25px;
        }

        .bienvenida {
            background: var(--verde-suave);
            color: var(--verde-profundo);
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .galeria {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(210px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .tarjeta {
            border: 1px solid var(--borde);
            border-radius: 10px;
            padding: 25px 20px;
            text-align: center;
            background: var(--marfil);
        }

        .icono {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .tarjeta h2 {
            margin: 10px 0;
        }

        .tarjeta p {
            color: var(--texto-secundario);
            font-size: 14px;
            min-height: 45px;
        }

        .boton, button {
            display: inline-block;
            padding: 12px 18px;
            background: var(--verde-oscuro);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .boton {
            width: 100%;
            margin-top: 12px;
        }

        .boton:hover, button:hover {
            opacity: 0.9;
        }

        .word {
            background: var(--verde-oscuro);
        }

        .excel {
            background: var(--verde-oscuro);
        }

        .pdf {
            background: var(--verde-oscuro);
        }

        .png {
            background: var(--verde-oscuro);
        }

        .salir {
            background: var(--texto-secundario);
        }

        .navegacion {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .navegacion .boton {
            width: auto;
            margin-top: 0;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .contenedor {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <!-- ENCABEZADO -->
    <div class="encabezado">
        <div>
            <h1>Generación de documentos</h1>
            <p class="subtitulo">
                Producto integrador - Lenguajes de programación Backend
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
        Selecciona el documento que deseas generar.
    </div>

    <!-- MENSAJES DE ERROR -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- OPCIONES DE DESCARGA -->
    <div class="galeria">

        <!-- WORD -->
        <div class="tarjeta">
            <div class="icono">📘</div>

            <h2>Word</h2>

            <p>
                Generar y descargar un documento
                de Microsoft Word.
            </p>

            <a
                href="<?= site_url('documentos/word') ?>"
                class="boton word"
            >
                Descargar Word
            </a>
        </div>

        <!-- EXCEL -->
        <div class="tarjeta">
            <div class="icono">📗</div>

            <h2>Excel</h2>

            <p>
                Generar y descargar una hoja
                de cálculo de Excel.
            </p>

            <a
                href="<?= site_url('documentos/excel') ?>"
                class="boton excel"
            >
                Descargar Excel
            </a>
        </div>

        <!-- PDF -->
        <div class="tarjeta">
            <div class="icono">📕</div>

            <h2>PDF</h2>

            <p>
                Generar y descargar un
                documento PDF.
            </p>

            <a
                href="<?= site_url('documentos/pdf') ?>"
                class="boton pdf"
            >
                Descargar PDF
            </a>
        </div>

        <!-- PNG -->
        <div class="tarjeta">
            <div class="icono">🖼️</div>

            <h2>Imagen PNG</h2>

            <p>
                Generar y descargar una
                imagen mediante PHP GD.
            </p>

            <a
                href="<?= site_url('documentos/png') ?>"
                class="boton png"
            >
                Descargar PNG
            </a>
        </div>

    </div>

    <!-- NAVEGACIÓN -->
    <div class="navegacion">

        <a
            href="<?= site_url('usuarios') ?>"
            class="boton"
        >
            Administración de usuarios
        </a>

        <a
            href="<?= site_url('imagenes') ?>"
            class="boton excel"
        >
            Administración de imágenes
        </a>

    </div>

</div>

</body>
</html>
