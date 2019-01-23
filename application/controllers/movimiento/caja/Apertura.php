<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apertura extends CI_Controller {
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
		$data_header['pri_nombre'] = 'Apertura Caja';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "APERTURA CAJA";
		$data_footer['inits_function'] = array("init_apertura");
		$this->load->view('header', $data_header);
		$this->load->view('movimiento/caja/apertura/index');
		$this->load->view('footer', $data_footer);
	}
	public function reload()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$result = $this->caja_model->mbuscar_caja_x_usuario($usuario['usu_id_usuario']);
		if($result) {
			$data = array('hecho' => 'NO', 'caja' => $result);
			echo json_encode($data);
		}
		else {
			$list_caja = $this->caja_model->mbuscar_caja_libre();
			$data = array('hecho' => 'SI', 'list_caja' => $list_caja);
			echo json_encode($data);
		}
	}
	public function aperturar()
	{
		is_logged_in_or_exit($this);
		$usuario = get_usuario($this);
		$data_caja = array(
			'caj_id_caja' => $this->input->post('caj_id_caja'),
			'usu_id_usuario' => $usuario['usu_id_usuario'] );
		$result = $this->caja_model->maperturar($data_caja);
		echo json_encode($result);
	}
}
