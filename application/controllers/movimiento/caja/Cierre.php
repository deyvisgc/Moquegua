<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cierre extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('caja_model');
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'MOVIMIENTO';
		$data_header['pri_nombre'] = 'Cierre Caja';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "CIERRE CAJA";
		$data_footer['inits_function'] = array("init_cierre");
		$this->load->view('header', $data_header);
		$this->load->view('movimiento/caja/cierre/index');
		$this->load->view('footer', $data_footer);
	}
	public function reload()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$result = $this->caja_model->mbuscar_caja_x_usuario($usuario['usu_id_usuario']);
		if($result) {
			$data = array('hecho' => 'SI', 'caja' => $result);
			echo json_encode($data);
		}
		else {
			$data = array('hecho' => 'NO');
			echo json_encode($data);
		}
	}
	public function cerrar()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data_caja = array(
			'caj_id_caja' => $this->input->post('caj_id_caja'),
			'usu_id_usuario' => $usuario['usu_id_usuario'] );
		$result = $this->caja_model->mcerrar($data_caja);
		echo json_encode($result);
	}
}
