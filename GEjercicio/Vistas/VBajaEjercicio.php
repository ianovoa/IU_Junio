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
                        <select name="idEjercicio">
<?php
        do{
            $tupla=$listaEjercicios->fetch_row();
            echo "<option>$tupla[0]</option>";
        }while(!is_null($tupla));
?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="action" value="baja">Enviar</button>
                    </div>
                </form>
                <br><br>
                <h3>Lista de ejercicios disponibles:</h3>
                <table>
                    <tr>
                        <td>ID del ejercicio</td>
                        <td>Nombre del ejercicio</td>
                    </tr>
<?php
        do{
            $tupla=$listaEjercicios2->fetch_row();
            echo "<tr><td>$tupla[0]</td>";
            echo "<td>$tupla[1]</td></tr>";
        }while(!is_null($tupla));
?>
                </table>
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
                        <td><?php $ejercicioBorrar[0] ?></td>
                    </tr>
                    <tr>
                        <td>Nombre del ejercicio:</td>
                        <td><?php $ejercicioBorrar[1] ?></td>
                    </tr>
                    <tr>
                        <td>Descripcion del ejercicio:</td>
                        <td><?php $ejercicioBorrar[2] ?></td>
                    </tr>
                </table>
                <br><br>
                <form action="../CEjercicio.php" method="POST">
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