<?php
/**
 * Vista que muestra un formulario para seleccionar la sesion a modificar para luego mostrar el formulario a modificar
 *
 * @author iago
 */

class VModificarSesion {
    function __construct($listaSesiones){
        $this->render($listaSesiones);
    }
    
    function render($listaSesiones){
?>
        <html>
            <head></head>
            <body>
                <h2>Seleccione la sesion a modificar:</h2>
                <form action="./CSesion.php" method="post">
                    <div>
                        <p>Selecione la ID de la sesion a modificar:</p>
<?php
        $tupla=$listaSesiones->fetch_row();
        do{
            echo "<input type='radio' name='idSesion' value='$tupla[0]'> $tupla[3]<br>";
            $tupla=$listaSesiones->fetch_row();
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
    
    static function mostrarFormulario($idSesion,$tablasUser){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de modificar sesion:</h2>
                <form action="./CSesion.php" method="post">
                    <div>
                        <label for="nombreSesion">Nombre de la sesion:</label>
                        <input type="text" name="nombreSesion" size="50"/>
                    </div>
                    <div>
                        <p>Selecione la tabla sobre la que se realizo la sesion:</p>
<?php
        $tupla=$tablasUser->fetch_row();
        do{
            echo "<input type='radio' name='idTabla' value='$tupla[0]'> $tupla[1]<br>";
            $tupla=$tablasUser->fetch_row();
        }while(!is_null($tupla));
        echo "<input type='hidden' name='idSesion' value='$idSesion'/>";
?>
                        </select>
                    </div>
                    <div>
                        <label for="horaInicio">Hora de inicio:</label>
                        <input type="datetime" name="horaInicio"/>
                    </div>
                    <div>
                        <label for="horaFin">Hora de finalizacion:</label>
                        <input type="datetime" name="horaFin"/>
                    </div>
                    <div>
                        <label for="comentario">Comentario:</label><br>
                        <textarea name="comentario">Escribir comentario aqui</textarea>
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