<?php
/**
 * Vista que muestra un formulario para buscar ejercicios, para mostrarlos en una tabla
 *
 * @author iago
 */

class VConsultarEjercicio{
    function __construct() {
        $this->render();
    }
    
    function render(){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de busqueda:</h2>
                <form action="./CEjercicio.php" method="post">
                    <div>
                        <label for="nombreEj">Nombre del ejercicio:</label>
                        <input type="text" name="nombreEj" size="30"/>
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
                        <td>Nombre ejercicio</td>
                        <td>Descripcion ejercicio</td>
                    </tr>
<?php
        $tupla=$resultado->fetch_row();
        do{
            echo "<tr><td>$tupla[1]</td>";
            echo "<td>$tupla[2]</td></tr>";
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