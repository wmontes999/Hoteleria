<?php
session_start();
if (array_key_exists("usuario",$_POST))
{
 require_once "../modelos/Conexion.php"; 
 require_once "../modelos/sessionDAO.php"; 
 require_once "session.php"; 
}

if ($_SESSION['usurnom'] == '')
{
	$_SESSION['usur'] = null;
	$_SESSION['pass'] = null;
    $_SESSION["token"] = "erroruser";
    header('location: logout.php');
}

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sistema de Hoteles | DECAMERON</title>

        <link href="../../libreria/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../libreria/css/semantic.min.css" rel="stylesheet">
        <link href="../../libreria/css/sidebar-nav.min.css" rel="stylesheet">
        <link href="../../libreria/css/animate.css" rel="stylesheet">
        <link href="../../libreria/css/style.css<?php echo "?V=".time();?>" rel="stylesheet">
        <link href="../../libreria/css/colores/default.css" id="theme" rel="stylesheet">
        <link href="../../libreria/css/jquery.toast.css" rel="stylesheet">
        <link href="../../libreria/css/sweet/sweetalert.css" rel="stylesheet">
        <link href="../../libreria/dataTables/botones/buttons.dataTables.min.css" rel="stylesheet">
		<link href="../../libreria/dataTables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    </head>

<body class="header">
        <script src="../../libreria/js/jquery.min.js"></script>

        <div class="preloader">
            <div class="css_fya"></div>
        </div>
        <div id="wrapper">
            <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li style="margin-left: -25px;">
                <a class="logo" href="../../">
                    <img style="margin-top: 2px; margin-bottom: -15px; width:70px" src="../imagenes/fya.jpg" alt="Sistema de Control de Caja" />
                </a>
            </li>

				<li>
                    <a href="javascript:menu_principal('Principal','Principal')" class="waves-effect ">
                        <div class="hide-menu">
                            <i class="fa fa-home"></i>
                            Principal
						</div>
                    </a>
				</li>
				
					<?php					
					
					/*
					?>
					<li>
                    <a href="javascript:void(0)" class="waves-effect ">
                        <div class="hide-menu">
                            <i class="fa fa-bar-chart-o"></i>
								Reportes
								<span class="fa arrow"></span>
						</div>
                    </a>
						<ul class="nav nav-second-level">
						<li>
							<a href="javascript:menu_principal('Arqueo','Reportes')" class="waves-effect ">
							<div class="hide-menu">
								<i class=""></i>
									Arqueo
							</div>
							</a>
						</li>
						<li>
							<a href="javascript:menu_principal('Desglose','Reportes')" class="waves-effect ">
								<div class="hide-menu">
									<i class=""></i>
										Desglose de registros
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:menu_principal('InformePag','Reportes')" class="waves-effect ">
								<div class="hide-menu">
								<i class=""></i>
									Informe de pagos de una persona
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:menu_principal('PagosPend','Reportes')" class="waves-effect ">
								<div class="hide-menu">
								<i class=""></i>
									Pagos pendientes
								</div>
							</a>
						</li>
						<li>
							<a href="javascript:menu_principal('PagPendPorNomb','Reportes')" class="waves-effect ">
								<div class="hide-menu">
									<i class=""></i>
										Pagos pendientes con nombre
								</div>
							</a>
						</li>
						</ul>
					</li>
					<?php
					*/
					?>
					
					
					
					
					<li>
						<a href="javascript:void(0)" class="waves-effect ">
							<div class="hide-menu">
								<i class="fa fa-gears"></i>
									Administraci&oacute;n
									<span class="fa arrow"></span>
							</div>
						</a>
						<ul class="nav nav-second-level">
						<li>
							<a href="javascript:void(0)" class="waves-effect ">
								<div class="hide-menu">
									<i class="filter icon"></i>
									Hoteles
										<span class="fa arrow"></span>
								</div>
							</a>
							<ul class="nav nav-third-level">
							<li>
								<a href="javascript:menu_principal('CrearHoteles','Administracion')" class="waves-effect ">
									<div class="hide-menu">
										<i class=""></i>
										Crear Registro de Hotel
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:menu_principal('CrearHabit','Administracion')" class="waves-effect ">
									<div class="hide-menu">
										<i class=""></i>
										Crear Habitaciones
									</div>
								</a>
							</li>
							</ul>
						</li>
						

						
						<?php
							
							
							if (($_SESSION['NivPerm_7'] == "1") or ($_SESSION['NivPerm_17'] == "1") or ($_SESSION['NivPerm_27'] == "1"))
							{
						?>
						<li>
							<a href="javascript:void(0)" class="waves-effect ">
								<div class="hide-menu">
									<i class="users icon"></i>
									Usuarios
									<span class="fa arrow"></span>
								</div>
							</a>
							<ul class="nav nav-third-level">
							<?php 
							if ($_SESSION['NivPerm_17'] == "1")
							{
							?>
							<li>
								<a href="javascript:menu_principal('CrearUsuarios','Administracion')" class="waves-effect ">
									<div class="hide-menu">
										<i class=""></i>
										Crear usuario
									</div>
								</a>
							</li>
							<?php 
							}//if
							if (($_SESSION['NivPerm_27'] == "1") or ($_SESSION['NivPerm_7'] == "1"))
							{
							?>
							<li>
								<a href="javascript:menu_principal('ModifUsuarios','Administracion')" class="waves-effect ">
									<div class="hide-menu">
										<i class=""></i>
										Modificar usuario
									</div>
								</a>
							</li>
							<?php 
							}
							?>
							</ul>
						</li>
						<?php
							}						
						?>
						</ul>
					</li>            
            <li><a href="logout.php" class="waves-effect"><i class="fa fa-power-off"></i><span class="hide-menu">Cierre de sesi&oacute;n</span></a></li>

            <li class="right-side-toggle show_notify" style="display: none; float: right; margin-right: 10px;">
                <a class="waves-effect waves-light show_notify_click" href="javascript:void(0)">
                    <i class="icon-envelope"></i>
                    <div class="notify" style="margin-top: -9px; margin-right: 5px;">
                        <span class="heartbit"></span>
                        <span class="point"></span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
	<div id="page-wrapper" style="background-color: white;">
	</div>
	</div>
	<script src="../../libreria/js/bootstrap.min.js"></script>
	<script src="../../libreria/js/semantic.min.js"></script>
	<script src="../../libreria/js/sidebar-nav.min.js"></script>
	<script src="../../libreria/js/jquery.slimscroll.js"></script>
	<script src="../../libreria/js/waves.js"></script>
	<script src="../../libreria/js/custom.min.js"></script>
	<script src="../../libreria/js/jquery.toast.js"></script>
	<script src="../../libreria/js/jquery.mask.min.js"></script>
	<script src="../../libreria/js/sweet/sweetalert.min.js"></script>
	<script src="../../libreria/js/autoNumeric.min.js"></script>		
	<script src="../../libreria/js/jquery.dataTables.min.js"></script>	
	<script src="../../libreria/dataTables/botones/dataTables.buttons.min.js"></script>	
	<script src="../../libreria/dataTables/botones/buttons.flash.min.js"></script>	
	<script src="../../libreria/dataTables/botones/buttons.html5.min.js"></script>	
	<script src="../../libreria/dataTables/botones/buttons.print.min.js"></script>	
	<script src="../../libreria/dataTables/botones/jszip.min.js"></script>	
	<script src="../../libreria/dataTables/botones/pdfmake.min.js"></script>	
	<script src="../../libreria/dataTables/botones/vfs_fonts.js"></script>		
	<script src="../../libreria/datapicker/bootstrap-datepicker.js"></script>
    <script src="../../libreria/datapicker/bootstrap-datepicker.es.js"></script>
	<script src="../../libreria/js/jshoteleria.js<?php echo "?V=".time();?>"></script>
	<script src="../../libreria/js/sha1.js<?php echo "?V=".time();?>"></script>		
	<script>
	<?php 
	if ((array_key_exists("Param1",$_GET)) and (array_key_exists("Param2",$_GET)))
	{
		$Param1 = $_GET["Param1"];
		$Param2 = $_GET["Param2"];
		?>
		principal_cal();
		menu_principal('<?php echo $Param1;?>','<?php echo $Param2;?>');
		<?php
	}else
	if ($_SESSION['NivPerm_31'] == "1")
	{
		if ($_SESSION['TipoUsuar'] <> "Estudiante")
		{
	?>
		menu_principal('Principal','Principal');
	<?php				
		}else {
			?>
			$('.ui.dropdown').dropdown();			
			<?php
		}
		?>
		principal_cal();
		<?php
	}
	?>

	</script>        
    </body>	
	

</html>