<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario - Producto integrador Backend</title>

    <link rel="stylesheet" href="<?= esc(base_url('css/tema.css'), 'attr') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: var(--marfil);
            margin: 0;
            padding: 50px 20px;
        }

        .contenedor {
            max-width: 700px;
            margin: auto;
            background: var(--superficie);
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            color: var(--verde-profundo);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 1px solid var(--borde-control);
            border-radius: 4px;
        }

        button {
            background: var(--verde-oscuro);
            color: white;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            cursor: pointer;
        }

        .cancelar {
            display: inline-block;
            margin-left: 15px;
            color: var(--texto-secundario);
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Editar usuario</h1>

    <p>Producto integrador - Lenguajes de programación Backend</p>

    <form action="<?= site_url('usuarios/actualizar/' . $usuario['id']) ?>"
          method="post">

        <?= csrf_field() ?>

        <label>Nombre:</label>
        <input
            type="text"
            name="nombre"
            value="<?= esc($usuario['nombre'], 'attr') ?>"
            required
        >

        <label>Usuario:</label>
        <input
            type="text"
            name="usuario"
            value="<?= esc($usuario['usuario'], 'attr') ?>"
            required
        >

        <label>Nueva contraseña (opcional):</label>
        <input
            type="password"
            name="password"
            placeholder="Dejar vacío para conservar la actual"
        >

        <button type="submit">
            Guardar cambios
        </button>

        <a class="cancelar"
           href="<?= site_url('usuarios') ?>">
            Cancelar
        </a>

    </form>

</div>

</body>
</html>
