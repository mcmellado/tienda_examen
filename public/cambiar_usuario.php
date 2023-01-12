<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Cambiar contraseña</title>
</head>

<body>
    <?php

    require '../vendor/autoload.php';
    

    $password = obtener_post('login');
    $newpassword = obtener_post('newlogin');

    $clases_label = [];
    $clases_input = [];
    $error = ['login' => [], 'newlogin' => []];

    $clases_label_error = "text-red-700 dark:text-red-500";
    $clases_input_error = "bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:bg-red-100 dark:border-red-400";

    foreach (['login', 'newlogin'] as $e) {
        $clases_label[$e] = '';
        $clases_input[$e] = '';
    }

    if (isset($password, $newpassword, $passwordrepeat)) {

        $pdo = conectar();
        $usuario = \App\Tablas\Usuario::logueado();
        $id = $usuario->obtenerId();

        // Recoge la contraseña actual
        $sent = $pdo->prepare("SELECT usuario
                        FROM usuarios
                        WHERE id = :id");
        $sent->execute([':id' => $id]);
        $origin = $sent->fetchColumn();

        if ($login == '') {
            $error['login'][] = 'El usuario es obligatorio.';
        } 

        if ($newlogin == '') {
            $error['newlogin'][] = 'El nuevo nombre es obligatorio';
        }

        $vacio = true;

        foreach ($error as $err) {
            if (!empty($err)) {
                $vacio = false;
                break;
            }
        }

        if ($vacio) {
            $usuario->cambiar_usuario($usuario, $newpassword, $pdo);
            $_SESSION['exito'] = 'El nombre de usuario se ha modificado correctamente.';

            return volver();
        }
    }




    ?>

    <!-- Esto es para modificar la contraseña-->
    <div class="container mx-auto">
        <?php require '../src/_menu.php' ?>
        <div class="mx-72">
            <form action="" method="POST">
                <div class="mb-6">
                    <label for="newlogin" class="block mb-2 text-sm font-medium <?= $clases_label['newlogin'] ?>"> Escribe el nuevo nombre para el usuario: </label>
                        <input type="newlogin" name="newlogin" id="newlogin" class="border text-sm rounded-lg block w-full p-2.5 <?= $clases_input['newlogin'] ?>">
                        <?php foreach ($error['newlogin'] as $err) : ?>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-bold">¡Error!</span> <?= $err ?></p>
                    <?php endforeach ?>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cambiar nombre</button>
            </form>
        </div>
    </div>

    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>