<!DOCTYPE html>
<!--
  Vista que muestra el index de la aplicacion
 
  @author iago
-->
<html>
    <head></head>
    <body>
                <h1>Index de prueba:</h1>
                <form action="./GEjercicio/CEjercicio.php" method="post">
                    <div>
                        <p>Accion a realizar:</p>
                        <select name="action">
                            <option>alta</option>
                            <option>baja</option>
                            <option>modificacion</option>
                            <option>consulta</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" name="submit" value="Enviar">Enviar</button>
                    </div>
                </form>
            </body>
	</html>
