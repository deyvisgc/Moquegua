<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
						<small><?= $fecha_actual ?></small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<a href="<?= base_url() ?>bienvenida"><i class="fa fa-home"></i> Inicio</a>
						</li>
						<li class="active">Bienvenida</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div id="pone_compras">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-aqua">
									<div class="inner">
										<h3><span id="sp_stock_minimo">0</span></h3>
										<p>STOCK MINIMO</p>
									</div>
									<div class="icon">
										<i class="ion ion-stats-bars"></i>
									</div>
									<a href="#" class="small-box-footer">Ver otras entradas <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div><!-- ./col -->
						</div>
						<div id="pone_ventas">
							<div class="col-lg-3 col-xs-6"><!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3><span id="sp_ventas_del_dia">0.00</span></h3>
										<p><b>VENTAS DEL DÍA</b></p>
									</div>
									<div class="icon">
										<i class="ion ion-bag"></i>
									</div>
									<a href="#" class="small-box-footer">Consultar otra fecha <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div><!-- ./col -->
						</div>
						<div id="pone_gastos">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3><span id="sp_gastos_registrados">0.00</span></h3>
										<p><b>GASTOS DEL DÍA</p>
									</div>
									<div class="icon">
										<i class="ion ion-calendar"></i>
									</div>
									<a href="#" class="small-box-footer">Consultar otros <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div><!-- ./col -->
						</div>
						<div id="pone_users">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-green">
									<div class="inner">
										<h3><span id="sp_numero_clientes">0</span></h3>
										<p><b>NUMERO CLIENTE</b>S</p>
									</div>
									<div class="icon">
										<i class="ion ion-person-add"></i>
									</div>
									<a href="#" class="small-box-footer">Operaciones con usuarios <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div><!-- ./col -->
						</div>
						<div class="col-md-6">
							<!-- solid sales graph -->
							<div class="box box-solid">
								<div class="box-header">
									<i class="fa fa-th"></i>
									<h3 class="box-title">Grafica de ventas por lineas ($).</h3>
									<div class="box-tools pull-right">
										<button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body border-radius-none">
									<div class="chart" id="line-chart-ventas" style="height: 250px;">
										<svg height="250" version="1.1" width="555" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">
											<desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc>
											<defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
											<path fill="none" stroke="#3c8dbc" d="M277.5,201.66666666666669" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path>
											<path fill="#3c8dbc" stroke="#ffffff" d="M277.5,204.66666666666669A115,115,0,0,1,277.5,240Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
											<text x="277.5" y="115" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.0513,0,0,1.0513,-14.2363,-6.4642)" stroke-width="0.9512001811594203">
												<tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">No hay ventas...</tspan>
											</text>
											<text x="277.5" y="135" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(1.5972,0,0,1.5972,-165.7852,-75.8472)" stroke-width="0.6260869565217391">
												<tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
											</text>
										</svg>
									</div>
								</div><!-- /.box-body -->
								<div class="box-footer no-border">
								</div><!-- /.box-footer -->
							</div><!-- /.box -->
						</div>
						<div class="col-md-6">
							<!-- solid sales graph -->
							<div class="box box-solid">
								<div class="box-header">
									<i class="fa fa-th"></i>
									<h3 class="box-title">Grafica de existencias por lineas ($).</h3>
									<div class="box-tools pull-right">
										<button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body border-radius-none">
									<div class="chart" id="line-chart-existe" style="height: 250px;">
										<svg height="250" version="1.1" width="555" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc>
											<defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
											<path fill="none" stroke="#3c8dbc" d="M277.5,201.66666666666669" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path>
											<path fill="#3c8dbc" stroke="#ffffff" d="M277.5,204.66666666666669A115,115,0,0,1,277.5,240Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
											<text x="277.5" y="115" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(0.8057,0,0,0.8057,53.9204,24.4828)" stroke-width="1.2411684782608696">
												<tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">No hay existencias...</tspan>
											</text>
											<text x="277.5" y="135" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(1.5972,0,0,1.5972,-165.7852,-75.8472)" stroke-width="0.6260869565217391">
												<tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan>
											</text>
										</svg>
									</div>
								</div><!-- /.box-body -->
								<div class="box-footer no-border">
								</div><!-- /.box-footer -->
							</div><!-- /.box -->
						</div>
					</div>
				</section>
			</div><!-- /.content-wrapper -->
			<script>
			function init_bienvenida() {
				reload_bienvenida();
			}
			function reload_bienvenida() {
				$.ajax({
					type: "POST",
					url: BASE_URL+"bienvenida/reload_bienvenida",
					dataType: 'json',
					data: null,
					success: function(datos) {
						if(datos.hecho === 'SI') {
							$('#sp_stock_minimo').text(datos.data.stock_minimo);
							$('#sp_ventas_del_dia').text(datos.data.ventas_del_dia);
							$('#sp_gastos_registrados').text(datos.data.gastos_registrados);
							$('#sp_numero_clientes').text(datos.data.numero_clientes);
						}
					}
				});
			}
			</script>
