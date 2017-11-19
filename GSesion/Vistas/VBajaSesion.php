<?php
/**
 * Vista que muestra un formulario para seleccionar la sesion a borrar para luego mostrar la sesion seleccionada y solicitar confirmacion
 *
 * @author iago
 */

class VBajaSesion {
    function __construct($listaSesiones) {
        $this->render($listaSesiones);
    }
    
    function render($listaSesiones){
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione la sesion a borrar:</h2>
                <form action="./CSesion.php" method="post">
                    <div>
                        <p>Selecione la ID de la sesion a borrar:</p>
<?php
        $tupla=$listaSesiones->fetch_row();
        do{
            echo "<input type='radio' name='idSesion' value='$tupla[0]'> $tupla[3]<br>";
            $tupla=$listaSesiones->fetch_row();
        }while(!is_null($tupla));
?>
                    </div>
                    <div>
                        <button type="submit" name="action" value="baja">Enviar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
    
    static function solicitarConfirmacion($sesionBorrar){
?>
        <html>
            <head></head>
            <body>
                <h2>¿Desea borrar esta sesion?</h2>
                <table>
                    <tr>
                        <td>Id de la sesion:</td>
<?php
        echo "<td>$sesionBorrar[0]</td>";
?>
                    </tr>
                    <tr>
                        <td>Tabla de sesion:</td>
<?php
        echo "<td>$sesionBorrar[1]</td>";
?>
                    </tr>
                    <tr>
                        <td>Nombre de sesion:</td>
<?php
        echo "<td>$sesionBorrar[2]</td>";
?>
                    </tr>
                    <tr>
                        <td>Hora de inicio:</td>
<?php
        echo "<td>$sesionBorrar[3]</td>";
?>
                    </tr>
                    <tr>
                        <td>Hora de finalizacion:</td>
<?php
        echo "<td>$sesionBorrar[4]</td>";
?>
                    </tr>
                    <tr>
                        <td>Comentario:</td>
<?php
        echo "<td>$sesionBorrar[5]</td>";
?>
                    </tr>
                </table>
                <br><br>
                <form action="./CSesion.php" method="POST">
<?php
        echo "<input type='hidden' name='idSesion' value='$sesionBorrar[0]]'/>";
        echo "<input type='hidden' name='action' value='baja'/>";
?>
                    <div>
                        <button type="submit" name="confirmar" value="si">Si</button>
                        <button type="submit" name="confirmar" value="no">No</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
}
