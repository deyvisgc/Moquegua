<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bienvenida extends CI_Controller {
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
		$data_header['pri_grupo'] = 'xxxx';
		$data_header['pri_nombre'] = 'xxxx';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "BIENVENIDA";
		$data_body['fecha_actual'] = get_fecha_actual();
		$data_footer['inits_function'] = array("init_bienvenida");
		$this->load->view('header', $data_header);
		$this->load->view('bienvenida', $data_body);
		$this->load->view('footer', $data_footer);
	}
	public function reload_bienvenida() {
		is_logged_in_or_exit($this);
		$list = $this->reporte_model->mestadisticos();
		$data = array('hecho' => 'SI', 'data' => $list);
		echo json_encode($data);
	}
	public function mostrar_perfil() {
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$objeto = $this->reporte_model->mmostrar_perfil($usuario['usu_id_usuario']);
		if($objeto) {
			$data = array('hecho' => 'SI', 'data' => $objeto);
		}
		else {
			$data = array('hecho' => 'NO');
		}
		echo json_encode($data);
	}
}
