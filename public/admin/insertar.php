<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Insertar articulos</title>
</head>
<body>
<div class="container mx-auto">
        <?php require '../../vendor/autoload.php'; ?>
        
        <?php

        $descripcion = obtener_get('descripcion');
        $precio = obtener_get('precio');
        $existencias = obtener_get('existencias');
        $categoria = obtener_get('categoria');
        $codigo = obtener_get('codigo');

        $pdo = conectar();

        if(isset($descripcion)) {

            $sent = $pdo->prepare("INSERT INTO articulos (codigo, descripcion,
                                 precio, existencias, categoria)
                                 VALUES (:codigo, :descripcion,
                                 :precio, :existencias, :categoria)");
            
            $sent->execute([
                ':codigo' => $codigo,
                ':descripcion' => $descripcion,
                ':precio' => $precio,
                'existencias' => $existencias,
                ':categoria' => $categoria
            ]);
    
    
            $_SESSION['exito'] = 'El artículo se ha añadido correctamente.';
            return volver_admin();
        }    


        ?>

        <div class="mx-72">
            <form action="" method="GET">
                <div class="mb-6">
                    <label for="descripcion" class="block mb-2 text-sm font-medium">Descripcion:</label>
                    <input type="text" name="descripcion" id="descripcion" class="border text-sm rounded-lg block w-full p-2.5">
                </div>
                <div class="mb-6">
                    <label for="codigo" class="block mb-2 text-sm font-medium">Codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="border text-sm rounded-lg block w-full p-2.5">
                </div>
                <div class="mb-6">
                    <label for="precio" class="block mb-2 text-sm font-medium">Precio:</label>
                    <input type="text0" name="precio" id="precio" class="border text-sm rounded-lg block w-full p-2.5">
                </div>

                <div class="mb-6">
                    <label for="existencias" class="block mb-2 text-sm font-medium">Existencias:</label>
                    <input type="text" name="existencias" id="existencias" class="border text-sm rounded-lg block w-full p-2.5">
                </div>

                <div class="mb-6">
                    <label for="categoria" class="block mb-2 text-sm font-medium">Categoria:</label>
                    <input type="text" name="categoria" id="categoria" class="border text-sm rounded-lg block w-full p-2.5">
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear articulo</button>
            </form>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>