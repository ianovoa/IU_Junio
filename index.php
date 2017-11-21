<!DOCTYPE html>
<!--
  Vista que muestra el index de la aplicacion
 
  @author iago
-->
<html>
    <head></head>
    <body>
        <h1>Index de prueba:</h1>
        <h2>Gestion de ejercicio</h2>
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
            <button type="submit" name="submit" value="Enviar">Enviar</button>
        </form>
        <br><br>
        <h2>Gestion de sesion</h2>
        <form action="./GSesion/CSesion.php" method="post">
            <div>
                <p>Accion a realizar:</p>
                <select name="action">
                    <option>alta</option>
                    <option>baja</option>
                    <option>modificacion</option>
                    <option>consulta</option>
                </select>
            </div>
            <button type="submit" name="submit" value="Enviar">Enviar</button>
        </form>
        <br><br>
        <h2>Gestion de tablas</h2>
        <form action="./GTabla/CTabla.php" method="post">
            <div>
                <p>Accion a realizar:</p>
                <select name="action">
                    <option>alta</option>
                    <option>baja</option>
                    <option>modificacion</option>
                    <option>consulta</option>
                    <option>verDetalle</option>
                    <option>asignarEj</option>
                    <option>asignarUser</option>
                </select>
            </div>
            <button type="submit" name="submit" value="Enviar">Enviar</button>
        </form>
    </body>
</html>
