<?php
/**
 * Description of VAsignarUsuario
 *
 * @author iago
 */

class VAsignarUsuario {
    function __construct($tablas) {
        $this->render($tablas);
    }
    
    function render($tablas){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar usuarios:</h2>
                <p>Seleccione la tabla a la que asignar o quitar usuarios:</p>
                <form action="./CTabla.php" method="post">
                    <div>
                        <p>Selecione la ID de la tabla:</p>
<?php
        $tupla=$tablas->fetch_row();
        do{
            echo "<input type='radio' name='idTabla' value='$tupla[0]'>$tupla[0] -> $tupla[1]<br>";
            $tupla=$tablas->fetch_row();
        }while(!is_null($tupla));
?>
                    </div>
                    <div>
                        <button type="submit" name="action" value="asignarUser">Enviar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
    
    static function elegirOpcion($tabla){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar usuarios:</h2>
<?php
        echo "<p>Seleccione si desea borrar o añadir usuarios a la tabla $tabla[1]:</p>";
?>
                <form action="./CTabla.php" method="post">
<?php
        echo "<input type='hidden' name='idTabla' value='$tabla[0]'/>";
        echo "<input type='hidden' name='action' value='asignarUser'/>";
?>
                    <div>
                        <button type="submit" name="opcion" value="asignar">Añadir</button>
                        <button type="submit" name="opcion" value="borrar">Borrar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
    
    static function asignarUsuario($usuarios,$idTabla,$opcion){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar usuarios</h2>
<?php
        echo "<p>Selecione los usuarios a los que asignar la tabla</p>";
?>
                <form action="./CTabla.php" method="post">
                    <div>
                        <p>Marque los ejercicios:</p>
                    
<?php
        echo "<input type='hidden' name='idTabla' value='$idTabla'/>";
        echo "<input type='hidden' name='opcion' value='$opcion'/>";
        $user=$usuarios->fetch_row();
        do{
            echo "<input type='checkbox' name='usuarios[]' value='$user[0]'/>$user[1]<br>";
            $user=$usuarios->fetch_row();
        }while(!is_null($user));
?>
                    </div>
                    <div>
                        <button type="submit" name="action" value="asignarUser">Enviar</button>
                    </div>
                </form>
            </body>
        </html>
<?php 
    }
}
?>