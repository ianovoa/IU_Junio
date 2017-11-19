<?php
/**
 * Vista que muestra un formulario para buscar tablas, para mostrarlas en una tabla
 *
 * @author iago
 */

class VConsultarTabla {
    function __construct() {
        $this->render();
    }
    
    function render(){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de busqueda de tabla:</h2>
                <form action="./CTabla.php" method="post">
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
                        <td>Nombre tabla</td>
                        <td>Tipo tabla</td>
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