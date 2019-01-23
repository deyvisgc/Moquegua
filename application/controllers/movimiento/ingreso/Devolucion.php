<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('ingreso_model');
		$this->load->model('tipo_documento_model');
		$this->load->model('pcliente_model');
		$this->load->model('empresa_model');
		$this->load->model('unidad_medida_model');
		$this->load->model('producto_model');
		$this->load->model('ingreso_detalle_model');
		
		$this->load->helper('seguridad');
		
		$this->load->helper('url');
		
	}
	public function index()
	{
		esta_conectado($this);
		
		$row = $this->ingreso_model->buscar_p_x_estado_creado();
		if($row) {
			$url_nueva = base_url().'ingreso/proveedor/formulario';
			echo "<script>alert('Existe documento pendiente, Se abrira.');</script>";
			
			redirect($url_nueva, 'refresh');
		}
		else {
			$this->load->view('header');
			$this->load->view('ingreso/proveedor/index');
			$this->load->view('footer');
		}
	}
	public function formulario()
	{
		esta_conectado($this);
		
		$result = $this->ingreso_model->buscar_p_x_estado_creado();
		if($result) {
			$ing_id_ingreso = $result->ing_id_ingreso;
		}
		else {
			$ing_id_ingreso = $this->ingreso_model->registrar_p(get_id_usuario($this));
			
		}
		
		$ingreso = $this->ingreso_model->buscar_p_x_id($ing_id_ingreso);
		$data['ingreso'] = $ingreso;
		
		$list_tipo_documento = $this->tipo_documento_model->buscar_ingreso_x_tabla();
		$data['list_tipo_documento'] = $list_tipo_documento;
		
		$list_pcliente = $this->pcliente_model->buscar_proveedores();
		$data['list_pcliente'] = $list_pcliente;
		
		$list_unidad_medida = $this->unidad_medida_model->buscar_all();
		$data['list_unidad_medida'] = $list_unidad_medida;
		
		$list_producto = $this->producto_model->buscar_all();
		$data['list_producto'] = $list_producto;
		
		$list_ingreso_detalle = $this->ingreso_detalle_model->buscar_x_idingreso($ing_id_ingreso);
		$data['list_ingreso_detalle'] = $list_ingreso_detalle;
		
		$this->load->view('header');
		$this->load->view('ingreso/proveedor/formulario', $data);
		$this->load->view('footer');
	}
	public function ingreso_guardar_cambios()
	{
		esta_conectado($this);
		$ing_id_ingreso = $this->input->post('ing_id_ingreso');
		$data = array('ing_fecha_doc_proveedor' => $this->input->post('ing_fecha_doc_proveedor'),
				'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
				'ing_numero_doc_proveedor' => $this->input->post('ing_numero_doc_proveedor'),
				'pcl_id_proveedor' => $this->input->post('pcl_id_proveedor'),
				'ing_valor' => $this->input->post('ing_valor'));
		$result = $this->ingreso_model->guardar_cambios_p($ing_id_ingreso, $data);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	public function proveedor_registrar()
	{
		esta_conectado($this);
		$ing_id_ingreso = $this->input->post('ing_id_ingreso');
		$data = array('emp_ruc' => $this->input->post('emp_ruc'),
				'emp_razon_social' => $this->input->post('emp_razon_social'),
				'emp_direccion' => $this->input->post('emp_direccion'),
				'emp_telefono' => $this->input->post('emp_telefono'),
				'emp_nombre_contacto' => $this->input->post('emp_nombre_contacto'));
		$emp_id_empresa = $this->empresa_model->registrar($data);
		
		$data_pcliente = array('emp_id_empresa' => $emp_id_empresa,
				'pcl_tipo ' => 2);
		$pcl_id_cliente = $this->pcliente_model->registrar_proveedor($data_pcliente);
		
		$data_ingreso = array('pcl_id_proveedor' => $pcl_id_cliente);
		$result = $this->ingreso_model->guardar_proveedor_p($ing_id_ingreso, $data_ingreso);
		
		$data = array('hecho' => 'SI', 'pcl_id_cliente' => $pcl_id_cliente);
		echo json_encode($data);
	}
	public function terminar()
	{
		esta_conectado($this);
		
		$ing_id_ingreso = $this->input->post('ing_id_ingreso');
		$data = array('est_id_estado' => 2);
		$result = $this->ingreso_model->update_datos($ing_id_ingreso, $data);
		
		$result = $this->ingreso_model->terminar_p($ing_id_ingreso);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	
}
