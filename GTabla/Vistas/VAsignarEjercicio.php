<?php
/**
 * Vista q permite asignar a una tabla los ejercicios que contiene
 *
 * @author iago
 */

class VAsignarEjercicio {
    function __construct($tablas) {
        $this->render($tablas);
    }
    
    function render($tablas){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar ejercicios:</h2>
                <p>Seleccione la tabla a la que asignar los ejercicios:</p>
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
                        <button type="submit" name="action" value="asignarEj">Enviar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
    
    static function mostrarEjercicios($tupla,$ejercicios){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar ejercicios</h2>
<?php
        echo "<p>Selecione los ejercicios a hacer en la tabla $tupla[1]</p>";
?>
                <form action="./CTabla.php" method="post">
                    <div>
                        <p>Marque los ejercicios:</p>
                    
<?php
        echo "<input type='hidden' name='idTabla' value='$tupla[0]'/>";
        $ejercicio=$ejercicios->fetch_row();
        do{
            echo "<input type='checkbox' name='ejercicios[]' value='$ejercicio[0]'/>$ejercicio[1]<br>";
            $ejercicio=$ejercicios->fetch_row();
        }while(!is_null($ejercicio));
?>
                    </div>
                    <div>
                        <button type="submit" name="action" value="asignarEj">Enviar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
    
    static function pedirCantidades($idTabla,$ejercicios,$nombreEj){
?>
        <html>
            <head></head>
            <body>
                <h2>Asignar ejercicios</h2>
                <p>Selecione el numero de repeticiones de cada ejercicio</p>
                <form action="./CTabla.php" method="post">
                    <p>Escribir el numero de repeticiones:</p>
<?php
        echo "<input type='hidden' name='idTabla' value='$idTabla'/>";
        for($i=0;$i<count($nombreEj);$i++){
            echo "<div><label for='cantidades[]'>$nombreEj[$i]:</label>";
            echo "<input type='text' name='cantidades[]' size='3'/></div>";
            echo "<input type='hidden' name='ejercicios[]' value='$ejercicios[$i]'/>";
        }
?>
                    <div>
                        <button type="submit" name="action" value="asignarEj">Enviar</button>
                        <button type="reset" name="reset" value="Borrar">Borrar</button>
                    </div>
                </form>
            </body>
        </html>
<?php
    }
}
?>