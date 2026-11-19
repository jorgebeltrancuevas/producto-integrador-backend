<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de imágenes - MVC</title>

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
            max-width: 1100px;
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
        }

        .bienvenida {
            background: var(--verde-suave);
            color: var(--verde-profundo);
            padding: 14px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .formulario {
            background: var(--marfil);
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input[type="file"], select {
            width: 100%;
            padding: 11px;
            border: 1px solid var(--borde-control);
            border-radius: 5px;
            background: var(--superficie);
            margin-bottom: 15px;
        }

        button, .boton {
            display: inline-block;
            padding: 11px 18px;
            background: var(--verde-oscuro);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button:hover, .boton:hover {
            opacity: 0.9;
        }

        .btn-salir {
            background: var(--texto-secundario);
        }

        .btn-eliminar {
            background: var(--peligro);
            width: 100%;
            margin-top: 10px;
        }

        .btn-organizar {
            background: var(--verde-oscuro);
            width: 100%;
        }

        .btn-volver {
            background: var(--texto-secundario);
        }

        .mensaje {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .filtros {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .filtros select {
            margin-bottom: 0;
            min-width: 180px;
        }

        .galeria {
            display: grid;
            grid-template-columns:
                repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .tarjeta {
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 12px;
            background: var(--superficie);
        }

        .tarjeta img {
            width: 100%;
            height: 170px;
            object-fit: cover;
            border-radius: 5px;
        }

        .nombre {
            font-size: 12px;
            color: var(--texto-secundario);
            overflow-wrap: anywhere;
            margin: 10px 0;
        }

        .categoria {
            font-size: 14px;
            margin-bottom: 12px;
        }

        .vacio {
            color: var(--texto-secundario);
            text-align: center;
            padding: 35px;
            background: var(--marfil);
            border-radius: 8px;
        }

        .acciones {
            margin-top: 15px;
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
            <h1>Administración de imágenes</h1>
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
        <strong>
            <?= esc(session()->get('nombre') ?? 'Usuario') ?>
        </strong>.
        Administra tus imágenes desde este panel.
    </div>

    <!-- MENSAJES -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="mensaje">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <!-- SUBIR IMAGEN -->
    <div class="formulario">
        <h2>Subir nueva imagen</h2>

        <form
            action="<?= site_url('imagenes/subir') ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <?= csrf_field() ?>

            <label for="imagen">
                Selecciona una imagen:
            </label>

            <input
                type="file"
                id="imagen"
                name="imagen"
                accept=".jpg,.jpeg,.png,.gif,.webp"
                required
            >

            <label for="categoria">
                Categoría:
            </label>

            <select id="categoria" name="categoria" required>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= esc($categoria, 'attr') ?>">
                        <?= esc($categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="subtitulo">
                Formatos permitidos: JPG, PNG, GIF y WebP.
                Tamaño máximo: 5 MB.
            </p>

            <button type="submit">
                Subir imagen
            </button>
        </form>
    </div>

    <!-- FILTRAR IMÁGENES -->
    <h2>Galería de imágenes</h2>

    <form
        action="<?= site_url('imagenes') ?>"
        method="get"
        class="filtros"
    >
        <div>
            <label for="filtroCategoria">
                Filtrar por categoría:
            </label>

            <select
                id="filtroCategoria"
                name="categoria"
            >
                <option value="">Todas las categorías</option>

                <?php foreach ($categorias as $categoria): ?>
                    <option
                        value="<?= esc($categoria, 'attr') ?>"
                        <?= $categoriaActual === $categoria ? 'selected' : '' ?>
                    >
                        <?= esc($categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">
            Filtrar
        </button>

        <a href="<?= site_url('imagenes') ?>" class="boton btn-volver">
            Mostrar todas
        </a>
    </form>

    <!-- GALERÍA -->
    <?php if (empty($imagenes)): ?>

        <div class="vacio">
            No hay imágenes registradas en esta categoría.
        </div>

    <?php else: ?>

        <div class="galeria">

            <?php foreach ($imagenes as $imagen): ?>

                <div class="tarjeta">

                    <img
                        src="<?= esc($imagen['url'], 'attr') ?>"
                        alt="Imagen registrada"
                        loading="lazy"
                    >

                    <p class="nombre">
                        <?= esc($imagen['nombre']) ?>
                    </p>

                    <p class="categoria">
                        <strong>Categoría:</strong>
                        <?= esc($imagen['categoria']) ?>
                    </p>

                    <!-- CAMBIAR CATEGORÍA -->
                    <form
                        action="<?= site_url('imagenes/organizar') ?>"
                        method="post"
                    >
                        <?= csrf_field() ?>

                        <input
                            type="hidden"
                            name="id"
                            value="<?= esc($imagen['id'], 'attr') ?>"
                        >

                        <label>Cambiar categoría:</label>

                        <select name="categoria" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option
                                    value="<?= esc($categoria, 'attr') ?>"
                                    <?= $imagen['categoria'] === $categoria
                                        ? 'selected'
                                        : '' ?>
                                >
                                    <?= esc($categoria) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button
                            type="submit"
                            class="btn-organizar"
                        >
                            Guardar categoría
                        </button>
                    </form>

                    <!-- ELIMINAR IMAGEN -->
                    <form
                        action="<?= site_url('imagenes/eliminar') ?>"
                        method="post"
                        class="acciones"
                        onsubmit="return confirm('¿Deseas eliminar esta imagen?');"
                    >
                        <?= csrf_field() ?>

                        <input
                            type="hidden"
                            name="nombre"
                            value="<?= esc($imagen['nombre'], 'attr') ?>"
                        >

                        <button
                            type="submit"
                            class="btn-eliminar"
                        >
                            Eliminar imagen
                        </button>
                    </form>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <div style="margin-top: 30px;">
        <a
            href="<?= site_url('usuarios') ?>"
            class="boton btn-volver"
        >
            Volver a usuarios
        </a>
    </div>

</div>

</body>
</html>
