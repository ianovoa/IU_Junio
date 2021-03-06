<?php
/**
 * En este archivo se detallará el controlador del análisis del código
 *
 * Fecha: 10/06/2018
 * 
 * @author Iago Nóvoa González
 */

//incluidas las vistas
include_once '../view/analisisView.php';
include_once '../view/avisoView.php';

switch ($_REQUEST['action']){
	case 'analizar': //se realiza el análisis del codigo
		$codeName=$_FILES['code']['name'];
		if(!move_uploaded_file($_FILES['code']['tmp_name'],'../CodigoAExaminar/'.$_FILES['code']['name'])) new avisoView('Error al subir el archivo',"../index.php");
		else{
            if($_FILES['code']['type']=='application/x-rar-compressed'){ //archivo rar
                $rarFile=rar_open('../CodigoAExaminar/'.$_FILES['code']['name']);
                $list=rar_list($rarFile);
                foreach($list as $file){
                    $entry=rar_entry_get($rarFile,$file);
                    $entry->extract('../CodigoAExaminar/');
                }
                unlink('../CodigoAExaminar/'.$_FILES['code']['name']);
                unset($file);
            }
            if($_FILES['code']['type']=='application/x-tar'){ //archivo tar
                $tarFile=new PharData('../CodigoAExaminar/'.$_FILES['code']['name']);
                $tarFile->extractTo('../CodigoAExaminar/');
                unlink('../CodigoAExaminar/'.$_FILES['code']['name']);
            }
            if($_FILES['code']['type']=='application/zip'){ //archivo zip
                $zipFile=new ZipArchive;
                $zipFile->open('../CodigoAExaminar/'.$_FILES['code']['name']);
                $zipFile->extractTo('../CodigoAExaminar/');
                unlink('../CodigoAExaminar/'.$_FILES['code']['name']);
            }
            $directorios=comprobarDirectorio(); //comprueba que los directorios sean los de Directories.conf
            $fileName=comprobarFileName(); //comprueba que los archivos tengan nombres permitidos en File.conf
            $tipoFile=comprobarTipoFile(); //comprueba que los archivos tengan el tipo correcto
            $cabeceras=comprobarCabeceras(''); //comprueba la cabecera de los archivos de código
            $comentariosFun=comprobarComentariosFuncion(''); //comprueba los comentarios de los archivos de código (funciones)
            $comentariosCon=comprobarComentariosControl(''); //comprueba los comentarios de los archivos de código (e. de control)
            $comentariosVar=comprobarComentariosVar(''); //comprueba los comentarios de los archivos de código (variables)
            $soloIndex=comprobarSoloIndex(); //comprueba q en la caepeta raiz solo se halle el index (boolean)
            $numDir=conteoDir(''); //cuenta el numero de directorios de manera recursiva
            $numArch=conteoArch(''); //cuenta el numero de archivos de manera recursiva
            $numCom=conteoCom(''); //cuenta el numero de funciones, estr de control y variables totales del código subido
            new analisisView($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$comentariosVar,$soloIndex,$numDir,$numArch,$numCom); //muestra los resultados del analisis
            //array_map('unlink', glob('../CodigoAExaminar/*'));
            delete(''); //borra los archivos del directorio una vez realizado el análisis
		}
		break;

    case 'index': //mensaje de fin de análisis
        new avisoView('Archivos borrados, volviendo al index.',"../index.php");
        break;
}

//comprueba que los directorios sean los de Directories.conf
function comprobarDirectorio(){
    $toret=array();
    $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES); //guarda en un array los directorios a comprobar
    for($i=0;$i<count($directoriosConf);$i++){
        if(!@scandir('../'.$directoriosConf[$i])){ //si no existe una dir se guarda en el array de errores
            $str=explode('/',$directoriosConf[$i],2); //spq
            $toret[$i][]=$str[1];
            $toret[$i][]=false; //error
        }
        else{
            $str=explode('/',$directoriosConf[$i],2); //spq
            $toret[$i][]=$str[1];
            $toret[$i][]=true; //todo correcto
        }
    }
    return $toret; //devuelve resultado de analisis
}

//comprueba que los archivos tengan nombres permitidos en File.conf
function comprobarFileName(){
    $toret=array();
    $fileConf=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES); //guarda en un array los nombres a comprobar
    for($i=0;$i<count($fileConf);$i++){
        preg_match('~(.+)/(.+\..+)~',$fileConf[$i],$dirYName); //array: 1 dir, 2 name
        if($files=@scandir('../'.$dirYName[1])){
            if(strpbrk($dirYName[2],'%')==false){
                $faltaFichero=true;
                for($j=0;$j<count($files);$j++){
                    if($files[$j]==$dirYName[2]) $faltaFichero=false;
                    if(!$faltaFichero) break;
                }
                $str=explode('/',$dirYName[1],2); //spq
                if(!isset($str[1])) $str[1]='';
                if($faltaFichero){
                    $toret[$str[1].'/'.$dirYName[2]][0][0]='Fichero requerido inexistente';
                    $toret[$str[1].'/'.$dirYName[2]][0][1]=false; //error
                }
                else{
                    $toret[$str[1].'/'.$dirYName[2]][0][0]='Existe el fichero requerido';
                    $toret[$str[1].'/'.$dirYName[2]][0][1]=true; //todo correcto
                }
            }
            else{
                $expRegular=str_replace('%','[0-9A-Za-z]+',$dirYName[2]);
                $expRegular=str_replace('.','\.',$expRegular);
                $expRegular='/^('.$expRegular.')$/'; //crea la expresion regular necesaria para la busqueda
                for($j=0;$j<count($files);$j++){
                    if(!is_dir($files[$j])){
                        $str=explode('/',$dirYName[1],2); //spq
                        if(!isset($toret[$str[1].'/'.$dirYName[2]])) $x=0;
                        else $x=count($toret[$str[1].'/'.$dirYName[2]]);
                        if(preg_match($expRegular,$files[$j])==0){
                            $toret[$str[1].'/'.$dirYName[2]][$x][0]=$str[1].'/'.$files[$j];
                            $toret[$str[1].'/'.$dirYName[2]][$x][1]=false;
                        }
                        elseif(preg_match($expRegular,$files[$j])==1){
                            $toret[$str[1].'/'.$dirYName[2]][$x][0]=$str[1].'/'.$files[$j];
                            $toret[$str[1].'/'.$dirYName[2]][$x][1]=true;
                        }
                    }
                }
            }
        }
        else{
            $str=explode('/',$dirYName[1],2); //spq
            if(strpbrk($dirYName[2],'%')==false){
                $toret[$str[1].'/'.$dirYName[2]][0][0]='Fichero requerido inexistente';
                $toret[$str[1].'/'.$dirYName[2]][0][1]=false; //error
            }
            else{
                $toret[$str[1].'/'.$dirYName[2]][0][0]='El patrón redirige a un directorio inexistente';
                $toret[$str[1].'/'.$dirYName[2]][0][1]=false; //error
            }
        }
    }
    return $toret;
}

//comprueba que los archivos tengan el tipo correcto
function comprobarTipoFile(){
    $toret=array();
    $k=0;
    if($files=@scandir('../CodigoAExaminar/Model')){
        for($i=0;$i<count($files);$i++){
            if(strpos($files[$i],'.php')!==false){
                $tipoCorrecto=false;
                $code=file('../CodigoAExaminar/Model/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){
                    if(strpos($code[$j],'class ')!==false){
                        $tipoCorrecto=true;
                        break;
                    }
                    elseif(strpos($code[$j],'function ')!==false || strpos($code[$j],'switch ')!==false) break; //si se encuentra una de estas 2 antes es q no es una clase
                }
                $toret['model'][$k][0]=$files[$i];
                if(!$tipoCorrecto) $toret['model'][$k][1]=false; //error
                else $toret['model'][$k][1]=true; //todo correcto
                $k++;
            }
        }
    }
    if($files=@scandir('../CodigoAExaminar/Controller')){
        $k=0;
        for($i=0;$i<count($files);$i++){
            if(strpos($files[$i],'.php')!==false){
                $tipoCorrecto=false;
                $code=file('../CodigoAExaminar/Controller/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){
                    if(strpos($code[$j],'switch ')!==false){
                        $tipoCorrecto=true;
                        break;
                    }
                    elseif(strpos($code[$j],'function ')!==false || strpos($code[$j],'class ')!==false) break; //si se encuentra una de estas 2 antes es q no es un scripts
                }
                $toret['controller'][$k][0]=$files[$i];
                if(!$tipoCorrecto) $toret['controller'][$k][1]=false; //error
                else $toret['controller'][$k][1]=true; //todo correcto
                $k++;
            }
        }
    }
    if($files=@scandir('../CodigoAExaminar/View')){
        $k=0;
        for($i=0;$i<count($files);$i++){
            if(strpos($files[$i],'.php')!==false){
                $tipoCorrecto=false;
                $code=file('../CodigoAExaminar/View/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){
                    if(strpos($code[$j],'class ')!==false){
                        $tipoCorrecto=true;
                        break;
                    }
                    elseif(strpos($code[$j],'function ')!==false || strpos($code[$j],'switch ')!==false) break; //si se encuentra una de estas 2 antes es q no es una clase
                }
                $toret['view'][$k][0]=$files[$i];
                if(!$tipoCorrecto) $toret['view'][$k][1]=false; //error
                else $toret['view'][$k][1]=true; //todo correcto
                $k++;
            }
        }
    }
    return $toret;
}

//comprueba la cabecera de los archivos de código
function comprobarCabeceras($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(!is_dir($dir.'/'.$files[$i])){
            if(strpos($dir.'/'.$files[$i],'.php')!==false || strpos($dir.'/'.$files[$i],'.html')!==false || strpos($dir.'/'.$files[$i],'.css')!==false || strpos($dir.'/'.$files[$i],'.js')!==false || strpos($dir.'/'.$files[$i],'.c')!==false || strpos($dir.'/'.$files[$i],'.java')!==false || strpos($dir.'/'.$files[$i],'.sql')!==false || strpos($dir.'/'.$files[$i],'.‎py')!==false || strpos($dir.'/'.$files[$i],'.rb')!==false){
                $code=file($dir.'/'.$files[$i],FILE_IGNORE_NEW_LINES);
                $tieneAutor=false;
                $tieneFecha=false;
                $tieneFuncion=false;
                $esPrimer=true;
                $tipoCom='';
                for($j=0;$j<count($code);$j++){ //leemos el codigo
                    if($esPrimer){ //comprobamos el tipo de comentario q es usado
                        if(strpos($code[$j],'//')!==false){
                            $tipoCom='//';
                            $esPrimer=false;
                        }
                        elseif(strpos($code[$j],'/*')!==false){
                            $tipoCom='/*';
                            $esPrimer=false;
                        }
                        elseif(strpos($code[$j],'<!--')!==false){
                            $tipoCom='<!--';
                            $esPrimer=false;
                        }
                    }
                    if($tipoCom=='//' && strpos($code[$j],'//')===false) break; //cuando se acaba la cabecera dejamos de leer
                    if($tipoCom!='' && (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{2,4}/',$code[$j])==1 || preg_match('/fecha/',$code[$j])==1) || preg_match('/date/',$code[$j])==1) $tieneFecha=true;
                    if($tipoCom!='' && preg_match('/@?auth?or/i',$code[$j])==1) $tieneAutor=true;
                    elseif($tipoCom!='' && preg_match('/funct?ion/i',$code[$j])==1) $tieneFuncion=true; //entendemos cualquier frase en la cabecera como funcion
                    if(($tipoCom=='/*' && strpos($code[$j],'*/')!==false) || ($tipoCom=='<!--' && strpos($code[$j],'-->')!==false)) break; //cuando se acaba la cabecera dejamos de leer
                }
                if(!isset($toret)) $k=0;
                else $k=count($toret);
                if(!$tieneAutor || !$tieneFecha || !$tieneFuncion){
                    $toret[$k][0]=$dirOr.'/'.$files[$i];
                    $toret[$k][1]=false; //error
                    if(!$tieneAutor) $toret[$k][]='autor';
                    if(!$tieneFuncion) $toret[$k][]='funcion';
                    if(!$tieneFecha) $toret[$k][]='fecha';
                }
                else{
                    $toret[$k][0]=$dirOr.'/'.$files[$i];
                    $toret[$k][1]=true; //todo correcto
                }
            }
        }
        elseif(!strpbrk($files[$i],'.')){
            $recur=comprobarCabeceras($dirOr.'/'.$files[$i]);
            if(!isset($toret)) $toret=array();
            $toret=array_merge($toret,$recur);
        }
    }
    if(!isset($toret)) $toret=array();
    return $toret;
}

//comprueba los comentarios de los archivos de código (funciones)
function comprobarComentariosFuncion($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=array();
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(!is_dir($dir.'/'.$files[$i])){
            if(strpos($dir.'/'.$files[$i],'.php')!==false || strpos($dir.'/'.$files[$i],'.html')!==false || strpos($dir.'/'.$files[$i],'.js')!==false || strpos($dir.'/'.$files[$i],'.c')!==false || strpos($dir.'/'.$files[$i],'.java')!==false || strpos($dir.'/'.$files[$i],'.‎py')!==false || strpos($dir.'/'.$files[$i],'.rb')!==false){
                $k=count($toret);
                $todoBien=true;
                $code=file($dir.'/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){ //leemos el codigo
                    if(preg_match('/^[A-Za-z][\w\s]+\((\$?[A-Za-z][\w\s]*,?)*\)\{/',$code[$j],$coincidencia)==1 && strpos($code[$j],'if')===false && strpos($code[$j],'for')===false && strpos($code[$j],'while')===false  && strpos($code[$j],'class')===false  && strpos($code[$j],'foreach')===false && strpos($code[$j],'switch')===false && strpos($code[$j],'//')===false && strpos($code[$j],'/*')===false && strpos($code[$j],'#')===false && preg_match('/^(\/\/)/',$code[$j-1])==0 && preg_match('/^(\/\*)/',$code[$j-1])==0 && preg_match('/^#/',$code[$j-1])==0){
                        $toret[$k][0]=$dirOr.'/'.$files[$i];
                        $toret[$k][1]=false; //error
                        $toret[$k][]=$coincidencia[0].' (linea '.($j+1).')';
                        $todoBien=false;
                    }
                }
                if($todoBien){
                    $toret[$k][0]=$dirOr.'/'.$files[$i];
                    $toret[$k][1]=true; //todo bien
                }
            }
        }
        elseif(!strpbrk($files[$i],'.')){
            $recur=comprobarComentariosFuncion($dirOr.'/'.$files[$i]);
            $toret=array_merge($toret,$recur);
        }
    }
    return $toret;
}

//comprueba los comentarios de los archivos de código (e. de control)
function comprobarComentariosControl($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=array();
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(!is_dir($dir.'/'.$files[$i])){
            if(strpos($dir.'/'.$files[$i],'.php')!==false || strpos($dir.'/'.$files[$i],'.html')!==false || strpos($dir.'/'.$files[$i],'.js')!==false || strpos($dir.'/'.$files[$i],'.c')!==false || strpos($dir.'/'.$files[$i],'.java')!==false || strpos($dir.'/'.$files[$i],'.‎py')!==false || strpos($dir.'/'.$files[$i],'.rb')!==false){
                $k=count($toret);
                $todoBien=true;
                $code=file($dir.'/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){ //leemos el codigo
                    if((preg_match('/(else)?if\s?\(.*\)\{/',$code[$j],$coincidencia)==1 || preg_match('/else\s?\{/',$code[$j],$coincidencia)==1 || preg_match('/for(each)?\s?\(.*\)\{/',$code[$j],$coincidencia)==1 || preg_match('/do\s?\{/',$code[$j],$coincidencia)==1 || preg_match('/while\s?\(.*\)\{/',$code[$j],$coincidencia)==1 || preg_match('/switch\s?\(.*\)\{/',$code[$j],$coincidencia)==1) && strpos($code[$j],'//')===false && strpos($code[$j],'/*')===false && strpos($code[$j],'#')===false && preg_match('/^(\/\/)/',$code[$j-1])==0 && preg_match('/^(\/\*)/',$code[$j-1])==0 && preg_match('/^#/',$code[$j-1])==0){
                        $toret[$k][0]=$dirOr.'/'.$files[$i];
                        $toret[$k][1]=false; //error
                        $toret[$k][]=$coincidencia[0].' (linea '.($j+1).')';
                        $todoBien=false;
                    }
                }
                if($todoBien){
                    $toret[$k][0]=$dirOr.'/'.$files[$i];
                    $toret[$k][1]=true; //todo bien
                }
            }
        }
        elseif(!strpbrk($files[$i],'.')){
            $recur=comprobarComentariosControl($dirOr.'/'.$files[$i]);
            $toret=array_merge($toret,$recur);
        }
    }
    return $toret;
}

//comprueba los comentarios de los archivos de código (variables)
function comprobarComentariosVar($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=array();
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(!is_dir($dir.'/'.$files[$i])){
            if(strpos($dir.'/'.$files[$i],'.php')!==false || strpos($dir.'/'.$files[$i],'.html')!==false || strpos($dir.'/'.$files[$i],'.js')!==false || strpos($dir.'/'.$files[$i],'.c')!==false || strpos($dir.'/'.$files[$i],'.java')!==false || strpos($dir.'/'.$files[$i],'.‎py')!==false || strpos($dir.'/'.$files[$i],'.rb')!==false){
                $k=count($toret);
                $todoBien=true;
                $variables=array();
                $code=file($dir.'/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){ //leemos el codigo
                    if(preg_match('/(\$?[A-Za-z]\w*)\s?=/',$code[$j],$coincidencia)==1 && strpos($code[$j],'//')===false && strpos($code[$j],'/*')===false && strpos($code[$j],'#')===false && preg_match('/^(\/\/)/',$code[$j-1])==0 && preg_match('/^(\/\*)/',$code[$j-1])==0 && preg_match('/^#/',$code[$j-1])==0){
                        $sinRegistrar=true;
                        for($x=0;$x<count($variables);$x++){
                            if($variables[$x]==$coincidencia[1]) $sinRegistrar=false;
                        }
                        if($sinRegistrar){
                            $toret[$k][0]=$dirOr.'/'.$files[$i];
                            $toret[$k][1]=false; //error
                            $toret[$k][]=$coincidencia[1].' (linea '.($j+1).')';
                            $variables[]=$coincidencia[1];
                            $todoBien=false;
                        }
                    }
                }
                if($todoBien){
                    $toret[$k][0]=$dirOr.'/'.$files[$i];
                    $toret[$k][1]=true; //todo bien
                }
            }
        }
        elseif(!strpbrk($files[$i],'.')){
            $recur=comprobarComentariosVar($dirOr.'/'.$files[$i]);
            $toret=array_merge($toret,$recur);
        }
    }
    return $toret;
}

//comprueba q en la carpeta raiz solo se halle el index
function comprobarSoloIndex(){
    $toret=true;
    $files=scandir('../CodigoAExaminar');
    for($i=0;$i<count($files);$i++){
        if(!is_dir($files[$i]) && $files[$i]!='index.php'){
            $toret=false;
            break;
        }
    }
    return $toret;
}

//cuenta el numero de directorios de manera recursiva
function conteoDir($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=0;
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(is_dir($dir.'/'.$files[$i]) && !strpbrk($files[$i],'.')){
            $toret++;
            $recur=conteoDir($dirOr.'/'.$files[$i]);
            $toret+=$recur;
        }
    }
    return $toret;
}

//cuenta el numero de archivos de manera recursiva
function conteoArch($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=0;
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(is_dir($dir.'/'.$files[$i]) && !strpbrk($files[$i],'.')){
            $recur=conteoArch($dirOr.'/'.$files[$i]);
            $toret+=$recur;
        }
        elseif(!is_dir($dir.'/'.$files[$i])) $toret++;
    }
    return $toret;
}

function conteoCom($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $toret=['fun'=>0,'con'=>0,'var'=>0];
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(!is_dir($dir.'/'.$files[$i])){
            if(strpos($dir.'/'.$files[$i],'.php')!==false || strpos($dir.'/'.$files[$i],'.html')!==false || strpos($dir.'/'.$files[$i],'.js')!==false || strpos($dir.'/'.$files[$i],'.c')!==false || strpos($dir.'/'.$files[$i],'.java')!==false || strpos($dir.'/'.$files[$i],'.‎py')!==false || strpos($dir.'/'.$files[$i],'.rb')!==false){
                $variables=array();
                $code=file($dir.'/'.$files[$i],FILE_IGNORE_NEW_LINES);
                for($j=0;$j<count($code);$j++){ //leemos el codigo
                    if(preg_match('/(\$?[A-Za-z]\w*)\s?=/',$code[$j],$coincidencia)==1){
                        $sinRegistrar=true;
                        for($x=0;$x<count($variables);$x++) if($variables[$x]==$coincidencia[1]) $sinRegistrar=false;
                        if($sinRegistrar){
                            $toret['var']++;
                            $variables[]=$coincidencia[1];
                        }
                    }
                    if(preg_match('/(else)?if\s?\(.*\)\{/',$code[$j])==1 || preg_match('/else\s?\{/',$code[$j])==1 || preg_match('/for(each)?\s?\(.*\)\{/',$code[$j])==1 || preg_match('/do\s?\{/',$code[$j])==1 || preg_match('/while\s?\(.*\)\{/',$code[$j])==1 || preg_match('/switch\s?\(.*\)\{/',$code[$j])==1) $toret['con']++;
                    elseif(preg_match('/^[A-Za-z][\w\s]+\((\$?[A-Za-z][\w\s]*,?)*\)\{/',$code[$j])==1 && strpos($code[$j],'class')===false) $toret['fun']++;
                }
            }
        }
        elseif(!strpbrk($files[$i],'.')){
            $recur=conteoCom($dirOr.'/'.$files[$i]);
            $toret['var']+=$recur['var'];
            $toret['con']+=$recur['con'];
            $toret['fun']+=$recur['fun'];
        }
    }
    return $toret;
}

function delete($dirOr){
    $dir='../CodigoAExaminar/'.$dirOr;
    $files=scandir($dir);
    for($i=0;$i<count($files);$i++){
        if(is_dir($dir.'/'.$files[$i]) && !strpbrk($files[$i],'.')){
            delete($dirOr.'/'.$files[$i]);
            rmdir($dir.'/'.$files[$i]);
        }
        elseif(!is_dir($dir.'/'.$files[$i])) unlink($dir.'/'.$files[$i]);
    }
}
?>
