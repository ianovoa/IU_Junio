<?php
/**
 * En este archivo se detallará el controlador de la configuración del análisis del código
 *
 * @author iago
 */

//incluidas la vistas
include_once '../view/verConfView.php';
include_once '../view/editView.php';
include_once '../view/createView.php';
include_once '../view/verPatronView.php';
include_once '../view/avisoView.php';

switch ($_REQUEST['action']){
    case 'verConf': //se ve la configuración
        $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES);
        for($i=0;$i<count($directoriosConf);$i++){
            $str=explode('/',$directoriosConf[$i],2); //spq
            $directoriosConf[$i]=$str[1];
        }
        new verConfView($directoriosConf);
        break;
        
    case 'verPatrones': //se muestra el patron para el nombre del archivo
        $patron='';
        $archivosRequeridos=array();
        $directorio=$_GET['directorio'];
        $filesConf=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
        for($i=0;$i<count($filesConf);$i++){
            $expRegular='~CodigoAExaminar/'.$directorio.'/(.+\..+)~';
            preg_match($expRegular,$filesConf[$i],$name); //array: 1 name
            if(count($name)>0){
                if(strpbrk($name[1],'%')==false) $archivosRequeridos[]=$name[1];
                else $patron=$name[1];
            }
        }
        new verPatronView($directorio,$patron,$archivosRequeridos);
        break;

        case 'loadEditPatron': //se edita el patron para el nombre del archivo o (se borra)
            $patron='';
            $directorio=$_GET['directorio'];
            $directorio='CodigoAExaminar/'.$directorio;
            $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
            for($i=0;$i<count($patrones);$i++){
                    preg_match('~(.+)/(.+\..+)~',$patrones[$i],$dirYName); //array: 1 dir, 2 name
                    if($dirYName[1]==$directorio && strpbrk($dirYName[2],'%')!=false) $patron=$dirYName[2];
            }
            new editView($directorio,$patron);
            break;
        
        case 'editPatron': //se edita el patron para el nombre del archivo o (se borra)
            $orden=$_POST['orden'];
            $directorio=$_POST['directorio'];
            $patron=$_POST['patron'];
            $auxDir=explode('/',$directorio,2);
            $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
            unlink('../conf/Files.conf');
            for($i=0;$i<count($patrones);$i++){
                preg_match('~(.+)/(.+\..+)~',$patrones[$i],$dirYName); //array: 1 dir, 2 name
                if($dirYName[1]!=$directorio) $newsPatrones[]=$patrones[$i].PHP_EOL;
                if($dirYName[1]==$directorio){
                    if(strpbrk($dirYName[2],'%')==false) $filesDir[]=$patrones[$i];
                    else $exPatron=$patrones[$i];
                }
            }
            if($orden=='Enviar' && $patron!=''){ //$newsPatrones[]=$directorio.'/'.$patron.PHP_EOL;
                if(strpbrk($patron,'%')==false){
                    if(isset($exPatron)) $newsPatrones[]=$exPatron.PHP_EOL;
                    for($i=0;$i<count($filesDir);$i++) $newsPatrones[]=$filesDir[$i].PHP_EOL;
                    file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
                    new avisoView('El patrón introducido no contiene ningún % (señala una cadena cualquiera de caracteres) y, por lo tanto, no se considera un patrón apto. <u>Se ha recuperado el antiguo patrón</u>.',"../controller/confController.php?action=verPatrones&directorio=$auxDir[1]");
                }
                else{
                    $expRegular=$directorio.'/'.$patron;
                    $newsPatrones[]=$expRegular.PHP_EOL;
                    $expRegular=str_replace('%','[0-9A-Za-z]+',$expRegular);
                    $expRegular=str_replace('.','\.',$expRegular);
                    $expRegular='~'.$expRegular.'~'; //crea la expresion regular necesaria para la busqueda
                    echo $expRegular.'<br>';
                    for($i=0;$i<count($filesDir);$i++){
                        if(preg_match($expRegular,$filesDir[$i])==0) $deleteFiles[]=$filesDir[$i];
                        else $newsPatrones[]=$filesDir[$i].PHP_EOL;
                    }
                    file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
                    if(isset($deleteFiles)){
                        $mensaje='Los siguientes archivos requeridos no cumplen con el patrón y han sido borrados: <u>';
                        $max=count($deleteFiles);
                        for($i=0;$i<count($deleteFiles);$i++){
                            preg_match('~.+/(.+\..+)~',$deleteFiles[$i],$name); //array: 1 name
                            $mensaje=$mensaje.$name[1];
                            if($i!=$max-1) $mensaje=$mensaje.'</u>, <u>';
                            else $mensaje=$mensaje.'</u>.';
                        }
                        new avisoView($mensaje,"../controller/confController.php?action=verPatrones&directorio=$auxDir[1]");
                    }
                    else header("Location: confController.php?action=verPatrones&directorio=$auxDir[1]");
                }
            }
            else{
                for($i=0;$i<count($filesDir);$i++) $newsPatrones[]=$filesDir[$i].PHP_EOL;
                file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
                header("Location: confController.php?action=verPatrones&directorio=$auxDir[1]");
            }
            break;
        
        case 'deleteDir': //se borra un directorio (y el patron asignado)
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
                    preg_match('~(.+)/(.+\..+)~',$patrones[$i],$dirYName); //array: 1 dir, 2 name
                    if($dirYName[1]!=$directorio) $newsPatrones[]=$patrones[$i].PHP_EOL;
                }
                file_put_contents('../conf/Directories.conf',$newsDirectorios,LOCK_EX);
                file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
            }
            header('Location: confController.php?action=verConf');
            break;
            
        case 'deleteArchivo': //se borra un archivo requerido
            $directorio=$_GET['directorio'];
            $archivo=$_GET['archivo'];
            $patrones=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES);
            $fileDelete='CodigoAExaminar/'.$directorio.'/'.$archivo;
            unlink('../conf/Files.conf');
            for($i=0;$i<count($patrones);$i++){
                if($fileDelete!=$patrones[$i]) $newsPatrones[]=$patrones[$i].PHP_EOL;
            }
            file_put_contents('../conf/Files.conf',$newsPatrones,LOCK_EX);
            header("Location: confController.php?action=verPatrones&directorio=$directorio");
            break;
        
        case 'loadCreateDir': //se añade un directorio
            new createView();
            break;
            
        case 'createDir': //se añade un directorio
            $directorio=$_POST['directorio'];
            $directorio='CodigoAExaminar/'.$directorio.PHP_EOL;
            file_put_contents('../conf/Directories.conf',$directorio,FILE_APPEND | LOCK_EX);
            header('Location: confController.php?action=verConf');
            break;
            
        case 'default': //se reinicia la configuración
            copy('../conf/Directories_default.conf','../conf/Directories.conf');
            copy('../conf/Files_default.conf','../conf/Files.conf');
            header('Location: confController.php?action=verConf');
            break;
}
