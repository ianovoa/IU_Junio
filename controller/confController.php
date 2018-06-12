<?php
/**
 * En este archivo se detallará el controlador de la configuración del análisis del código
 *
 * @author iago
 */

//incluidas la vistas
include '../view/verConfView.php';

switch ($_REQUEST['action']){
    case 'verConf': //se ve la configuración
        $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES);
        for($i=0;$i<count($directoriosConf);$i++){
            $str=explode('/',$directoriosConf[$i],2); //spq
            $directoriosConf[$i]=$str[1];
        }
        new verConfView($directoriosConf);
        break;
        
        case 'edit': //se ve la configuración
        $directorio=$_GET['directorio'];
        
        break;
        
        case 'delete': //se ve la configuración
        $directorio=$_GET['directorio'];
        
        break;
        
        case 'create': //se ve la configuración
        
        break;
}
