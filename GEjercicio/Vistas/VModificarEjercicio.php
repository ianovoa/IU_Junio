<?php
/**
 * Vista que muestra un formulario para seleccionar el ejercicio a modificar para luego mostrar el formulario a modificar
 *
 * @author iago
 */

class VModificarEjercicio{
    function __construct($listaEjercicios) {
        $this->render($listaEjercicios);
    }
    
    function render($listaEjercicios){
        $listaEjercicios2=$listaEjercicios;
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione el ejercicio a modificar:</h2>
                <form action="./CEjercicio.php" method="post">
                    <div>
                        <p>Selecione la ID del ejercicio a modifiacar:</p>
                        <select name="idEjercicio">
<?php
        do{
            $tupla=$listaEjercicios->fetch_row();
            echo "<option>$tupla[0]</option>";
        }while(is_null($tupla));
?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="action" value="modificacion">Enviar</button>
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
        }while(is_null($tupla));
?>
                </table>
            </body>
        </html>

<?php
    }
    
    function mostrarFormulario(){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de modificacion del ejercicio:</h2>
                <form action="../CEjercicio.php" method="post">
                    <div>
                        <label for="nombreEj">Nombre del ejercicio:</label>
                        <input type="text" name="nombreEj" size="30"/>
                    </div>
                    <div>
                        <label for="descripcionEj">Descripcion del ejercicio:</label><br>
                        <textarea name="descripcionEj">Escribir descripcion aqui</textarea>
                    </div>
                    <div>
                        <button type="submit" name="submit" value="Enviar">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
	</html>
<?php
    }
}
?>
