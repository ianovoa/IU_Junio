<?php
/**
 * En este archivo se detallara el modelo de ejercicio
 *
 * @author iago
 */


class MEjercicio {
    var $idEjercicio;
    var $nombreEj;
    var $descripcionEj;
    var $mysqli; //atributo manejador de la BD
    
    function __construct($idEjercicio,$nombreEj,$descripcionEj){
        $this->idEjercicio=$idEjercicio;
        $this->nombreEj=$nombreEj;
        $this->descripcionEj=$descripcionEj;
        
        //incluimos de manera unitaria la funcion de conexion a la BD
        include_once "../ConexionBD.php";
        $this->mysqli=conexionBD();
    }
    
    //inserta una nueva tupla en la BD
    function insert(){
        if($this->nombreEj<>""){ //el campo nombre no esta vacio
            $sql="SELECT * FROM Ejercicio WHERE nombreEj='$this->nombreEj'";
            $resultado= $this->mysqli->query($sql);
            if ($resultado->num_rows==0) { //comprobamos q no exita ya un ej con ese nombre
                $sql = "INSERT INTO Ejercicio (nombreEj,descripcionEj) VALUES ('$this->nombreEj','$this->descripcionEj')";
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
    
    //borra una tupla en la BD
    function delete(){
        $sql="SELECT * FROM Ejercicio WHERE idEjercicio='$this->idEjercicio'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a borrar
            $sql = "DELETE FROM Ejercicio WHERE (idEjercicio='$this->idEjercicio')";
            $this->mysqli->query($sql);
            return "Borrado correctamente";
        }
        else{
            return "No se encuentra el ejercicio";
        }
    }
    
    //edita una tupla en la BD 
    function update(){
        $sql="SELECT * FROM Ejercicio WHERE idEjercicio='$this->idEjercicio'";
        $resultado= $this->mysqli->query($sql);
        if ($resultado->num_rows==1) { //si encuentra la tupla a editar
            $tupla=$resultado->fetch_row();
            if($this->nombreEj==""){ //si nombre esta vacio se le añade el q ya tiene
                $nombreEj=$tupla[1];
            }
            else{
                $nombreEj= $this->nombreEj;
            }if($this->descripcionEj==""){ //si descripcion esta vacia se le añade el q ya tiene
                $descripcionEj=$tupla[2];
            }
            else{
                $descripcionEj= $this->descripcionEj;
            }
            $sql = "UPDATE Ejercicio SET nombreEj='$nombreEj',descripcionEj='$descripcionEj' WHERE idEjercicio=$this->idEjercicio";
            $this->mysqli->query($sql);
            return "Modificado correctamente";
        }
        else{
            return "No se encuentra el ejercicio";
        }
    }
    
    function select(){
        if($this->nombreEj==""){ //si se hace un select con campo vacio se entiende como un SHOWALL
            $sql="SELECT * FROM Ejercicio";
            $resultado=$this->mysqli->query($sql);
            return $resultado;
        }
        else{
            $sql="SELECT * FROM Ejercicio WHERE nombreEj LIKE '%$this->nombreEj%'";
            if(($resultado=$this->mysqli->query($sql))){
                return $resultado;
            }
            else{
                return "La busqueda no ha devuelto resultado";
            }
        }
    }
    
    function selectID(){
        $sql="SELECT * FROM Ejercicio WHERE idEjercicio='$this->idEjercicio'";
        if(($resultado=$this->mysqli->query($sql))){
            $tupla=$resultado->fetch_row();
            return $tupla;
        }
        else{
            return "La busqueda no ha devuelto resultado";
        }
    }
    
    public function __destruct(){
        desconexionBD($this->mysqli);
    }
}
?>