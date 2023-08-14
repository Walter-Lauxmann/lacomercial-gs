<?php
require_once 'config.php'; // Requerimos el archivo config.php

/* Creamos la clase Conexion */
class Conexion {
    protected $_db; // Propiedad 

    // Creamos el método constructor
    public function __construct()
    {
        $this->_db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        // Si se produce un error de conexión, muestra el error
        if( $this->_db->connect_errno ) {
            echo 'Fallo al conectar a MySQL: ' . $this->_db->connect_error;
            return;
        }
        // Establecemos el conjunto de caracteres a utf8
        $this->_db->set_charset(DB_CHARSET);
        $this->_db->query("SET NAMES 'utf8'");
    }
}
/* Fin de la clase Conexion */

/**
 * Clase Modelo basada en la clase Conexion
 */
class Modelo extends Conexion {
    // Propiedades
    private $tabla; // Nombre de la tabla
    private $id = 0; // id del registro
    private $criterio = ''; // Criterio para las consultas
    private $campos = '*'; // Lista de campos
    private $orden = 'id'; // Campos de ordenamiento
    private $limite = 0; // Cantidad de registros

    /**
     * Método constructor
     * @param: t la tabla de la base de datos 
     */ 
    public function __construct($t)
    {
        parent::__construct(); // Ejecutamos el constructor padre
        $this->tabla = $t; // Asignamos a la propiedad $tabla el parámetro $t
    }

    /* Getter */
    public function get_tabla() {
        return $this->tabla;
    }
    
    public function get_id() {
        return $this->id;
    }
    public function get_criterio() {
        return $this->criterio;
    }
    public function get_campos() {
        return $this->campos;
    }
    public function get_orden() {
        return $this->orden;
    }
    public function get_limite() {
        return $this->limite;
    }
   
    /* Setter */
    public function set_tabla($tabla) {
        $this->tabla = $tabla;
    }    
    public function set_id($id) {
        $this->id = $id;
    }
    public function set_criterio($criterio) {
        $this->criterio = $criterio;
    }
    public function set_campos($campos) {
        $this->campos = $campos;
    }
    public function set_orden($orden) {
        $this->orden = $orden;
    }
    public function set_limite($limite) {
        $this->limite = $limite;
    }


    /**
     * Método de selección.
     * Selecciona los registros de una tabla
     * y los devuelve en formato JSON
     * @return datos los datos en formato JSON
     */
    public function seleccionar() {
        // SELECT * FROM articulos WHERE nombre LIKE '%samsung%' ORDER BY id LIMIT 10
        $sql = "SELECT $this->campos FROM $this->tabla";
        // Si el criterio NO es igual a NADA
        if($this->criterio != '') {
            $sql .= " WHERE $this->criterio"; // DONDE criterio
        }
        // Agregamos el ordenamiento
        $sql .= " ORDER BY $this->orden";
        // Si el límite es mayor que cero
        if($this->limite > 0) {
            $sql .= " LIMIT $this->limite";
        }
        // echo $sql . '<br>'; // Mostramos la instrucción SQL resultante
        // Ejecutamos la consulta y la guardamos en $resultado
        $resultado = $this->_db->query($sql);
        // Obtenemos el resultado en array asociativo y lo transformamos a JSON
        $datos = json_encode($resultado->fetch_all(MYSQLI_ASSOC));
        // Retornamos los datos
        return $datos;
    }
}