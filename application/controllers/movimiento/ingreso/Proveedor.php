<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('ingreso_model');
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
		$data_header['pri_nombre'] = 'Compra';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "COMPRA";
		
		$data_footer['inits_function'] = array("init_ingreso");
		
		$this->load->view('header', $data_header);
		$this->load->view('movimiento/ingreso/proveedor/index');
		$this->load->view('footer', $data_footer);
		
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$usuario = get_usuario($this);
		$data = array(
			'usu_id_usuario' => $usuario['usu_id_usuario'],
			'pcl_id_proveedor' => $this->input->post('pcl_id_proveedor'),
			'ing_fecha_doc_proveedor' => $this->input->post('ing_fecha_doc_proveedor'),
			'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
			'ing_numero_doc_proveedor' => $this->input->post('ing_numero_doc_proveedor'),
			'ing_monto_efectivo' => $this->input->post('ing_monto_efectivo'),
			'ing_monto_tar_credito' => $this->input->post('ing_monto_tar_credito'),
			'ing_monto_tar_debito' => $this->input->post('ing_monto_tar_debito'),
            'in_tipo' => $this->input->post('in_tipo')
			);
		$result = $this->ingreso_model->mregistrar($data);
		
		echo json_encode($result);
	}
}
