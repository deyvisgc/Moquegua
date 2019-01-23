<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('reporte_model');
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'REPORTE';
		$data_header['pri_nombre'] = 'Movimiento';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "REPORTE MOVIMIENTO";
		$data_footer['inits_function'] = array("init_movimiento");
		$this->load->view('header', $data_header);
		$this->load->view('reporte/movimiento/index');
		$this->load->view('footer', $data_footer);
	}
	public function bmovimiento_diario_ingreso()
	{
		is_logged_in_or_exit($this);
		$fecha_ini = $this->input->post('fecha_ini');
		$fecha_fin = $this->input->post('fecha_fin');
		$list = $this->reporte_model->mmovimiento_diario_ingreso($fecha_ini, $fecha_fin);
		$list_totales = $this->reporte_model->mmovimiento_diario_totales_ingreso($fecha_ini, $fecha_fin);
		$data = array('hecho' => 'SI', 'data' => $list, 'data_totales' => $list_totales);
		echo json_encode($data);
	}
	public function bmovimiento_diario_salida()
	{
		is_logged_in_or_exit($this);
		$fecha_ini = $this->input->post('fecha_ini');
		$fecha_fin = $this->input->post('fecha_fin');
		$list = $this->reporte_model->mmovimiento_diario_salida($fecha_ini, $fecha_fin);
		$list_totales = $this->reporte_model->mmovimiento_diario_totales_salida($fecha_ini, $fecha_fin);
		$data = array('hecho' => 'SI', 'data' => $list, 'data_totales' => $list_totales);
		echo json_encode($data);
	}
}
