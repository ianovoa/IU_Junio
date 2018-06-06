 <?php
/**
 * En este archivo se detallará el controlador del análisis del código
 *
 * @author iago
 */

//comprueba que los directorios sean los de Directories.conf
function comprobarDirectorio(){
    $j=0;
    $directoriosConf=file('../conf/Directories.conf',FILE_IGNORE_NEW_LINES); //guarda en un array los directorios a comprobar
    for($i=0;$i<count($directoriosConf);$i++){
        if(!@scandir("../".$directoriosConf[$i])){ //si no existe una dir se guarda en el array de errores
            $str=explode('/',$directoriosConf[$i],2); //spq
            $toret[$j]=$str[1];
            $j++;
        }
    }
    return $toret; //devuelve todas las carpetas q NO existen (y deberian)
}

//comprueba que los archivos tengan nombres permitidos en File.conf
function comprobarFileName(){
    $k=0;
    $fileConf=file('../conf/Files.conf',FILE_IGNORE_NEW_LINES); //guarda en un array los nombres a comprobar
    for($i=0;$i<count($fileConf);$i++){
        $dirYName=explode(':',$fileConf[$i],2); //array: 0 dir, 1 name
        if($files=@scandir("../".$dirYName[0])){
            $expRegular=str_replace('%','[0-9A-Za-z]+',$dirYName[1]);
            $expRegular=str_replace('.','\.',$expRegular);
            $expRegular='/'.$expRegular.'/'; //crea la expresion regular necesaria para la busqueda
            for($j=0;$j<count($files);$j++){
                if(strpbrk($files[$j],'.') && preg_match($expRegular,$files[$j])==0){
                    $str=explode('/',$dirYName[0],2); //spq
                    $toret[$k]=$str[1].'/'.$files[$j];
                }
            }
        }
    }
    return $toret;
}

//comprueba que los archivos tengan el tipo correcto
function comprobarTipoFile(){

}

//comprueba la cabecera de los archivos de código
function comprobarCabeceras(){

}

//comprueba los comentarios de los archivos de código
function comprobarComentarios(){

}
?>
