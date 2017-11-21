<?php
/**
 * Vista que muestra un formulario para dar de alta una sesion
 *
 * @author iago
 */

class VAltaSesion {
    function __construct($tablasUser){
        $this->render($tablasUser);
    }
    
    function render($tablasUser){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de alta de sesion:</h2>
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
            echo "<input type='radio' name='idTabla' value='$tupla[0]'> $tupla[0] -> $tupla[1]<br>";
            $tupla=$tablasUser->fetch_row();
        }while(!is_null($tupla));
?>
                        </select>
                    </div>
                    <div>
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha"/>
                    </div>
                    <div>
                        <label for="horaInicio">Hora de inicio:</label>
                        <input type="time" name="horaInicio"/>
                    </div>
                    <div>
                        <label for="horaFin">Hora de finalizacion:</label>
                        <input type="time" name="horaFin"/>
                    </div>
                    <div>
                        <label for="comentario">Comentario:</label><br>
                        <textarea name="comentario">Escribir comentario aqui</textarea>
                    </div>
                    <div>
                        <button type="submit" name="action" value="alta">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
	</html>
<?php
    }
}
?>