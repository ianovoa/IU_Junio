<?php
/**
 * Este archivo contiene una vista que enseña la Configuración
 *
 * @author iago
 *
 * Fecha: 12/11/2017
*/

class verConfView{
    function __construct($directoriosConf){
        $this->render($directoriosConf);
    }
    
    function render($directoriosConf){
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

            <div class="white-bg">
				<div class="container">
                    <div class="section-top-border">
                        <h3 class="mb-30">Tabla de Directorios</h3>
                        <div class="progress-table-wrap">
							<div class="progress-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td width="40%"><b>Directorios</b></td>
                                            <td width="30%" align=center><b>Ver Patrones</b></td>
                                            <td width="30%" align=center><b>Borrar</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
        for($i=0;$i<count($directoriosConf);$i++){
?>
                                        <tr>
                                            <td width="40%">
                                                <?=$directoriosConf[$i]?>
                                            </td>
                                            <td width="30%" align=center>
                                                <a href="../controller/confController.php?action=verPatrones&directorio=<?=$directoriosConf[$i]?>"><img src="../img/view.png" alt="" width="7%"></a>
                                            </td>
                                            <td width="30%" align=center>
<?php
            if($directoriosConf[$i]=='Model' || $directoriosConf[$i]=='Controller' || $directoriosConf[$i]=='View'){
?>
                                                No se puede borrar
<?php
            }
            else{
?>
                                                <a href="../controller/confController.php?action=delete&directorio=<?=$directoriosConf[$i]?>"><img src="../img/delete.png" alt="" width="7%"></a>
<?php
            }
?>
                                            </td>
                                        </tr>
<?php
        }
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<!-- Start text Area -->
			<div class="white-bg">
				<div class="container">
					<div class="section-top-border text-center">
						<a href="../controller/confController.php?action=loadCreate">Añadir nuevo directorio <img src="../img/add.png" alt="" width="3%"></a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="../controller/confController.php?action=default">Configuración predeterminada <img src="../img/default.png" alt="" width="3%"></a>
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
