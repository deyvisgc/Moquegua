<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>

	* {
		font-size: 12px;
		font-family: 'Times New Roman';
	}

	.centrado {
		text-align: center;
		align-content: center;
	}

	.ticket {
		width: 155px;
		max-width: 155px;
	}

	img {
		max-width: inherit;
		width: inherit;
	}
	.cliente{
		font-size: 12px;
		size: 10px;
       text-align: left;
	}
	hr {
		color: #000000;
		font-size: 10px;
		width:200px;
	}
	.style_linea_tab1{
		font-size: 12px;
		size: 10px;
		text-align: left;
	}
	.clearfix{
		font-size: 12px;
		size: 10px;
		text-align: left;
	}
	.style_tabla{
		width: 50%;
		height: auto;
	}

</style>


	<div class="ticket">
		<img src="<?= base_url() ?>../imagen/logo.jpg" style="width: 100px ;height: auto;" alt="Logotipo">
		<p class="centrado">PUNTO DE VENTAS</p>
		<p class="centrado"><?= $salida->sal_fecha_doc_cliente ?></p><hr>

		<div class="row">
			<p  class="clearfix">
				<span class="float-left">Cliente</span>:
			<span class="cliente"><?= $salida->emp_razon_social ?></span>
			</p>
			<p  class="clearfix">
				<span class="float-left">Ruc</span>:
				<span class="cliente "><?= $salida->emp_ruc ?></span>
			</p>
			<p  class="clearfix">
				<span class="float-left">Doc cliente</span>:
				<span class="cliente "><?= $salida->sal_numero_doc_cliente ?></span>
			</p>
			<p class="clearfix">
				<span class="float-left">Direcion</span>:
				<span class="cliente "><?= $salida->emp_direccion ?></span>
			</p><hr>
		</div>

		<div class="style_tabla">
			<table >
				<thead>
				<th>Productos</th>
				<th>cantidad</th>
				<th>Precio</th>
				<th>Monto</th>

				</thead>
				<tbody>
				<?php

				foreach ($list_salida_detalle as $salida_detalle) {
				?>
			<tr>
					<td width="5" heigth="5"> <span class="style_linea_tab1" style="width: 100px ;height: auto;"><?= $salida_detalle->pro_nombre ?></span></td>
					<td width="5" heigth="5"><span class="style_linea_tab1"><?= $salida_detalle->sad_cantidad ?></span></td>
					<td > <span class="style_linea_tab1" style="width: 100px ;height: auto;"><?= $salida_detalle->sad_valor ?></span></td>
					<td><span class="style_linea_tab1" style="width: 100px ;height: auto;"><?= $salida_detalle->sad_monto ?></span></td>
				</tr>




					<?php
				}
				?>
				</tbody>
			</table><hr>
			<td >TOTAL <span style="margin-left: 50%" class="label label-default pull-right "><?= $salida->sal_monto ?></span></td>
			<td >VUELTO<span style="margin-left: 50%" class="label label-default pull-right "><?= $salida->sal_vuelto ?></span></td>
		</div>

		<p class="centrado">¡GRACIAS POR SU COMPRA!</p><hr>
		<p class="centrado">DETALLE DE VENTA</p>
		<div class="row">
			<p  class="clearfix">
				<span class="float-left">Compovante</span>:
				<span class="cliente "><?= $salida->tdo_nombre?></span>
			</p>
			<p class="clearfix">
				<span class="float-left">N# Comprobante</span>:
				<span class="cliente "><?= $salida->sal_numero_doc_cliente?></span>
			</p><hr>
		</div>
		<div class="style_tabla">
			<table>
				<thead>
				<th>Cantidad</th>
				<th>Descripcion</th>
				<th>monto</th>
				</thead>
				<tbody>
				<?php

				foreach ($list_salida_detalle as $salida_detalle) {
					?>
					<tr>
						<td> <span class="style_linea_tab2" style=""></span><?= $salida_detalle->sad_cantidad ?></td>
						<td><span class="style_linea_tab1" style=""><?= $salida_detalle->pro_nombre ?></span></td>
						<td><span class="style_linea_tab4" style=""><?= $salida_detalle->sad_monto ?></span></td>
					</tr>

					<?php
				}
				?>
				</tbody>
			</table><hr>
			<td class = "text-left">TOTAL <span style="margin-left: 50%" class="label label-default pull-right "><?= $salida->sal_monto ?></span></td>
		</div><br>

	</div>


