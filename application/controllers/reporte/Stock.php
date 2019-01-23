<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
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
		$data_header['pri_nombre'] = 'Stock';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "REPORTE STOCK";
		$data_footer['inits_function'] = array("init_stock");
		$this->load->view('header', $data_header);
		$this->load->view('reporte/stock/index');
		$this->load->view('footer', $data_footer);
	}
	public function bstock_general()
	{
		is_logged_in_or_exit($this);
		$lista = $this->reporte_model->mstock_general();
		$data = array('hecho' => 'SI', 'data' => $lista);
		echo json_encode($data);
	}
	public function bstock_minimo()
	{
		is_logged_in_or_exit($this);
		$lista = $this->reporte_model->mstock_minimo();
		$data = array('hecho' => 'SI', 'data' => $lista);
		echo json_encode($data);
	}
}
