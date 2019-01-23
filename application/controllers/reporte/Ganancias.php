<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ganancias extends CI_Controller
{
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
		$data_header['pri_nombre'] = 'Ganancias';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "REPORTE Ganancias";
		$data_footer['inits_function'] = array("init_ganancias");
		$this->load->view('header', $data_header);
		$this->load->view('reporte/ganancias/index');
		$this->load->view('footer', $data_footer);
	}
	public function rporte_ganancias(){
		is_logged_in_or_exit($this);
		$fecha_ini = $this->input->post('fecha_ini');
		$fecha_fin = $this->input->post('fecha_fin');
		$lis = $this->reporte_model->rporte_model_ganancias($fecha_ini, $fecha_fin);
		$sumgan=$this->reporte_model->sumganancias($fecha_ini, $fecha_fin);
		$data = array('hecho' => 'SI', 'data' => $lis,'data_totales' => $sumgan);
		echo json_encode($data);
	}

}
