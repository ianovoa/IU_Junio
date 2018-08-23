<?php
/**
 * Este archivo contiene una vista que enseña el resultado del analisis
 *
 * @author Iago Nóvoa González
 *
 * Fecha: 12/06/2018
*/

class analisisView{
    function __construct($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$comentariosVar,$soloIndex,$numDir,$numArch) {
        $this->render($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$comentariosVar,$soloIndex,$numDir,$numArch);
    }
    
    function render($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$comentariosVar,$soloIndex,$numDir,$numArch){
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="../img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>IU: Proyecto de Junio</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,500,600,900" rel="stylesheet">
		<!--
		CSS
		============================================= -->
		<link rel="stylesheet" href="../css/linearicons.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/nice-select.css">
		<link rel="stylesheet" href="../css/magnific-popup.css">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="main-wrapper-first relative">
			<header>
				<div class="container">
					<div class="header-wrap">
						<div class="header-top d-flex justify-content-between align-items-center">
							<div class="logo">
								<a href="../index.php"><img src="../img/logo.png" alt="" width="20%"></a>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div class="banner-area">
				<div class="container">
					<div class="row justify-content-center generic-height align-items-center">
						<div class="col-lg-8">
							<div class="banner-content text-center">
								<h1 class="text-white">Resultados del Análisis</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Start Amazing Works Area -->
		<div class="main-wrapper">

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h1>RESUMEN ANÁLISIS</h1>
						<br>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">1 - Existen los directorios especificados en el fichero Directories.conf y no hay ningún fichero mas en el directorio principal que el index.php.<br>
<?php
        $aux=0;
        for($i=0;$i<count($directorios);$i++) if(!$directorios[$i][1]) $aux++;
        $numEDir=$aux;
        if(!$soloIndex) $aux++;
?>
                                <u><?=count($directorios)?> elementos analizados / Número de errores : <?=$aux?></u></p>
                                <p class="sample-text">2 - Los ficheros tienen el nombre indicado en la especificación en el fichero Files.conf.<br>
<?php
        $numName=0;
        $numEName=0;
        foreach($fileName as $part){
            foreach($part as $elem){
                $numName++;
                if(!$elem[1]) $numEName++;
            }
        }
        unset($part,$elem);
?>
                                <u><?=$numName?> elementos analizados / Número de errores : <?=$numEName?></u></p>
                                <p class="sample-text">3 - Los ficheros tienen todos al principio del fichero comentada su función, autor y fecha.<br>
<?php
        $numEHead=0;
        foreach($cabeceras as $elem) if(!$elem[1]) $numEHead++;
        unset($elem);
?>
                                <u><?=count($cabeceras)?> elementos analizados / Número de errores : <?=$numEHead?></u></p>
                                <p class="sample-text">4 - Las funciones y métodos en el código tienen comentarios con una descripción antes de su comienzo.<br>
<?php
        $numEFun=0;
        foreach($comentariosFun as $elem) if(!$elem[1]) $numEFun+=count($elem)-2;
        unset($elem);
?>
                                <u><?=count($comentariosFun)?> ficheros analizados / Número de errores : <?=$numEFun?></u></p>
                                <p class="sample-text">5 - En el código están todas las variables definidas antes de su uso y tienen un comentario en la línea anterior o en la misma línea.<br>
<?php
        $numEVar=0;
        foreach($comentariosVar as $elem) if(!$elem[1]) $numEVar+=count($elem)-2;
        unset($elem);
?>
                                <u><?=count($comentariosVar)?> ficheros analizados / Número de errores : <?=$numEVar?></u></p>
                                <p class="sample-text">6 - En el código están comentadas todas las estructuras de control en la línea anterior a su uso o en la misma línea.<br>
<?php
        $numECon=0;
        foreach($comentariosCon as $elem) if(!$elem[1]) $numECon+=count($elem)-2;
        unset($elem);
?>
                                <u><?=count($comentariosCon)?> ficheros analizados / Número de errores : <?=$numECon?></u></p>
                                <p class="sample-text">7 - Todos los ficheros dentro del directorio Model son definiciones de clases.<br>
<?php
        $numM=0;
        $numEM=0;
        $numC=0;
        $numEC=0;
        $numV=0;
        $numEV=0;
        foreach($tipoFile as $clave=>$part){
            if($clave=='model') $numM=count($part);
            if($clave=='controller') $numC=count($part);
            if($clave=='view') $numV=count($part);
            foreach($part as $elem){
                if($clave=='model' && !$elem[1]) $numEM++;
                if($clave=='controller' && !$elem[1]) $numEC++;
                if($clave=='view' && !$elem[1]) $numEV++;
            }
        }
        unset($part,$elem);
?>
                                <u><?=$numM?> elementos analizados / Número de errores : <?=$numEM?></u></p>
                                <p class="sample-text">8 - Todos los ficheros dentro del directorio Controller son scripts php.<br><u><?=$numC?> elementos analizados / Número de errores : <?=$numEC?></u></p>
                                <p class="sample-text">9 - Todos los ficheros dentro del directorio View son definiciones de clases.<br><u><?=$numV?> elementos analizados / Número de errores : <?=$numEV?></u></p>
                                <br>
                                <p class="sample-text"><b>Número de elementos analizados</b><br>Directorios: <?=$numDir?><br>Archivos: <?=$numArch?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End text Area -->

            <!-- Start title Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h1>DETALLE</h1>
					</div>
				</div>
			</div>
			<!-- End title Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Directorios obligatorios</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">Existen los directorios especificados en el fichero Directories.conf:</p>
<?php
        for($i=0;$i<count($directorios);$i++){
            if($directorios[$i][1]){
?>
                                <p class="text-left"><?=$directorios[$i][0]?> &#8212;> OK</p>
<?php
            }
            else{
?>
                                <p class="text-left"><b><?=$directorios[$i][0]?> &#8212;> ERROR: NO EXISTE EL DIRECTORIO</b></p>
<?php
            }
        }
?>
							</div>
						</div>
                        <p class="sample-text">RESUMEN: <?=count($directorios)?> Elementos analizados / Número de errores: <?=$numEDir?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Nombre de los ficheros</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">Los ficheros tienen el nombre indicado en la especificación en el fichero Files.conf:</p>
<?php
        if(count($fileName)==0){
?>
                                <p class="text-left"><b>No existe Files.conf o este no tiene ningún patrón definido</b></p>
<?php
        }
        else{
            foreach($fileName as $clave=>$part){
?>
                                <p class="text-left"><?=$clave?>:</p>
<?php
                for($i=0;$i<count($part);$i++){
                    if($part[$i][1]){
?>
                                &nbsp;&nbsp;&nbsp;<p class="text-left"><?=$part[$i][0]?> &#8212;> OK</p>
<?php
                    }
                    else{
?>
                                &nbsp;&nbsp;&nbsp;<p class="text-left"><b><?=$part[$i][0]?> &#8212;> ERROR</b></p>
<?php
                    }
                }
            }
            unset($clave,$part);
        }
?>
							</div>
						</div>
						<p class="sample-text">RESUMEN: <?=$numName?> Elementos analizados / Número de errores: <?=$numEName?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Cabeceras de los ficheros</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">Los ficheros del código a examinar tienen todos al principio del fichero comentada su función, autor y fecha.:</p>
<?php
        if(count($cabeceras)==0){
?>
                                <p class="text-left"><b>No hay ficheros de código subidos</b></p>
<?php
        }
        else{
            for($i=0;$i<count($cabeceras);$i++){
                if($cabeceras[$i][1]){
?>
                                <p class="text-left"><?=$cabeceras[$i][0]?> &#8212;> OK</p>
<?php
                }
                else{
?>
                                <p class="text-left"><b><?=$cabeceras[$i][0]?> &#8212;> ERROR: le falta
<?php
                    $max=count($cabeceras[$i]);
                    for($j=2;$j<count($cabeceras[$i]);$j++){
?>
                                    <?=$cabeceras[$i][$j]?>
<?php
                        if($j!=$max-1) echo ', ';
                    }
?>
                                .</b></p>
<?php
                }
            }
        }
?>
							</div>
						</div>
						<p class="sample-text">RESUMEN: <?=count($cabeceras)?> Elementos analizados / Número de errores: <?=$numEHead?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Funciones comentadas</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">Las funciones y métodos en el código a examinar tienen comentarios con una descripción antes de su comienzo:</p>
<?php
        if(count($comentariosFun)==0){
?>
                                <p class="text-left"><b>No hay ficheros de código subidos</b></p>
<?php
        }
        else{
            for($i=0;$i<count($comentariosFun);$i++){
                if($comentariosFun[$i][1]){
?>
                                <p class="text-left"><?=$comentariosFun[$i][0]?> &#8212;> OK</p>
<?php
                }
                else{
?>
                                <p class="text-left"><b><?=$comentariosFun[$i][0]?> &#8212;> ERROR<br>
<?php
                    for($j=2;$j<count($comentariosFun[$i]);$j++){
?>
                                    &nbsp;&nbsp;&nbsp;<?=$comentariosFun[$i][$j]?><br>
<?php
                    }
?>
                                </b></p>
<?php
                }
            }
        }
?>
							</div>
						</div>
						<p class="sample-text">RESUMEN: <?=count($comentariosFun)?> Elementos analizados / Número de errores: <?=$numEFun?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Variables comentadas</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">En el código a examinar están todas las variables definidas antes de su uso y tienen un comentario en la línea anterior o en la misma línea:</p>
<?php
        if(count($comentariosVar)==0){
?>
                                <p class="text-left"><b>No hay ficheros de código subidos</b></p>
<?php
        }
        else{
            for($i=0;$i<count($comentariosVar);$i++){
                if($comentariosVar[$i][1]){
?>
                                <p class="text-left"><?=$comentariosVar[$i][0]?> &#8212;> OK</p>
<?php
                }
                else{
?>
                                <p class="text-left"><b><?=$comentariosVar[$i][0]?> &#8212;> ERROR<br>
<?php
                    for($j=2;$j<count($comentariosVar[$i]);$j++){
?>
                                    &nbsp;&nbsp;&nbsp;<?=$comentariosVar[$i][$j]?><br>
<?php
                    }
?>
                                </b></p>
<?php
                }
            }
        }
?>
							</div>
						</div>
                        <p class="sample-text">RESUMEN: <?=count($comentariosVar)?> Elementos analizados / Número de errores: <?=$numEVar?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Funciones comentadas</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">En el código a examinar están comentadas todas las estructuras de control en la línea anterior a su uso o en la misma línea:</p>
<?php
        if(count($comentariosCon)==0){
?>
                                <p class="text-left"><b>No hay ficheros de código subidos</b></p>
<?php
        }
        else{
            for($i=0;$i<count($comentariosCon);$i++){
                if($comentariosCon[$i][1]){
?>
                                <p class="text-left"><?=$comentariosCon[$i][0]?> &#8212;> OK</p>
<?php
                }
                else{
?>
                                <p class="text-left"><b><?=$comentariosCon[$i][0]?> &#8212;> ERROR<br>
<?php
                    for($j=2;$j<count($comentariosCon[$i]);$j++){
?>
                                    &nbsp;&nbsp;&nbsp;<?=$comentariosCon[$i][$j]?><br>
<?php
                    }
?>
                                </b></p>
<?php
                }
            }
        }
?>
							</div>
						</div>
						<p class="sample-text">RESUMEN: <?=count($comentariosCon)?> Elementos analizados / Número de errores: <?=$numECon?></p>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Tipo de los ficheros</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán los ficheros que no sean definiciones de clases en el directorio Model o View, o que no sean scripts php en el directorio Controller:</p>
<?php
        if(count($tipoFile)==0){
?>
                                <p class="text-left"><b>Todos los archivos de las tres carpetas cumplen la norma previamente mencionada</b></p>
<?php
        }
        else{
            for($i=0;$i<count($tipoFile);$i++){
?>
                                <p class="text-left"><b><?=$tipoFile[$i][0]?> (<?=$tipoFile[$i][1]?>)</b></p>
<?php
            }
        }
?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<h3 class="mb-30">Index solitario</h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">El index es el único archivo (no directorio) que se encuentra en la raiz del codigo subido: <b>
<?php
        if($soloIndex){
?>
                                SI</b></p>
<?php
        }
        else{
?>
                                NO</b></p>
<?php
        }
?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<a href="../index.php"><img src="../img/back.png" alt="" width="8%"></a>
					</div>
				</div>
			</div>
			<!-- End text Area -->

			<!-- Start footer Area -->
			<footer class="footer-area">
				<div class="container">
					<div class="footer-content d-flex flex-column align-items-center">
						<div class="footer-menu">
							<a href="#">Home</a>
							<a href="#">Generic</a>
							<a href="#">Elements</a>
						</div>
						<div class="footer-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
						<div class="copy-right-text">Copyright &copy; 2018 All rights reserved</div>

					</div>
				</div>
			</footer>
			<!-- End footer Area -->
		</div>
		<!-- End Amazing Works Area -->

		<script src="../js/vendor/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="../js/vendor/bootstrap.min.js"></script>
		<script src="../js/jquery.ajaxchimp.min.js"></script>
		<script src="../js/jquery.nice-select.min.js"></script>
		<script src="../js/jquery.magnific-popup.min.js"></script>
		<script src="../js/main.js"></script>
	</body>
</html>

<?php
    }
}
?>
