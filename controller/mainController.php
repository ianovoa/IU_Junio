<?php
/**
 * En este archivo se detallara el controlador de ejercicio
 *
 * @author iago
 */
session_start();
//incluidos todas las vistas y el modelo de ejercicio
include '../model/MEjercicio.php';
include '../view/VAltaEjercicio.php';
include '../view/VBajaEjercicio.php';
include '../view/VModificarEjercicio.php';
include '../view/VConsultarEjercicio.php';
include '../view/VVerDetalleEjercicio.php';
include '../view/VPrincipalEjercicio.php';
include '../view/VShowAllEjercicio.php';
include '../view/VVerEjercicio.php';
include '../view/MESSAGE_View.php';
include "../core/Login.php";
estaRegistrado();
switch ($_REQUEST['action']){
    case 'alta':
        if(!isset($_POST['nombreEj'])){
            new VAltaEjercicio();
        }
        else{
            $nombreEj=$_POST['nombreEj'];
            $descripcionEj=$_POST['descripcionEj'];
            $tipoEj=$_POST['tipoEj'];
            $ejercicio=new MEjercicio("",$nombreEj,$descripcionEj,$tipoEj);
            $respuesta=$ejercicio->insert();
            new MESSAGE_View($respuesta, "../controller/CEjercicio.php?action=principal");
        }
        break;
    
    case 'baja':
        if(!isset($_POST['confirmar'])) {
            $idEjercicio=$_GET['idEjercicio'];
            
            $modelo=new MEjercicio($idEjercicio,"","","");
            $ejercicioBorrar=$modelo->selectID();
            new VBajaEjercicio($ejercicioBorrar);
        }
        else{
            if($_POST['confirmar']=="si"){ //si el usuario confirma q quiere borrar el ej
                $idEjercicio=$_POST['idEjercicio'];
                $ejercicio=new MEjercicio($idEjercicio,"","","");
                $respuesta=$ejercicio->delete();
                new MESSAGE_View($respuesta, "../controller/CEjercicio.php?action=principal");
            }
            else{
                header("location: CEjercicio.php?action=principal");
            }
        }
        break;
    
    case 'consulta':
        if(!isset($_POST['tipoEj']) && !isset($_POST['nombreEj'])){
            new VConsultarEjercicio();
        }
        else{
            $nombreEj=$_POST['nombreEj'];
            if(isset($_POST['tipoEj'])) $tipoEj=$_POST['tipoEj'];
            else $tipoEj="";
            $ejercicio=new MEjercicio("",$nombreEj,"",$tipoEj);
            $resultado=$ejercicio->select();
            new VShowAllEjercicio($resultado,"Resultado de busqueda");
        }
        break;
            
    case 'verDetalle':
        $idEjercicio=$_GET['idEjercicio'];
        $modelo=new MEjercicio($idEjercicio,"","","");
        $ejercicio=$modelo->selectID();
        new VVerDetalleEjercicio($ejercicio);
        break;
    
    case 'modificacion':
        if (!isset($_POST['nombreEj']) && !isset($_POST['descripcionEj']) && !isset($_POST['tipoEj'])) {
            $idEjercicio=$_GET['idEjercicio'];
            new VModificarEjercicio($idEjercicio); //se envia a un formulario para editar
        }
        else{
            $idEjercicio=$_POST['idEjercicio'];
            $nombreEj=$_POST['nombreEj'];
            $descripcionEj=$_POST['descripcionEj'];
            $tipoEj=$_POST['tipoEj'];
            $ejercicio=new MEjercicio($idEjercicio,$nombreEj,$descripcionEj,$tipoEj);
            $respuesta=$ejercicio->update();
            new MESSAGE_View($respuesta,"../controller/CEjercicio.php?action=principal");
        }
        break;
    case 'principal':
        $vista=new VPrincipalEjercicio();
        if($_SESSION['Id_PerfilUsuario']==2) $vista->vistaEntrenador();
        else header("location: ../index.php");
        break;
    
    case 'verEjercicio':
        new VVerEjercicio();
        break;
    
    case 'showAll':
        $tipoEj=$_GET['tipoEj'];
        
        $ejercicio=new MEjercicio("","","",$tipoEj);
        $resultado=$ejercicio->select();
        new VShowAllEjercicio($resultado,$tipoEj);
        break;
}
?>