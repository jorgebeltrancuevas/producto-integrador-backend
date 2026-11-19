
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Producto integrador Backend</title>

    <link rel="stylesheet" href="<?= esc(base_url('css/tema.css'), 'attr') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: var(--marfil);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .contenedor {
            background-color: var(--superficie);
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(16,59,40,0.1);
            width: 350px;
            max-width: 85%;
        }

        h1 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            color: var(--texto-secundario);
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--borde-control);
            border-radius: 5px;
            box-sizing: border-box;
        }

        .recordar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
        }

        .recordar label {
            margin: 0;
            font-weight: normal;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--amarillo);
            color: var(--verde-profundo);
            border: none;
            border-radius: 5px;
            margin-top: 25px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: var(--amarillo-hover);
        }

        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Iniciar sesión</h1>

        <p class="subtitulo">
            Producto integrador - Lenguajes de programación Backend
        </p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/autenticar') ?>" method="post">

            <?= csrf_field() ?>

            <label for="usuario">Usuario:</label>
            <input
                type="text"
                id="usuario"
                name="usuario"
                value="<?= esc(service('request')->getCookie('usuario_recordado') ?? '') ?>"
                autocomplete="username"
                required
            >

            <label for="password">Contraseña:</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <div class="recordar">
                <input
                    type="checkbox"
                    id="recordar"
                    name="recordar"
                    value="1"
                >
                <label for="recordar">
                    Recordar mi usuario
                </label>
            </div>

            <button type="submit">
                Iniciar sesión
            </button>

        </form>

    </div>

</body>
</html>
