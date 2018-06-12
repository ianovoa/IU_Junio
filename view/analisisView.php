<?php
/**
 * Este archivo contiene una vista que enseña el resultado del analisis
 *
 * @author iago
 *
 * Fecha: 12/11/2017
*/

class analisisView{
    function __construct($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$soloIndex) {
        $this->render($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$soloIndex);
    }
    
    function render($directorios,$fileName,$tipoFile,$cabeceras,$comentariosFun,$comentariosCon,$soloIndex){
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
								<a href="index.html"><img src="../img/logo.png" alt="" width="20%"></a>
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
						<h3 class="mb-30">Directorios obligatorios</h3>
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán los directorios especificados en el fichero Directories.conf que no se encuentran en el código analizado:</p>
<?php
        if(count($directorios)==0){
?>
                                <p class="text-left"><b>No falta ninguno de los directorios especificados en el fichero Directories.conf</b></p>
<?php
        }
        else{
            for($i=0;$i<count($directorios);$i++){
?>
                                <p class="text-left"><b><?=$directorios[$i]?></b></p>
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
						<h3 class="mb-30">Nombre de los ficheros</h3>
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán los ficheros cuyo nombre no coindida con el patrón especificado para cada directorio en el fichero Files.conf:</p>
<?php
        if(count($fileName)==0){
?>
                                <p class="text-left"><b>Todos los archivos coindiden con su respectivo patrón</b></p>
<?php
        }
        else{
            for($i=0;$i<count($fileName);$i++){
?>
                                <p class="text-left"><b><?=$fileName[$i]?></b></p>
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
						<h3 class="mb-30">Tipo de los ficheros</h3>
						<div class="row">
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
						<h3 class="mb-30">Cabeceras de los ficheros</h3>
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán los ficheros que no recojan información al principio del archivo sobre el autor, la fecha o la función del código:</p>
<?php
        if(count($cabeceras)==0){
?>
                                <p class="text-left"><b>Todos los archivos tienen recogida la informacion mencionada</b></p>
<?php
        }
        else{
            for($i=0;$i<count($cabeceras);$i++){
?>
                                <p class="text-left"><b>
                                    <?=$cabeceras[$i][0]?>, le falta: 
<?php
                $max=count($cabeceras[$i]);
                for($j=1;$j<count($cabeceras[$i]);$j++){
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
						<h3 class="mb-30">Funciones comentadas</h3>
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán las funciones (y sus ficheros) que no recojan información al principio de la misma respecto a su función:</p>
<?php
        if(count($comentariosFun)==0){
?>
                                <p class="text-left"><b>Todos los archivos tienen recogida la informacion mencionada</b></p>
<?php
        }
        else{
            for($i=0;$i<count($comentariosFun);$i++){
?>
                                <p class="text-left"><b>
                                    <u><?=$comentariosFun[$i][0]?></u>, le falta comentario a:<br>
<?php
                $max=count($comentariosFun[$i]);
                for($j=1;$j<count($comentariosFun[$i]);$j++){
?>
                                    <?=$comentariosFun[$i][$j]?><br>
<?php
                }
?>
                                </b></p>
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
						<h3 class="mb-30">Funciones comentadas</h3>
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">A continuacion se listarán las estructuras de control (y sus ficheros) que no recojan información al principio de la misma respecto a su función:</p>
<?php
        if(count($comentariosCon)==0){
?>
                                <p class="text-left"><b>Todos los archivos tienen recogida la informacion mencionada</b></p>
<?php
        }
        else{
            for($i=0;$i<count($comentariosCon);$i++){
?>
                                <p class="text-left"><b>
                                    <u><?=$comentariosCon[$i][0]?></u>, le falta comentario a:<br>
<?php
                $max=count($comentariosCon[$i]);
                for($j=1;$j<count($comentariosCon[$i]);$j++){
?>
                                    <?=$comentariosCon[$i][$j]?><br>
<?php
                }
?>
                                </b></p>
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
						<div class="row">
							<div class="col-md-10">
								<p class="sample-text">El index es el único archivo (no directorio) que se encuentra en la raiz del codigo subido: 
<?php
        if($soloIndex){
?>
                                <b>SI</b></p>
<?php
        }
        else{
?>
                                <b>NO</b></p>
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
