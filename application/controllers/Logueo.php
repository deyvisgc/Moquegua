<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logueo extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('usuario_model');
		
		$this->load->helper('seguridad');
		$this->load->helper('url');
	}
	public function index()
	{
		if(is_logged_in($this)) {
			$url_nueva = base_url().'bienvenida';
			redirect($url_nueva, 'refresh');
		}
		else {
			$this->load->view('logueo/index');
		}
	}
	public function acceder()
	{
		$usu_nombre = $this->input->post('usu_nombre');
		$usu_clave = $this->input->post('usu_clave');
		$row = $this->usuario_model->mvalidar_acceso($usu_nombre, $usu_clave);
		if($row) {
			$this->session->set_userdata('usu_id_usuario', $row->usu_id_usuario);
			$this->session->set_userdata('usu_nombre', $row->usu_nombre);
			$this->session->set_userdata('per_nombre', $row->per_nombre);
			$this->session->set_userdata('per_apellido', $row->per_apellido);
			$this->session->set_userdata('rol_id_rol', $row->rol_id_rol);
			$this->session->set_userdata('per_foto', $row->per_foto);
			$url_nueva = base_url().'bienvenida';
			redirect($url_nueva, 'refresh');
		}
		else {
			$url_nueva = base_url().'logueo/index';
			echo "<script>alert('No pudo iniciar sesion.');</script>";
			redirect($url_nueva, 'refresh');
		}
	}
	public function salir()
	{
		$this->session->sess_destroy();
		$url_nueva = base_url().'logueo/index';
		redirect($url_nueva, 'refresh');
	}
}
