<?php
/**
 * Este archivo contiene una vista que enseña la Configuración de un directorio
 *
 * @author Iago Nóvoa González
 *
 * Fecha: 12/06/2018
*/

class verPatronView{
    function __construct($directorio,$patron,$archivosRequeridos){
        $this->render($directorio,$patron,$archivosRequeridos);
    }
    
    function render($directorio,$patron,$archivosRequeridos){
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
								<h1 class="text-white">Configuración del Análisis</h1>
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
						<h3 class="mb-30">Patrón de <?=$directorio?></h3>
						<div class="row justify-content-center">
							<div class="col-md-10">
								<p class="sample-text">El nombre de los archivos de <?=$directorio?> han de cumplir con el siguiente patrón:</p>
<?php
        if($patron==''){
?>
                                <p class="sample-text">El directorio <?=$directorio?> no tiene un patrón asignado (<a href="../controller/confController.php?action=loadEditPatron&directorio=<?=$directorio?>"><u>añadir patrón</u></a>)</p>
<?php
        }
        else{
?>
                                <p class="sample-text"><b><?=$patron?></b> (<a href="../controller/confController.php?action=loadEditPatron&directorio=<?=$directorio?>"><u>editar patrón</u></a>)</p>
<?php
        }
?>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- End text Area -->

            <div class="white-bg">
				<div class="container">
                    <div class="section-top-border text-center">
                        <h3 class="mb-30">Tabla de Archivos Requeridos de <?=$directorio?></h3>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <p class="sample-text">Se comprobará si <?=$directorio?> contiene los siguientes archivos:</p>
<?php
        if(count($archivosRequeridos)==0){
?>
                                <p class="sample-text">El directorio <?=$directorio?> no tiene ningún archivo requerido</p>
<?php
        }
        else{
?>
                            </div>
                        </div>
                        <div class="progress-table-wrap">
							<div class="progress-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td width="50%" align=center><b>Archivos requeridos</b></td>
                                            <td width="50%" align=center><b>Borrar</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
            for($i=0;$i<count($archivosRequeridos);$i++){
?>
                                        <tr>
                                            <td width="50%" align=center><?=$archivosRequeridos[$i]?></td>
                                            <td width="50%" align=center>
                                                <a href="../controller/confController.php?action=deleteArchivo&directorio=<?=$directorio?>&archivo=<?=$archivosRequeridos[$i]?>"><img src="../img/delete.png" alt="" width="4%"></a>
                                            </td>
                                        </tr>
<?php
            }
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
<?php
        }
?>
                        <br><br>
                        <div class="text-center">
                            <a href="../controller/confController.php?action=loadCreateArchivo&directorio=<?=$directorio?>">Añadir nuevo archivo requerido <img src="../img/add.png" alt="" width="3%"></a>
                        </div>
                    </div>
                </div>
            </div>

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<a href="../controller/confController.php?action=verConf"><img src="../img/back.png" alt="" width="8%"></a>
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
