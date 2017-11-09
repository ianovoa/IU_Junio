<?php
/**
 * Vista que muestra un mensaje referente a una accion realizada
 *
 * @author iago
 */

class MESSAGE_View {
    function __construct($mensaje,$volver){
        $this->render($mensaje,$volver);
    }
    
    function render($mensaje,$volver){
?>
        <html>
            <head></head>
            <body>
<?php
        echo "MENSAJE: $mensaje";
        echo "<br><br>";
        echo "<a href='$volver'>Volver</a>";
        
?>
            </body>
        </html>
<?php
    }
}
?>