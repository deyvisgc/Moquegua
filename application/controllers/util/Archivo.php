<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archivo extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('rol_has_privilegio_model');
		
		$this->load->helper(array('form'));
		$this->lang->load("upload", "espanol");
		
		$this->load->helper('seguridad');
		$this->load->helper('util');
		$this->load->helper('url');
	}
	public function index() {
		is_logged_in_or_exit($this);
	}
	public function subir_imagen() {
		is_logged_in_or_exit($this);
		$config['upload_path']          = './resources/sy_file_repository/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$config['file_name']           = generar_cadena_dinamica(20).".jpg";
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('archivo'))
		{
			$data['hecho'] = "NO";
			$data['error'] =  $this->upload->display_errors();
			echo json_encode($data);
		}
		else
		{
			$upload_data = $this->upload->data();
			$data['hecho'] = "SI";
			foreach ($upload_data as $item => $value){
				$data[$item] = $value;
			}
			echo json_encode($data);
		}
	}
}
