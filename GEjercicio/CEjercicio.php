<?php
/**
 * En este archivo se detallara el controlador de ejercicio
 *
 * @author iago
 */

//incluidos todas las vistas y el modelo de ejercicio
include 'MEjercicio.php';
include 'Vistas/VAltaEjercicio.php';
include 'Vistas/VBajaEjercicio.php';
include 'Vistas/VModificarEjercicio.php';
include 'Vistas/VConsultarEjercicio.php';
include 'Vistas/MESSAGE_View.php';

    switch ($_REQUEST['action']){
        case 'alta':
            if(!isset($_REQUEST['nombreEj'])){
                new VAltaEjercicio();
            }
            else{
                $nombreEj=$_REQUEST['nombreEj'];
                $descripcionEj=$_REQUEST['descripcionEj'];

                $ejercicio=new MEjercicio("",$nombreEj,$descripcionEj);
                $respuesta=$ejercicio->insert();
                new MESSAGE_View($respuesta, "../index.php");
            }
            break;
    
        case 'baja':
            if(!isset($_REQUEST['idEjercicio'])){
                $selectAll=new MEjercicio("","","");
                $listaEjercicios=$selectAll->select();
                new VBajaEjercicio($listaEjercicios);
            }
            elseif(!isset($_REQUEST['confirmar'])) {
                $idEjercicio=$_REQUEST['idEjercicio'];
                $modelo=new MEjercicio($idEjercicio,"","");
                $ejercicioBorrar=$modelo->selectID();
                VBajaEjercicio::solicitarConfirmacion($ejercicioBorrar);
            }
            else{
                if($_REQUEST['confirmar']=="si"){ //si el usuario confirma q quiere borrar el ej
                    $idEjercicio=$_REQUEST['idEjercicio'];

                    $ejercicio=new MEjercicio($idEjercicio,"","");
                    $respuesta=$ejercicio->delete();
                    new MESSAGE_View($respuesta, "../index.php");
                }
            }
            break;
    
        case 'consulta':
            if(!isset($_REQUEST['nombreEj'])){
                new VConsultarEjercicio();
            }
            else{
                $nombreEj=$_REQUEST['nombreEj'];

                $ejercicio=new MEjercicio("",$nombreEj,"");
                $resultado=$ejercicio->select();
                VConsultarEjercicio::mostrar($resultado);
            }
            break;
    
        case 'modificacion':
            if(!isset($_REQUEST['idEjercicio'])){
                $selectAll=new MEjercicio("","","");
                $listaEjercicios=$selectAll->select();
                new VModificarEjercicio($listaEjercicios); //asi conseguimos la id del ejercicio a modificar 
            }
            elseif (!isset($_REQUEST['nombreEj']) && !isset($_REQUEST['descripcionEj'])) {
                $idEjercicio=$_REQUEST['idEjercicio'];
                VModificarEjercicio::mostrarFormulario($idEjercicio); //luego se envia a un formulario para editar
            }
            else{
                $idEjercicio=$_REQUEST['idEjercicio'];
                $nombreEj=$_REQUEST['nombreEj'];
                $descripcionEj=$_REQUEST['descripcionEj'];

                $ejercicio=new MEjercicio($idEjercicio,$nombreEj,$descripcionEj);
                $respuesta=$ejercicio->update();
                new MESSAGE_View($respuesta,"../index.php");
            }
            break;
    }
?>