<?php
/**
 * Vista que muestra un mensaje referente a una accion realizada
 *
 * @author iago
 */

class MESSAGE_View {
    private $mensaje;
    private $volver;
    
    function __construct($mensaje,$volver){
        $this->mensaje=$mensaje;
        $this->volver=$volver;
    }
    
    function render(){
?>
        <br><br><h3>
<?php
        echo "$this->mensaje";
?>
        </h3><br><br>
<?php
        echo "<a href=\'".$this->volver."'>"."Volver"." </a>";
    }
}
?>