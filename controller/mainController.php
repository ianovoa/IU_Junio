<?php
/**
 * En este archivo se detallará el controlador principal
 *
 * @author iago
 */

//incluidos todas las vistas y el modelo
include '../controller/analizarController.php';
include '../controller/confController.php';
include '../view/analisisView.php';

switch ($_REQUEST['action']){
	case 'analizar': //se realiza el análisis del codigo
		$codeName=$_FILES['code']['name'];
		if(!move_uploaded_file($_FILES['code']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/CodigoAExaminar/'.$_FILES['code']['name'])) echo $codeName." no está se ha ido a por tabaco";
		else{
            $directorios=comprobarDirectorio(); //comprueba que los directorios sean los de Directories.conf
            $fileName=comprobarFileName(); //comprueba que los archivos tengan nombres permitidos en File.conf
            $tipoFile=comprobarTipoFile(); //comprueba que los archivos tengan el tipo correcto
            $cabeceras=comprobarCabeceras(); //comprueba la cabecera de los archivos de código
            $comentarios=comprobarComentarios(); //comprueba los comentarios de los archivos de código
            
            $vistaAnalisis=new analisisView($directorios,$fileName,$tipoFile,$cabeceras,$comentarios); //muestra los resultados del analisis
		}
		break;
	
    /*case 'alta':
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
            header("location: mainController.php?action=verAnalisis");
        }
        break;*/
}
?>
