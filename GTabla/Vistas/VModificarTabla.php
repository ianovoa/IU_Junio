<?php
/**
 * Vista que muestra un formulario para seleccionar la tabla a modificar para luego mostrar el formulario para modificar
 *
 * @author iago
 */

class VModificarTabla {
    function __construct($listaTablas) {
        $this->render($listaTablas);
    }
    
    function render($listaTablas){
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione la tabla a modificar:</h2>
                <form action="./CTabla.php" method="post">
                    <div>
                        <p>Selecione la ID de la tabla a modifiacar:</p>
<?php
        $tupla=$listaTablas->fetch_row();
        do{
            echo "<input type='radio' name='idTabla' value='$tupla[0]'>$tupla[0] -> $tupla[1]<br>";
            $tupla=$listaTablas->fetch_row();
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
    
    static function mostrarFormulario($idTabla){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de modificacion de tabla:</h2>
                <form action="./CTabla.php" method="post">
<?php
        echo "<input type='hidden' name='idTabla' value='$idTabla'/>";
?>
                    <div>
                        <label for="nombreTabla">Nombre:</label>
                        <input type="text" name="nombreTabla" size="50"/>
                    </div>
                    <div>
                        <label for="tipoTabla">Tipo de tabla:</label><br>
                        <input type='radio' name='tipoTabla' value='Predeterminada'> Predeterminada
                        <input type='radio' name='tipoTabla' value='Personalizada'> Personalizada
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