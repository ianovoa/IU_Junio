<?php
/**
 * Vista que muestra un formulario para buscar sesiones, para mostrarlas en una tabla
 *
 * @author iago
 */

class VConsultarSesion {
    function __construct($tablasUser) {
        $this->render($tablasUser);
    }
    
    function render($tablasUser){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de busqueda:</h2>
                <form action="./CSesion.php" method="post">
                    <div>
                        <label for="nombreSesion">Nombre del ejercicio:</label>
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
?>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="action" value="consulta">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
	</html>
<?php
    }
    
    static function mostrar($resultado){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de busqueda:</h2>
                <table>
                    <tr>
                        <td>Nombre de sesion</td>
                        <td>Tabla de sesion</td>
                        <td>Hora de inicio</td>
                        <td>Hora de finalizacion</td>
                        <td>Comentario</td>
                    </tr>
<?php
        $tupla=$resultado->fetch_row();
        do{
            echo "<tr><td>$tupla[1]</td>";
            echo "<td>$tupla[0]</td>";
            echo "<td>$tupla[2]</td>";
            echo "<td>$tupla[3]</td>";
            echo "<td>$tupla[4]</td></tr>";
            $tupla=$resultado->fetch_row();
        }while(!is_null($tupla));
?>
                </table>
            </body>
        </html>
<?php
    }
}
?>