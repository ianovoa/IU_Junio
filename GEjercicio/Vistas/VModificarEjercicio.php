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
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione el ejercicio a modificar:</h2>
                <form action="./CEjercicio.php" method="post">
                    <div>
                        <p>Selecione la ID del ejercicio a modifiacar:</p>
<?php
        $tupla=$listaEjercicios->fetch_row();
        do{
            echo "<input type='radio' name='idEjercicio' value='$tupla[0]'>$tupla[0] -> $tupla[1]<br>";
            $tupla=$listaEjercicios->fetch_row();
        }while(!is_null($tupla));
?>
                    </div>
                    <div>
                        <button type="submit" name="action" value="modificacion">Enviar</button>
                    </div>
                </form>
            </body>
        </html>

<?php
    }
    
    static function mostrarFormulario($idEjercicio){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de modificacion del ejercicio:</h2>
                <form action="./CEjercicio.php" method="post">
<?php
        echo "<input type='hidden' name='idEjercicio' value='$idEjercicio'/>";
?>
                    <div>
                        <label for="nombreEj">Nombre del ejercicio:</label>
                        <input type="text" name="nombreEj" size="30"/>
                    </div>
                    <div>
                        <label for="descripcionEj">Descripcion del ejercicio:</label><br>
                        <textarea name="descripcionEj">Escribir descripcion aqui</textarea>
                    </div>
                    <div>
                        <button type="submit" name="action" value="modificacion">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
	</html>
<?php
    }
}
?>
