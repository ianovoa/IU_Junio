<?php
/**
 * Vista que muestra un formulario para dar de alta un ejercicio
 *
 * @author iago
 */

class VAltaEjercicio{
    function __construct() {
        $this->render();
    }
    
    function render(){
?>
        <html>
            <head></head>
            <body>
                <h2>Formulario de alta de ejercicio:</h2>
                <form action="./CEjercicio.php" method="post">
                    <div>
                        <label for="nombreEj">Nombre del ejercicio:</label>
                        <input type="text" name="nombreEj" size="30"/>
                    </div>
                    <div>
                        <label for="descripcionEj">Descripcion del ejercicio:</label><br>
                        <textarea name="descripcionEj">Escribir descripcion aqui</textarea>
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