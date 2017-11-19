<?php
/**
 * Vista que muestra un formulario para seleccionar la tabla a borrar para luego mostrar el ejercicio seleccionado y solicitar confirmacion
 *
 * @author iago
 */

class VBajaTabla {
    function __construct($listaTablas) {
        $this->render($listaTablas);
    }
    
    function render($listaTablas){
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione la tabla a borrar:</h2>
                <form action="./CTabla.php" method="post">
                    <div>
                        <p>Selecione la ID de la tabla a borrar:</p>
<?php
        $tupla=$listaTablas->fetch_row();
        do{
            echo "<input type='radio' name='idTabla' value='$tupla[0]'>$tupla[0] -> $tupla[1]<br>";
            $tupla=$listaTablas->fetch_row();
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
    
    static function solicitarConfirmacion($tablaBorrar){
?>
        <html>
            <head></head>
            <body>
                <h2>¿Desea borrar este ejercicio?</h2>
                <table>
                    <tr>
                        <td>Id de la tabla:</td>
<?php
        echo "<td>$tablaBorrar[0]</td>";
?>
                    </tr>
                    <tr>
                        <td>Nombre de la tabla:</td>
<?php
        echo "<td>$tablaBorrar[1]</td>";
?>
                    </tr>
                    <tr>
                        <td>Tipo de tabla:</td>
<?php
        echo "<td>$tablaBorrar[2]</td>";
?>
                    </tr>
                </table>
                <br><br>
                <form action="./CTabla.php" method="POST">
<?php
        echo "<input type='hidden' name='idTabla' value='$tablaBorrar[0]'/>";
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
?>