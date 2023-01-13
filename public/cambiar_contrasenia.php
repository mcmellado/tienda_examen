<?php

use App\Tablas\Usuario;

 session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Portal</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    $passwordold = obtener_post('passwordold');
    $passwordnew = obtener_post('passwordnew');
    $passwordnew_repeat = obtener_post('passwordnew_repeat');

    $clases_label = [];
    $clases_input = [];
    $error = ['passwordold' => [], 'passwordnew' => [], 'passwordnew_repeat' => []];

    $clases_label_error = "text-red-700 dark:text-red-500";
    $clases_input_error = "bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:bg-red-100 dark:border-red-400";

    foreach (['passwordold', 'passwordnew', 'passwordnew_repeat'] as $e) {
        $clases_label[$e] = '';
        $clases_input[$e] = '';
    }

    if (isset($passwordold, $passwordnew, $passwordnew_repeat)) {
        $pdo = conectar();
        $usuario = App\Tablas\Usuario::logueado();
        $id = $usuario->obtenerId();

        $sent = $pdo->prepare("SELECT password FROM usuarios WHERE id = :id");
        $sent->execute([':id' => $id]);

        $contrasenia_actual = $sent->fetchColumn();
        var_dump($id);

        if (!password_verify($passwordold, $contrasenia_actual)) {
            $error['passwordold'][] = 'No has introducido correctamente la contraseña antigua';
        }

        if ($passwordold == '') {
            $error['passwordold'][] = 'La contraseña antigua es obligatoria';
        }

        if ($passwordnew != $passwordnew_repeat) {
            $error['passwordnew'][] = 'Las contraseñas no coinciden.';
        }

        if ($passwordnew == '') {
            $error['passwordnew'][] = 'La contraseña es obligatoria.';
        }

        if ($passwordnew_repeat == '') {
            $error['passwordnew_repeat'][] = 'La contraseña es obligatoria.';
        }
        if (mb_strlen($passwordnew) < 8) {
            $error['passwordnew'][] = 'La contraseña tiene que tener mínimo 8 carácteres';
        }
        if (preg_match('/[a-z]/', $passwordnew) !== 1) {
            $error['passwordnew'][] = 'La contraseña tiene que tener al menos 1 minúscula';
        }

        if (preg_match('/[A-Z]/', $passwordnew) !== 1) {
            $error['passwordnew'][] = 'La contraseña tiene que tener al menos 1 mayúscula';
        }

        if (preg_match('/[[:digit:]]/', $passwordnew) !== 1) {
            $error['passwordnew'][] = 'La contraseña tiene que tener al menos 1 dígito';
        }

        if (preg_match('/[[:punct:]]/', $passwordnew) !== 1) {
            $error['passwordnew'][] = 'La contraseña tiene que tener al menos 1 signo de puntuación';
        }


        $vacio = true;
        foreach ($error as $err) {
            if (!empty($err)) {
                $vacio = false;
                break;
            }
        }

        if ($vacio) {
            // Registrar
            $usuario->cambiar_contrasenia($usuario, $passwordnew, $pdo);
            $_SESSION['exito'] = 'El usuario ha modificado la contraseña correctamente.';
            return volver();
            }
        }
    ?>
    <div class="container mx-auto">
        <?php require '../src/_menu.php' ?>
        <div class="mx-72">
            <form action="" method="POST">
                <div class="mb-6">
                    <label for="passwordold" class="block mb-2 text-sm font-medium <?= $clases_label['passwordold'] ?>">Antigua contraseña:</label>
                    <input type="password" name="passwordold" id="passwordold" class="border text-sm rounded-lg block w-full p-2.5 <?= $clases_input['passwordold'] ?>" value="">
                    <?php foreach($error['passwordold'] as $resultado): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $resultado ?> </p>
                    <?php endforeach ?>
                </div>
                <div class="mb-6">
                    <label for="passwordnew" class="block mb-2 text-sm font-medium <?= $clases_label['passwordnew'] ?>">Nueva contraseña:</label>
                    <input type="password" name="passwordnew" id="passwordnew" class="border text-sm rounded-lg block w-full p-2.5  <?= $clases_input['passwordnew'] ?>">
                    <?php foreach($error['passwordnew'] as $resultado): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $resultado ?></p>
                    <?php endforeach ?>
                </div>
                <div class="mb-6">
                    <label for="passwordnew_repeat" class="block mb-2 text-sm font-medium <?= $clases_label['passwordnew_repeat'] ?>">Confirmar contraseña:</label>
                    <input type="password" name="passwordnew_repeat" id="passwordnew_repeat" class="border text-sm rounded-lg block w-full p-2.5  <?= $clases_input['passwordnew_repeat'] ?>">
                    <?php foreach($error['passwordnew_repeat'] as $resultado): ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $resultado ?></p>
                    <?php endforeach ?>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cambiar contraseña</button>
            </form>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
