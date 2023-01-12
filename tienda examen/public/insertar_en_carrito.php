<?php
use App\Tablas\Articulo;
session_start();

require '../vendor/autoload.php';

try {
    $id = obtener_get('id');

    $articulo = Articulo::obtener($id);

    if ($id === null) {
        return volver();
    }

    if ($articulo->getExistencias() <= 0) {
        $_SESSION['error'] = 'No hay existencias suficientes.';
        return volver();
        }
    

    var_dump($articulo->getExistencias());

    $carrito = unserialize(carrito());
    $carrito->insertar($id);
    $_SESSION['carrito'] = serialize($carrito);
} catch (ValueError $e) {
    // TODO: mostrar mensaje de error en un Alert
}


volver();
