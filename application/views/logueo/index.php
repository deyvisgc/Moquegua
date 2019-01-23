<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>LOGUEO</title>
		<link rel="icon" type="image/png" href="<?= base_url() ?>../imagen/gvm.ico" />
		<link rel="stylesheet" href="<?= base_url() ?>../js/bootstrap.min.css">
		<script src="<?= base_url() ?>../js/jquery.min.js"></script>
		<script src="<?= base_url() ?>../js/bootstrap.min.js"></script>
		<style>
			form {
				max-width: 360px;
				border: 2px solid #dedede;
				padding: 38px;
				margin-top: 25px;
				border-radius: 25px;
				background-color: white;
				/* background: #fff; */
			}
			body {
				background-color: #ecf0f5;
			}
		</style>
	</head>
	<body>
		<center>
			<form class="form-signin" action="<?php echo base_url(); ?>logueo/acceder" method="POST">
				<h1 class="h3 mb-3 font-weight-normal">PUNTO DE VENTA</h1>
				<hr>
				<div class="form-group">
					<label for="in_usu_nombre">Usuario</label>
					<input type="text" id="in_usu_nombre" name="usu_nombre" class="form-control" placeholder="Usuario" required >
				</div>
				<div class="form-group">
					<label for="in_usu_clave">Clave</label>
					<input type="password" id="in_usu_clave" name="usu_clave" class="form-control" placeholder="Clave" required>
				</div>
				<hr>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
				<a>
					<br>Copyright © 2018 Derechos reservados  <br> premymco<br>
					Implementado por:<a href="http://gruposystemvv.com/">GSVV</a>
				</a>
			</form>
		</center>
	</body>
</html>
