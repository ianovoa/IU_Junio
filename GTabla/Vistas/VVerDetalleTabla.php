<?php
/**
 * Vista que muestra un formulario para buscar una tabla para mostrarla en detalle
 *
 * @author iago
 */
class VVerDetalleTabla {
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
                        <button type="submit" name="action" value="verDetalle">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
	</html>
<?php
    }
    
    static function mostrar($tabla,$ejercicios,$usuarios){
?>
        <html>
            <head></head>
            <body>
<?php
        echo "<h2>Ver en detalle tabla $tabla[1]</h2>";
        echo "<p>Id de la tabla: $tabla[0]</p>";
        echo "<p>Nombre de la tabla: $tabla[1]</p>";
        echo "<p>Tipo de tabla: $tabla[2]</p>";
?>
                <p>Ejercicios de la tabla:</p>
                <table>
                    <tr>
                        <td>Id ejercicio</td>
                        <td>Nombre ejercicio</td>
                        <td>Num repeticiones</td>
                    </tr>
<?php
        $tupla=$ejercicios->fetch_row();
        do{
            echo "<tr><td>$tupla[0]</td>";
            echo "<td>$tupla[1]</td>";
            echo "<td>$tupla[2]</td></tr>";
            $tupla=$ejercicios->fetch_row();
        }while(!is_null($tupla));
?>
                </table>
<?php
        $string="<p>Usuarios con esta tabla asignada: ";
        $tupla=$usuarios->fetch_row();
        do{
            $string.="$tupla[1]";
            $tupla=$usuarios->fetch_row();
            if(!is_null($tupla)){
                $string.=", ";
            }
        }while(!is_null($tupla));
        $string.=".</p>";
        echo "$string";
?>
            </body>
        </html>
<?php
    }
}
?>