<?php
/**
 * Autor: Shopify
 * Fecha de creación: 06/12/2017
 * Función: Este es el controlador de trabajos, por lo tanto controla las distintas
 * operaciones posibles sobre ellos.
 */

include("../Models/Trabajo_Model.php");
include("../Views/Trabajo_SHOWALL.php");
include ("../Views/Trabajo_ADD.php");
include ("../Views/Trabajo_SEARCH.php");
include ("../Views/Trabajo_SHOWCURRENT.php");
include ("../Views/Trabajo_DELETE.php");
include ("../Views/Trabajo_EDIT.php");
include_once("../Views/MESSAGE.php");

function cargarCrearTrabajo()
{
    //cargo idiomas
    $idioma=new idiomas();
    $idiom=comprobaridioma($idioma);
    //Comprueba la sesión de ususario para mostrar el menú
    $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
    $claseCrearTrabajo=new Trabajo_ADD();
    $claseCrearTrabajo->cargar("",$idiom,$comprobarUsuarioGrupo);
}

function cargarAltaTrabajo()
{
    $IdTrabajo=$_POST['IdTrabajo'];
    $NombreTrabajo=$_POST['NombreTrabajo'];
    $FechaIniTrabajo=$_POST['FechaIniTrabajo'];
    $FechaFinTrabajo=$_POST['FechaFinTrabajo'];
    $PorcentajeNota=$_POST['PorcentajeNota'];

    // Ruta donde se guardarán las imágenes que subamos
    //$directorio = $_SERVER['DOCUMENT_ROOT'].'/56fbqn/Files/';
    // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
    //move_uploaded_file($_FILES['fotoUserAdd']['tmp_name'],$directorio.$fotopersonal);

    $modeloTrabajo=new Trabajo_Model();
    $TrabajoExistente=$modeloTrabajo->comprobarTrabajo($IdTrabajo,$NombreTrabajo);

    if($TrabajoExistente==false){
        $resultado=$modeloTrabajo->crearTrabajo($IdTrabajo,$NombreTrabajo,$FechaIniTrabajo,$FechaFinTrabajo,$PorcentajeNota);
        if($resultado==true){
            header("location: ActionController.php?action=exitoCrearTrabajo");
        }else{
            //cargo idiomas
            $idioma=new idiomas();
            $idiom=comprobaridioma($idioma);
            //Comprueba la sesión de ususario para mostrar el menú
            $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
            //cargo la vista
            $clasecrearTrabajo=new Trabajo_ADD();
            $clasecrearTrabajo->cargar("UsuarioRepe",$idiom.$comprobarUsuarioGrupo);
        }
    }else{
        //cargo el idioma
        $idioma=new idiomas();
        $idiom=comprobaridioma($idioma);
        //Comprueba la sesión de ususario para mostrar el menú
        $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
        $clasecrear=new MESSAGE();
        $clasecrear->cargar("DatosDuplicados Trabajo",$idiom,$comprobarUsuarioGrupo);

    }
}

function cargarEliminarTrabajo($IdTrabajo){
    //cargo idiomas
    $idioma=new idiomas();
    $idiom=comprobaridioma($idioma);
    //cargo el array de usuarios
    $modeloTrabajo=new Trabajo_Model();
    $datos=$modeloTrabajo->buscarPorId($IdTrabajo);
    //Comprueba la sesión de ususario para mostrar el menú
    $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
    //cargo la vista
    $claseEliminarTrabajo=new Trabajo_DELETE();
    $claseEliminarTrabajo->cargar($datos,"",$idiom,$comprobarUsuarioGrupo);
}

function cargarBajaTrabajo($IdTrabajo){
    //cargo el modelo
    $modeloTrabajo=new Trabajo_Model();
    //ejecuto la funcion de eliminar
    $resultado=$modeloTrabajo->eliminarTrabajo($IdTrabajo);
    //si elimina bien vuelve a la vista usuario_SHOWALL mostrando la lista de usuarios actualizada y con mensaje de exito
    if($resultado==true){
        header("location: ActionController.php?action=exitoEliminarTrabajo");
    }else{
        //sino muestra el mesaje de error en la vista MESSAGE
        $idioma=new idiomas();
        $idiom=comprobaridioma($idioma);
        //$datos=$modeloUser->buscarPorLogin($login);
        //Comprueba la sesión de ususario para mostrar el menú
        $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
        $claseVistaMESSAGE=new MESSAGE();
        $claseVistaMESSAGE->cargar("errorDELETE",$idiom,$comprobarUsuarioGrupo);
    }
}
//Recoge los datos del usuario de la vista usuario_EDIT.php
function modificarTrabajo(){
    $IdTrabajo=$_POST['IdTrabajo'];
    $NombreTrabajo=$_POST['NombreTrabajo'];
    $FechaIniTrabajo=$_POST['FechaIniTrabajo'];
    $FechaFinTrabajo=$_POST['FechaFinTrabajo'];
    $PorcentajeNota=$_POST['PorcentajeNota'];


    // Ruta donde se guardarán las imágenes que subamos
    //$directorio = $_SERVER['DOCUMENT_ROOT'].'/56fbqn/Files/';
    // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
    //move_uploaded_file($_FILES['fotoUserEdit']['tmp_name'],$directorio.$fotopersonal);


    //Cargo el modelo y ejecuto la función para hacer el update
    $modeloTrabajo=new Trabajo_Model();
    $resultado=$modeloTrabajo-> modificarTrabajo($IdTrabajo,$NombreTrabajo,$FechaIniTrabajo,$FechaFinTrabajo,$PorcentajeNota);

    //si modifica correctamente vuelve a la vista usuario_SHOWALL.php mostrando mensaje de exito
    if($resultado==true){
        header("location: ActionController.php?action=exitoModificarTrabajo");
        //Si no muestra mensaje de error y vuelve a la vista usuario_EDIT.php
    }else{
        //cargo idiomas
        $idioma=new idiomas();
        $idiom=comprobaridioma($idioma);
        //Comprueba la sesión de ususario para mostrar el menú
        $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
        //cargo la vista MESSAGE
        $claseModificarTrabajo=new MESSAGE();
        $claseModificarTrabajo->cargar("errorModificar",$idiom,$comprobarUsuarioGrupo);
    }
}
//Carga la vista usuario_EDIT
function cargarModificarTrabajo($IdTrabajo){
    //cargo idiomas
    $idioma=new idiomas();
    $idiom=comprobaridioma($idioma);
    //cargo el modelo
    $modeloTrabajo=new Trabajo_Model();
    //busco al usuario a editar
    $datos=$modeloTrabajo->buscarPorId($IdTrabajo);
    //Comprueba la sesión de ususario para mostrar el menú
    $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
    //cargo la vista
    $claseModificarTrabajo=new Trabajo_EDIT();
    $claseModificarTrabajo->cargar($datos,"",$idiom,$comprobarUsuarioGrupo);
}

//carga vista SHOWCURRENT
function cargarShowCurrentTrabajo($IdTrabajo){
    //cargo idiomas
    $idioma=new idiomas();
    $idiom=comprobaridioma($idioma);
    //cargo el modelo
    $modeloTrabajo=new Trabajo_Model();
    //busco al usuario a editar
    $datos=$modeloTrabajo->buscarPorId($IdTrabajo);
    //Comprueba la sesión de ususario para mostrar el menú
    $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
    //cargo la vista
    $claseModificarTrabajo=new Trabajo_SHOWCURRENT();
    $claseModificarTrabajo->cargar($datos,"",$idiom,$comprobarUsuarioGrupo);

}
//Carga la vista SEARCH
function cargarBuscarTrabajo(){
    //cargo idiomas
    $idioma=new idiomas();
    $idiom=comprobaridioma($idioma);
    //Comprueba la sesión de ususario para mostrar el menú
    $comprobarUsuarioGrupo=ComprobarUsuarioMenu();
    $claseCrearTrabajo=new Trabajo_SEARCH();
    $claseCrearTrabajo->cargar("",$idiom,$comprobarUsuarioGrupo);
}

function cargarSearchT(){

    $IdTrabajo=$_POST['IdTrabajo'];
    $NombreTrabajo=$_POST['NombreTrabajo'];
    $dia=$_POST['FechaIniTrabajoSearchDia'];
    $mes=$_POST['FechaIniTrabajoSearchMes'];
    $año=$_POST['FechaIniTrabajoSearchAño'];
    $dia2=$_POST['FechaFinTrabajoSearchDia'];
    $mes2=$_POST['FechaFinTrabajoSearchMes'];
    $año2=$_POST['FechaFinTrabajoSearchAño'];
    $PorcentajeNota=$_POST['PorcentajeNota'];

    if($NombreTrabajo==""){
        $NombreTrabajo=null;
    }elseif ($IdTrabajo==""){
        $IdTrabajo=null;
    }elseif ($dia==""){
        $dia=null;
    }elseif ($mes==""){
        $mes=null;
    }elseif ($año==""){
        $año=null;
    }elseif ($PorcentajeNota==""){
        $PorcentajeNota=null;
    }elseif ($dia2==""){
        $dia2=null;
    }elseif ($mes2==""){
        $mes2=null;
    }elseif ($año2=="") {
        $año2 = null;
    }
    $model=new Trabajo_Model();
    $datos=$model->buscarTrabajo($IdTrabajo,$NombreTrabajo,$PorcentajeNota,$dia,$mes,$año,$dia2,$mes2,$año2);
    return $datos;
}






?>
