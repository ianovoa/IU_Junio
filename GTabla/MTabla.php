<?php
/**
 * En este archivo se detallara el modelo de tabla
 *
 * @author iago
 */

class MTabla {
    var $idTabla;
    var $nombreTabla;
    var $tipoTabla;
    var $mysqli; //atributo manejador de la BD
    
    function __construct($idTabla,$nombreTabla,$tipoTabla){
        $this->idTabla=$idTabla;
        $this->nombreTabla=$nombreTabla;
        $this->tipoTabla=$tipoTabla;
        
        //incluimos de manera unitaria la funcion de conexion a la BD
        include_once "../ConexionBD.php";
        $this->mysqli=conexionBD();
    }

    function insert(){
        if($this->nombreTabla<>""){ //el campo nombre no esta vacio
            $sql="SELECT * FROM Tabla WHERE nombre='$this->nombreTabla'";
            $resultado= $this->mysqli->query($sql);
            if ($resultado->num_rows==0) { //comprobamos q no exita ya
                $sql = "INSERT INTO Tabla (nombre,tipoTabla) VALUES ('$this->nombreTabla','$this->tipoTabla')";
                $this->mysqli->query($sql);
                return "Inserción realizada con éxito";
            }
            else { //si ya existe ese ej
                return "Ya existe en la base de datos";
            }
        }
        else{
            return "Introduzca los datos necesarios";
        }
    }
    
    function delete(){
        $sql="SELECT * FROM Tabla WHERE idTabla='$this->idTabla'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a borrar
            $sql = "DELETE FROM Tabla WHERE (idTabla='$this->idTabla')";
            $this->mysqli->query($sql);
            return "Borrado correctamente";
        }
        else{
            return "No se encuentra la tabla";
        }
    }
    
    //borra la asignacion de ej previa
    function deleteAsignacionEj(){
        $sql = "DELETE FROM EjercicioTabla WHERE (idTabla='$this->idTabla')";
        $this->mysqli->query($sql);
        return "Borrado correctamente";
    }
            
    function update(){
        $sql="SELECT * FROM Tabla WHERE idTabla='$this->idTabla'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a editar
            $tupla=$resultado->fetch_row();
            if($this->nombreTabla==""){ //si nombre esta vacio se le añade el q ya tiene
                $nombreTabla=$tupla[1];
            }
            else{
                $nombreTabla= $this->nombreTabla;
            }if($this->tipoTabla==""){ //si descripcion esta vacia se le añade el q ya tiene
                $tipoTabla=$tupla[2];
            }
            else{
                $tipoTabla= $this->tipoTabla;
            }
            $sql = "UPDATE Tabla SET nombre='$nombreTabla',tipoTabla='$tipoTabla' WHERE idTabla=$this->idTabla";
            $this->mysqli->query($sql);
            return "Modificado correctamente";
        }
        else{
            return "No se encuentra el ejercicio";
        }
    }
    
    function select(){
        $soloEste=TRUE;
        $sql="SELECT * FROM Tabla WHERE ";
        if($this->tipoTabla<>""){
            $sql.="tipoTabla='$this->tipoTabla'";
            $soloEste=FALSE;
        }
        if($this->nombreTabla<>""){
            if(!$soloEste){
                $sql.=" AND ";
            }
            $sql.="nombre LIKE '%$this->nombreTabla%'";
            $soloEste=FALSE;
        }
        if(($resultado=$this->mysqli->query($sql))){
            return $resultado;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
    
    function selectAll(){
        $sql="SELECT * FROM Tabla";
        if(($resultado=$this->mysqli->query($sql))){
            return $resultado;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
    
    function selectID(){
        $sql="SELECT * FROM Tabla WHERE idTabla='$this->idTabla'";
        if(($resultado=$this->mysqli->query($sql))){
            $tupla=$resultado->fetch_row();
            return $tupla;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
    
    
    function selectNombre(){
        $sql="SELECT * FROM Tabla WHERE nombre='$this->nombreTabla'";
        if(($resultado=$this->mysqli->query($sql))){
            $tupla=$resultado->fetch_row();
            return $tupla;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
        
    //asigna un ej a una tabla
    function asignarEjercicio($idEjercicio,$cantidad){
        if($this->idTabla<>"" && $idEjercicio<>""){ //el campo nombre no esta vacio
            $sql="SELECT * FROM EjercicioTabla WHERE idTabla='$this->idTabla' AND idEjercicio='$idEjercicio'";
            $resultado= $this->mysqli->query($sql);
            if ($resultado->num_rows==0) { //comprobamos q no exita ya
                $sql = "INSERT INTO EjercicioTabla (idTabla,idEjercicio,cantidad) VALUES ('$this->idTabla','$idEjercicio','$cantidad')";
                $this->mysqli->query($sql);
                return "Inserción realizada con éxito";
            }
            else { //si ya existe
                return "Ya existe en la base de datos";
            }
        }
        else{
            return "Introduzca los datos necesarios";
        }
    }
    
    //asigna una tabla a un usuario
    function asignarTabla($idUsuario){
        if($this->idTabla<>"" && $idUsuario<>""){ //el campo nombre no esta vacio
            $sql="SELECT * FROM AsignacionTabla WHERE idTabla='$this->idTabla' AND idUsuario='$idUsuario'";
            $resultado= $this->mysqli->query($sql);
            if ($resultado->num_rows==0) { //comprobamos q no exita ya
                $sql = "INSERT INTO AsignacionTabla (idTabla,idUsuario) VALUES ('$this->idTabla','$idUsuario')";
                $this->mysqli->query($sql);
                return "Inserción realizada con éxito";
            }
            else { //si ya existe
                return "Ya existe en la base de datos";
            }
        }
        else{
            return "Introduzca los datos necesarios";
        }
    }
    
    //quita la tabla a unos usuarios
    function quitarTabla($idUsuario){
        $sql="SELECT * FROM AsignacionTabla WHERE idTabla='$this->idTabla' AND idUsuario='$idUsuario'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a borrar
            $sql="DELETE FROM AsignacionTabla WHERE idTabla='$this->idTabla' AND idUsuario='$idUsuario'";
            $this->mysqli->query($sql);
            return "Borrado correctamente";
        }
        else{
            return "No se encuentra el usuario";
        }
    }


    //devuelve los usuarios q tienen asignados la tabla
    function usersTabla(){
        $sql="SELECT AsignacionTabla.idUsuario,Usuario.Nombre FROM AsignacionTabla,Usuario WHERE AsignacionTabla.idUsuario=Usuario.idUsuario AND AsignacionTabla.idTabla='$this->idTabla'";
        if($resultado= $this->mysqli->query($sql)){
            return $resultado;
        }
        else{
            return "El usuario no tiene asignado tablas";
        }
    }
    
    //devuelve los ejercicios q tienen asignados la tabla
    function ejsTabla(){
        $sql="SELECT EjercicioTabla.idEjercicio,Ejercicio.nombreEjercicio,EjercicioTabla.cantidad FROM Ejercicio,EjercicioTabla WHERE Ejercicio.idEjercicio=EjercicioTabla.idEjercicio AND EjercicioTabla.idTabla='$this->idTabla'";
        if($resultado= $this->mysqli->query($sql)){
            return $resultado;
        }
        else{
            return "El usuario no tiene asignado tablas";
        }
    }
    
    //devuelve el total de usuarios
    function usuarios(){
        $sql="SELECT * FROM Usuario";
        if($resultado= $this->mysqli->query($sql)){
            return $resultado;
        }
        else{
            return "El usuario no tiene asignado tablas";
        }
    }
    
    public function __destruct(){
        desconexionBD($this->mysqli);
    }
}