<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_cambio_clave extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('usuario_model');
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index()
	{
		is_logged_in_or_exit($this);
		$data_header['list_privilegio'] = get_privilegios($this);
		$data_header['pri_grupo'] = 'ADMINISTRACION';
		$data_header['pri_nombre'] = 'Cambiar clave';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "USUARIO CAMBIAR CLAVE";
		
		$data_footer['inits_function'] = array("init_usuario");
		
		$this->load->view('header', $data_header);
		$this->load->view('administracion/usuario_cambio_clave/index');
		$this->load->view('footer', $data_footer);
	}
	public function cambiar_clave()
	{
		is_logged_in_or_exit($this);
		
		$usuario = get_usuario($this);
		$usu_clave = $this->input->post('usu_clave');
		$row = $this->usuario_model->mvalidar_acceso($usuario['usu_nombre'], $usu_clave);
		if($row) {
			$opt = array("cost" => 12);
			$usu_clave_ph = password_hash($this->input->post('usu_clave_nueva'), PASSWORD_BCRYPT, $opt);
			$data_usuario = array('usu_clave' => $usu_clave_ph);
			$result = $this->usuario_model->update_datos($usuario['usu_id_usuario'], $data_usuario);
			if($result) {
				$data = array('hecho' => 'SI');
			}
			else {
				$data = array('hecho' => 'NO', 'msj' => ' Error en nueva clave.');
			}
		}
		else {
			$data = array('hecho' => 'NO', 'msj' => ' Error clave.');
		}
		
		echo json_encode($data);
	}
	
}
