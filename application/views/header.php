<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
		<title><?= $title ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="icon" type="image/png" href="<?= base_url() ?>../imagen/gvm.ico" />

		<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css"> -->
		<link rel="stylesheet" href="<?= base_url() ?>../resources/css/ui-1-12-1/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>../resources/css/ui-1-8-16/jquery-ui.css">
		
		<!-- <link rel="stylesheet" href="//resources/demos/style.css"> -->
		<!-- Main CSS -->
		<link rel="stylesheet" href="<?= base_url() ?>../resources/css/main.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="<?= base_url() ?>../resources/dist/css/ionicons.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?= base_url() ?>../resources/plugins/iCheck/square/blue.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="<?= base_url() ?>../resources/css/fontawesome-all.min.css">
		<link rel="stylesheet" href="<?= base_url() ?>../resources/css/systyle.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

		<style>
		* {
			/* box-sizing: border-box; */
		}

		.zoom {
			/* padding: 50px; */
			/* background-color: green; */
			transition: transform .2s;
			/* width: 200px;
			height: 200px; */
			margin: 0 auto;
			/* z-index: 1001; */
			/* z-index: 1001; */
			/* position: absolute; */
		}

		.zoom:hover {
			/* padding-left: 10px; */
			-ms-transform: scale(1.7); /* IE 9 */
			-webkit-transform: scale(1.7); /* Safari 3-8 */
			transform: scale(1.7);
			
		}
		
		.alinear_derecha { text-align: right; }
		
		/* AUTOCOMPLETE */
		.ui-autocomplete {
			max-height: 240px;
			overflow-y: auto;
			/* prevent horizontal scrollbar */
			overflow-x: hidden;
			padding-right: 10px;
			padding-left: 10px;
			padding-top: 10px;
			padding-bottom: 10px;
			color: blue !important;
		}
		/* .ui-state-hover {
			background: #428BCA !important;
		} */
		.ui-menu .ui-menu-item a{
			/* background:red;
			height:10px;
			font-size:8px; */
			color: blue;
		}
		
		/* IE 6 doesn't support max-height
		* we use height instead, but this forces the menu to always be this tall
		*/
		* html .ui-autocomplete {
			height: 240px;
		}
		
		.wrapper {
			background: #00507d;
		}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<!-- Main Header -->
			<header class="main-header">
				<!-- Logo -->
				<a href="<?= base_url() ?>bienvenida" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>S</b>M</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>PUNTO</b> DE VENTA</span>
				</a>
				<!-- Header Navbar -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Messages: style can be found in dropdown.less-->
							
							<!-- Notifications Menu -->
							<li class="dropdown notifications-menu">
								<!-- Menu toggle button -->
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-info-circle"></i>
									<span class="label label-info num_noti">!</span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">
										<img src="<?= base_url() ?>../imagen/logo-2.png" class="img-circle" alt="User Image">
										<span>GRUPO SYSYTEM V&V </span>
									</li>
									<li>
										<!-- inner menu: contains the messages -->
										<ul class="menu">
											<li><!-- start message -->
												<label class="css_ltr_blanco">-----------------------------------------------------</label>
												<label class="css_ltr_blanco">Cor: contact@gruposystemvv.com</label>
												<label class="css_ltr_blanco">Dir: Calle los Flamencos </label>
												<label class="css_ltr_blanco">&nbsp;&nbsp;&nbsp;&nbsp;551 Santa - Anita Lima -Perú</label>
												<label class="css_ltr_blanco">Tel: (+51) 01-395-8590</label>
												<label class="css_ltr_blanco">-----------------------------------------------------</label>
												<a href="http://www.gruposystemvv.com/contact.html"><label class="css_ltr_blanco">Ir GRUPO SYSYTEM V&V</label></a>
												<p></p>
												
											</li><!-- end message -->
										</ul><!-- /.menu -->
									</li>
								</ul>
								<?php /* ?>
								<ul class="dropdown-menu">
									<li class="header">Centro de Soporte:</li>
									<li>
										<!-- Inner Menu: contains the notifications -->
										<ul class="menu">
											<li>Correo: </li>
											<li>Telefono: </li>
										</ul>
									</li>
									<!--<li class="footer"><a href="#">View all</a></li>-->
								</ul>
								<?php */ ?>
							</li>
							
							<!-- Notifications Menu -->
							<!-- 2018-08-05 SY <li class="dropdown notifications-menu">
								< !-- Menu toggle button -- >
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-bell-o"></i>
									<span class="label label-danger num_noti">0</span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">Productos Para Caducar...</li>
									<li>
										< !-- Inner Menu: contains the notifications -- >
										<ul class="menu arti_caducos">
										</ul>
									</li>
									< !--<li class="footer"><a href="#">View all</a></li>-- >
								</ul>
							</li> -->
							<!-- Tasks Menu -->
							<!-- 2018-08-05 SY <li class="dropdown tasks-menu">
								< !-- Menu Toggle Button -- >
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-flag-o"></i>
									<span class="label label-warning">0</span>
								</a>
								<ul class="dropdown-menu">
									<li class="header">0 tareas pendientes.</li>
								</ul>
							</li> -->
							<!-- User Account Menu -->
							<li class="dropdown user user-menu">
								<!-- Menu Toggle Button -->
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<!-- The user image in the navbar-->
									<img src="<?= base_url() ?>../resources/sy_file_repository/<?= $usuario['per_foto'] ?>" class="user-image" alt="User Image">
									<!-- hidden-xs hides the username on small devices so only the image appears. -->
									<span class="hidden-xs"><?= $usuario['per_nombre'] ?> <?= $usuario['per_apellido'] ?></span>
								</a>
								<ul class="dropdown-menu">
									<!-- The user image in the menu -->
									<li class="user-header">
										<img src="<?= base_url() ?>../resources/sy_file_repository/<?= $usuario['per_foto'] ?>" class="img-circle" alt="User Image">
										<p>Usuario: <?= $usuario['usu_nombre'] ?> [<?= $usuario['per_nombre'] ?> <?= $usuario['per_apellido'] ?>]<!--<small>Member since Nov. 2012</small>--></p>
									</li>
									<!-- Menu Body -->
									<!--<li class="user-body">
									<div class="col-xs-4 text-center">
									<a href="#">Followers</a>
									</div>
									<div class="col-xs-4 text-center">
									<a href="#">Sales</a>
									</div>
									<div class="col-xs-4 text-center">
									<a href="#">Friends</a>
									</div>
									</li>-->
									<!-- Menu Footer-->
									<li class="user-footer">
										<a href="#!" class="btn btn-info btn-block clss_a_show_perfil"><i class='fa fa-user'></i> Perfil</a>
										<a href="<?= base_url() ?>logueo/salir" class="btn btn-danger btn-block btn-exit-system"><i class='fa fa-power-off'></i> Salir</a>
									</li>
								</ul>
							</li>
							<!-- Control Sidebar Toggle Button -->
							<!--<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
							</li>-->
						</ul>
					</div>
				</nav>
			</header>
			
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<!-- Sidebar user panel (optional) -->
					<div class="user-panel">
						<div class="pull-left image">
							<img src="<?= base_url() ?>../resources/sy_file_repository/<?= $usuario['per_foto'] ?>" class="img-circle" alt="User Image">
						</div>
						<div class="pull-left info">
							<p><?= $usuario['per_nombre'] ?> <?= $usuario['per_apellido'] ?></p>
							<!-- Status -->
							<a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
						</div>
					</div>
					<!-- Sidebar Menu -->
					<ul class="sidebar-menu">
						<li class="header">MENU</li>
						<!-- Optionally, you can add icons to the links -->
						<?php
						$treeview_menu = "";
						$pri_grupo_aux = "";
						foreach ($list_privilegio as $valor) {
							$style = '';
							$html_li = '';
							if($pri_grupo == $valor->pri_grupo && $pri_nombre == $valor->pri_nombre) {
								$style = 'style="color: #fff;"';
								$html_li = '<i class="fa fa-circle pull-right"></i>';
							}
							
							if($pri_grupo_aux != $valor->pri_grupo) {
								if($pri_grupo_aux != '') {
									$treeview_menu = $treeview_menu.'</ul></li>';
								}
								$pri_grupo_aux = $valor->pri_grupo;
								$active = "";
								if($pri_grupo == $valor->pri_grupo) {
									$active = "active";
								}
								$treeview_menu = $treeview_menu.'<li class="treeview '.$active.'">
							<a href="#">
								<i class="fa fa-'.$valor->pri_ico_grupo.'"></i>
								<span>'.$valor->pri_grupo.'</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li>
									<a href="'.base_url().$valor->pri_acceso.'" '.$style.'><i class="fa fa-'.$valor->pri_ico.'"></i> '.$valor->pri_nombre.$html_li.'</a>
								</li>';
							}
							else {
								$treeview_menu = $treeview_menu.'
								<li>
									<a href="'.base_url().$valor->pri_acceso.'" '.$style.'><i class="fa fa-'.$valor->pri_ico.'"></i> '.$valor->pri_nombre.$html_li.'</a>
								</li>';
							}
						}
						if($treeview_menu != '') {
							$treeview_menu = $treeview_menu.'</ul></li>';
						}
						echo $treeview_menu;
						?>
						
					</ul><!-- /.sidebar-menu -->
				</section>
				<!-- /.sidebar -->
			</aside>
