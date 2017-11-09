<?php
//FALTA MENSAJE_VIEW
/**
 * Aqui creamos la conexion a la base de datos
 *
 * @author iago
 */

function conexionBD(){
    $mysqli = new mysqli("localhost", 'admin', 'admin' , 'ProyectoABP'); //host,user,passUser,BD
    	
    if ($mysqli->connect_errno) {
        include './MESSAGE_View.php';
        new MESSAGE("Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") \n" . $mysqli->connect_error,"./index.php");
        return false;
    }
    else{
        return $mysqli;
    }
}

function desconexionBD($mysqli){
    $mysqli->close();
}
?>
