<?php
/**
 * En este archivo se detallará el controlador de la configuración del análisis del código
 *
 * @author iago
 */

//incluidas la vistas
include_once '../view/verConfView.php';
include_once '../view/editView.php';

switch ($_REQUEST['action']){
    case 'verConf': //se ve la configuración
        $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES);
        for($i=0;$i<count($directoriosConf);$i++){
            $str=explode('/',$directoriosConf[$i],2); //spq
            $directoriosConf[$i]=$str[1];
        }
        new verConfView($directoriosConf);
        break;

        case 'loadEdit': //se edita el patron para el nombre del archivo
            $patron='';
            $directorio=$_GET['directorio'];
            $directorio='CodigoAExaminar/'.$directorio;
            $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
            for($i=0;$i<count($patrones);$i++){
                    $aux=explode(':',$patrones[$i],2);
                    if($aux[0]==$directorio) $patron=$aux[1];
            }
            new editView($directorio,$patron);
            break;
        
        case 'edit': //se edita el patron para el nombre del archivo o (se borra)
            $orden=$_POST['orden'];
            $directorio=$_POST['directorio'];
            $patron=$_POST['patron'];
            $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
            unlink('../conf/Files.conf');
            for($i=0;$i<count($patrones);$i++){
                $aux=explode(':',$patrones[$i],2);
                if($aux[0]!=$directorio) $newsPatrones[]=$patrones[$i].PHP_EOL;
            }
            if($orden=='Enviar') $newsPatrones[]=$directorio.':'.$patron.PHP_EOL;
            file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
            header('Location: confController.php?action=verConf');
            break;
        
        case 'delete': //se borra un directorio (y el patron asignado)
            $directorio=$_GET['directorio'];
            if($directorio!='Model' && $directorio!='Controller' && $directorio!='View'){
                $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES);
                $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
                $directorio='CodigoAExaminar/'.$directorio;
                unlink('../conf/Directories.conf');
                unlink('../conf/Files.conf');
                for($i=0;$i<count($directoriosConf);$i++){
                    if($directoriosConf[$i]!=$directorio) $newsDirectorios[]=$directoriosConf[$i].PHP_EOL;
                }
                for($i=0;$i<count($patrones);$i++){
                    $aux=explode(':',$patrones[$i],2);
                    if($aux[0]!=$directorio) $newsPatrones[]=$patrones[$i].PHP_EOL;
                }
                file_put_contents('../conf/Directories.conf',$newsDirectorios,LOCK_EX);
                file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
            }
            header('Location: confController.php?action=verConf');
            break;
        
        case 'create': //se añade un directorio
        
            break;
}
