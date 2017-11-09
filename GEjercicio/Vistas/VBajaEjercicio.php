<?php
/**
 * Vista que muestra un formulario para seleccionar el ejercicio a borrar para luego mostrar el ejercicio seleccionado y solicitar confirmacion
 *
 * @author iago
 */

class VBajaEjercicio{
    function __construct($listaEjercicios) {
        $this->render($listaEjercicios);
    }
    
    function render($listaEjercicios){
        $listaEjercicios2=$listaEjercicios;
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione el ejercicio a borrar:</h2>
                <form action="./CEjercicio.php" method="post">
                    <div>
                        <p>Selecione la ID del ejercicio a borrar:</p>
<?php
        $tupla=$listaEjercicios->fetch_row();
        do{
            echo "<input type='radio' name='idEjercicio' value='$tupla[0]'>$tupla[0] -> $tupla[1]<br>";
            $tupla=$listaEjercicios->fetch_row();
        }while(!is_null($tupla));
?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="action" value="baja">Enviar</button>
                    </div>
                </form>
            </body>
        </html>

<?php
    }
    
    static function solicitarConfirmacion($ejercicioBorrar){
?>
        <html>
            <head></head>
            <body>
                <h2>¿Desea borrar este ejercicio?</h2>
                <table>
                    <tr>
                        <td>Id del ejercicio:</td>
<?php
        echo "<td>$ejercicioBorrar[0]</td>";
?>
                    </tr>
                    <tr>
                        <td>Nombre del ejercicio:</td>
<?php
        echo "<td>$ejercicioBorrar[1]</td>";
?>
                    </tr>
                    <tr>
                        <td>Descripcion del ejercicio:</td>
<?php
        echo "<td>$ejercicioBorrar[2]</td>";
?>
                    </tr>
                </table>
                <br><br>
                <form action="./CEjercicio.php" method="POST">
<?php
        echo "<input type='hidden' name='idEjercicio' value='$ejercicioBorrar[0]'/>";
        echo "<input type='hidden' name='nombreEj' value='$ejercicioBorrar[1]'/>";
        echo "<input type='hidden' name='descripcionEj' value='$ejercicioBorrar[2]'/>";
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