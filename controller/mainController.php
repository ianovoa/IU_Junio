<?php
/**
 * En este archivo se detallara el controlador
 *
 * @author iago
 */
 
//Inicio sesion
//session_start();

//incluidos todas las vistas y el modelo
//include '../model/MEjercicio.php';

switch ($_REQUEST['action']){
	case 'analizar': //se realiza el analisis del codigo
		$codeName=$_FILES['code']['name'];
		move_uploaded_file($_FILES['code']['tmp_name'],'../CodigoAExaminar/'.$_FILES['code']['name']);
		break;
	
	case 'verAnalisis': //se muestra el resultado del analisis
		
		break;
	
	
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
