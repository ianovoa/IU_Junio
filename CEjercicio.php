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

    Switch ($_REQUEST['action']){
        case 'alta':
            if(!$_REQUEST['nombreEj']){
                new VAltaEjercicio();
            }
            else{
                $nombreEj=$_REQUEST['nombreEj'];
                $descripcionEj=$_REQUEST['descripcionEj'];

                $ejercicio=new MEjercicio("",$nombreEj,$descripcionEj);
                $respuesta=$ejercicio->insert();
                new MESSAGE_View($respuesta, "./index.php");
            }
            break;
    
        case 'baja':
            if(!$_REQUEST['idEjercicio']){
                $modelo=new MEjercicio("","","");
                $listaEjercicios=$selectAll->select();
                $vista=new VBajaEjercicio($listaEjercicios);
                $idEjercicio=$_REQUEST['idEjercicio'];
                $modelo=new MEjercicio($idEjercicio,"","");
                $ejercicioBorrar=$modelo->selectID();
                $vista->solicitarConfirmacion($ejercicioBorrar);
            }
            else{
                if($_REQUEST['confirmar']=="Si"){ //si el usuario confirma q quiere borrar el ej
                    $idEjercicio=$_REQUEST['idEjercicio'];

                    $ejercicio=new MEjercicio($idEjercicio,"","");
                    $respuesta=$ejercicio->delete();
                    new MESSAGE($respuesta, "./index.php");
                }
            }
            break;
    
        case 'consulta':
            if(!$_REQUEST['nombreEj']){
                new VConsultarEjercicio(); //psa
            }
            else{
                $nombreEj=$_REQUEST['nombreEj'];

                $ejercicio=new MEjercicio("",$nombreEj,"");
                $resultado=$ejercicio->select();
                VConsultarEjercicio::mostrar($resultado);
            }
            break;
    
        case 'modificacion':
            if(!$_REQUEST['idEjercicio']){
                $selectAll=new MEjercicio("","","");
                $listaEjercicios=$selectAll->select();
                $vista=new VModificarEjercicio($listaEjercicios); //asi conseguimos la id del ejrcicio a modificar 
                $vista->mostrarFormulario(); //luego se envia a un formulario para editar
            }
            else{
                $idEjercicio=$_REQUEST['idEjercicio'];
                $nombreEj=$_REQUEST['nombreEj'];
                $descripcionEj=$_REQUEST['descripcionEj'];

                $ejercicio=new MEjercicio($idEjercicio,$nombreEj,$descripcionEj);
                $respuesta=$ejercicio->update();
                new MESSAGE($respuesta,"./index.php");
            }
            break;
    }
    
//    private function showAllEjercicio(){
//        $ejercicio=new MEjercicio("","","");
//        return $ejercicio->select();
//    }
//}
?>
