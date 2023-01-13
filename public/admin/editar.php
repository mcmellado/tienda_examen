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
        $id = obtener_get('id');
        $descripcion = obtener_post('descripcion');
        $precio = obtener_post('precio');
        $existencias = obtener_post('existencias');
        $categoria = obtener_post('categoria');
        $codigo = obtener_post('codigo');

        $pdo = conectar();

        $set = [];
        $execute = [];

        
        if (isset($codigo) && $codigo != "") {
            $set[] = 'codigo = :codigo';
            $execute[':codigo'] = $codigo;
        }

        if (isset($descripcion) && $descripcion != "") {
            $set[] = 'descripcion = :descripcion';
            $execute[':descripcion'] = $descripcion;
        }

        if (isset($precio) && $precio != "") {
            $set[] = 'precio = :precio';
            $execute[':precio'] = $precio;
        }

        if (isset($existencias) && $existencias != "") {
            $set[] = 'existencias = :existencias';
            $execute[':existencias'] = $existencias;
        }

        if (isset($categoria) && $categoria != "") {
            $set[] = 'categoria = :categoria';
            $execute[':categoria'] = $categoria;
        }

    

        if(isset($id) && $id != null) {
            $execute[':id'] = $id;
            }

        var_dump($execute);


        $set = !empty($set) ? 'SET ' . implode(' , ', $set) : '';

        if (obtener_post('testigo') !== null) {
            var_dump("entra");
            
            $sent = $pdo->prepare("UPDATE articulos $set WHERE id = :id");
            $sent->execute($execute);
    
            $_SESSION['exito'] = 'El artículo se ha añadido correctamente.';
            return volver_admin();
        }    


        ?>

        <div class="mx-72">
            <form action="" method="POST">
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
                <input type="hidden" name="testigo" value="1">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Modificar articulo</button>
            </form>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>