<?php
/**
 * En este archivo se detallara el modelo de sesion
 *
 * @author iago
 */

class MSesion {
    var $idSesion;
    var $idUser;
    var $idTabla;
    var $nombreSesion;
    var $horaInicio;
    var $horaFin;
    var $comentario;
    var $mysqli; //atributo manejador de la BD
    
    function __construct($idSesion,$idUser,$idTabla,$nombreSesion,$horaInicio,$horaFin,$comentario) {
        $this->idSesion=$idSesion;
        $this->idUser=$idUser;
        $this->idTabla=$idTabla;
        $this->nombreSesion=$nombreSesion;
        $this->horaInicio=$horaInicio;
        $this->horaFin=$horaFin;
        $this->comentario=$comentario;
        
        include_once "../ConexionBD.php";
        $this->mysqli= conexionBD();
    }
    
    function insert(){
        if($this->idTabla<>"" && $this->nombreSesion<>""){
            $sql = "INSERT INTO Sesion (idUsuario,idTabla,nombreSesion,horaInicio,horaFin,comentario) VALUES ('$this->idUser','$this->idTabla','$this->nombreSesion','$this->horaInicio','$this->horaFin','$this->comentario')";
            $this->mysqli->query($sql);
            return "Inserción realizada con éxito";
        }
        else{
            return "Introduzca los datos necesarios";
        }
    }
    
    function delete(){
        $sql="SELECT * FROM Sesion WHERE idSesion='$this->idSesion'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a borrar
            $sql = "DELETE FROM Sesion WHERE (idSesion='$this->idSesion')";
            $this->mysqli->query($sql);
            return "Borrado correctamente";
        }
        else{
            return "No se encuentra la sesion";
        }
    }
    
    function update(){
        $sql="SELECT * FROM Sesion WHERE idSesion='$this->idSesion'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a editar
            $tupla=$resultado->fetch_row();
            if($this->idTabla==""){ //si esta vacio se le añade el q ya tiene
                $idTabla=$tupla[2];
            }
            else{
                $idTabla=$this->idTabla;
            }
            if($this->nombreSesion==""){
                $nombreSesion=$tupla[3];
            }
            else{
                $nombreSesion=$this->nombreSesion;
            }
            if($this->horaInicio==""){
                $horaInicio=$tupla[4];
            }
            else{
                $horaInicio=$this->horaInicio;
            }
            if($this->horaFin==""){
                $horaFin=$tupla[5];
            }
            else{
                $horaFin=$this->horaFin;
            }
            if($this->comentario==""){
                $comentario=$tupla[6];
            }
            else{
                $comentario=$this->comentario;
            }
            $sql = "UPDATE Sesion SET idTabla='$idTabla',nombreSesion='$nombreSesion',horaInicio='$horaInicio',horaFin='$horaFin',comentario='$comentario' WHERE idSesion=$this->idSesion";
            $this->mysqli->query($sql);
            return "Modificado correctamente";
        }
        else{
            return "No se encuentra el ejercicio";
        }
    }
    
    function select(){
        $soloEste=TRUE;
        $sql="SELECT Tabla.nombre,Sesion.nombreSesion,Sesion.horaInicio,Sesion.horaFin,Sesion.comentario FROM Sesion,Tabla WHERE Sesion.idTabla=Tabla.idTabla AND Sesion.idUsuario='$this->idUser' AND ";
        if($this->idTabla<>""){
            $sql.="Sesion.idTabla='$this->idTabla'";
            $soloEste=FALSE;
        }
        if($this->nombreSesion<>""){
            if(!$soloEste){
                $sql.=" AND ";
            }
            $sql.="Sesion.nombreSesion LIKE '%$this->nombreSesion%'";
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
        $sql="SELECT * FROM Sesion";
        if(($resultado=$this->mysqli->query($sql))){
            return $resultado;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
    
    function selectID(){
        $sql="SELECT Sesion.idSesion,Tabla.nombre,Sesion.nombreSesion,Sesion.horaInicio,Sesion.horaFin,Sesion.comentario FROM Sesion,Tabla WHERE Sesion.idTabla=Tabla.idTabla AND Sesion.idSesion='$this->idSesion'";
        if(($resultado=$this->mysqli->query($sql))){
            $tupla=$resultado->fetch_row();
            return $tupla;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
            
    function tablasUser(){
        $sql="SELECT AsignacionTabla.idTabla,Tabla.nombre FROM AsignacionTabla,Tabla WHERE AsignacionTabla.idTabla=Tabla.idTabla AND AsignacionTabla.idUsuario='$this->idUser'";
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
