<?php
// Requerimos el archivo modelos.php donde se encuentra la Clase Modelo
require_once 'modelos.php';

if(isset($_GET['tabla'])) { // Si está seteado $_GET['tabla']
    $tabla = new Modelo($_GET['tabla']); // Creamos el objeto $tabla

    if(isset($_GET['accion'])){ // Si está seteada GET['accion']
        if($_GET['accion'] == 'insertar'){ // Si la accion es insertar
            $valores = $_POST; // Tomamos lo que viene del post
        }
    }

    switch($_GET['accion']){    // Según la acción
        case 'seleccionar':         // En caso que sea seleccionar
            $datos= $tabla->seleccionar();  // Ejecutamos el método seleccionar()
            echo $datos ;                   // Mostramos los datos
            break;

        case 'insertar':            // En caso que sea insertar              
            $tabla->insertar($valores);     // Ejecutamos el método insertar()
            $mensaje .= 'Datos guardados';  // Creamos un mensaje
            echo json_encode($mensaje);     // Devolvemos el mensaje en formato JSON
            break;
    }
}
?>