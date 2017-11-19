<?php
/**
 * Vista que muestra un formulario para dar de alta una tabla
 *
 * @author iago
 */

class VAltaTabla {
    function __construct() {
        $this->render();
    }
    
    function render(){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de alta de tabla:</h2>
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