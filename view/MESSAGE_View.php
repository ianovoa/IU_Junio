<?php
/**
 * Vista que muestra un mensaje referente a una accion realizada
 *
 * @author iago
 */
class MESSAGE_View {
    function __construct($mensaje,$volver){
        $this->render($mensaje,$volver);
    }
    
    function render($mensaje,$volver){
?>
	<div>
            <div>

                <!-- Page Heading -->
                <div>
                    <div class="col-lg-12">
                        <h1>
                            Aviso
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
        
                <table><tr><td><br><br><br><center><?=$mensaje?></center><br><br><br></td></tr></table>
                
                <div>
                    <div class="col-lg-12">
                        <a href='<?=$volver?>'>
                            <img class="imagenes" src="../images/return.png" width="4%">
                        </a>
                    </div>
                </div>
<?php
    }
}
?>
