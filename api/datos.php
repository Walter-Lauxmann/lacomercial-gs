<?php
// Requerimos el archivo modelos.php donde se encuentra la Clase Modelo
require_once 'modelos.php';

if(isset($_GET['tabla'])) { // Si está seteado $_GET['tabla']
    $tabla = new Modelo($_GET['tabla']); // Creamos el objeto $tabla

    $datos = $tabla->seleccionar(); // Ejecutamos el método seleccionar()
    echo $datos; // Mostramos los datos
}
?>