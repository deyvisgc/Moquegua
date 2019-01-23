<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('salida_model');
		$this->load->model('tipo_documento_model');
		$this->load->model('pcliente_model');
		$this->load->model('unidad_medida_model');
		$this->load->model('producto_model');
		$this->load->model('salida_detalle_model');
		$this->load->model('empresa_model');
		/* 
		
		
		
		
		 */
		
		$this->load->helper('seguridad');
		
		$this->load->helper('url');
		
	}
	public function index()
	{
		esta_conectado($this);
		
		$row = $this->salida_model->buscar_c_x_estado_creado();
		if($row) {
			$url_nueva = base_url().'salida/cliente/formulario';
			echo "<script>alert('Existe documento pendiente, Se abrira.');</script>";
			
			redirect($url_nueva, 'refresh');
		}
		else {
			$this->load->view('header');
			$this->load->view('salida/cliente/index');
			$this->load->view('footer');
		}
	}
	public function formulario()
	{
		esta_conectado($this);
		
		$result = $this->salida_model->buscar_c_x_estado_creado();
		if($result) {
			$sal_id_salida = $result->sal_id_salida;
		}
		else {
			$sal_id_salida = $this->salida_model->registrar_c(get_id_usuario($this));
			
		}
		
		$salida = $this->salida_model->buscar_c_x_id($sal_id_salida);
		$data['salida'] = $salida;
		
		$list_tipo_documento = $this->tipo_documento_model->buscar_ingreso_x_tabla();
		$data['list_tipo_documento'] = $list_tipo_documento;
		
		$list_pcliente = $this->pcliente_model->buscar_clientes();
		$data['list_pcliente'] = $list_pcliente;
		
		$list_unidad_medida = $this->unidad_medida_model->buscar_all();
		$data['list_unidad_medida'] = $list_unidad_medida;
		
		$list_producto = $this->producto_model->buscar_all();
		$data['list_producto'] = $list_producto;
		
		$list_salida_detalle = $this->salida_detalle_model->buscar_x_idsalida($sal_id_salida);
		$data['list_salida_detalle'] = $list_salida_detalle;
		
		$this->load->view('header');
		$this->load->view('salida/cliente/formulario', $data);
		$this->load->view('footer');
		
	}
	public function guardar_cambios()
	{
		esta_conectado($this);
		
		$sal_id_salida = $this->input->post('sal_id_salida');
		
		$data = array(
				'pcl_id_cliente' => $this->input->post('pcl_id_cliente'),
				'sal_fecha_doc_cliente' => $this->input->post('sal_fecha_doc_cliente'),
				'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
				'sal_numero_doc_cliente' => $this->input->post('sal_numero_doc_cliente'),
				'sal_descuento' => $this->input->post('sal_descuento'),
				'sal_motivo' => $this->input->post('sal_motivo'));
		$result = $this->salida_model->update_datos($sal_id_salida, $data);
		$result = $this->salida_model->update_valor($sal_id_salida);
		// $sal_id_salida = $this->salida_model->registrar_c(get_id_usuario($this));
		
		// $result = $this->salida_model->buscar_c_x_estado_creado();
		// $sal_id_salida = $result->sal_id_salida;
		
		$salida = $this->salida_model->buscar_c_x_id($sal_id_salida);
		
		$data = array('hecho' => 'SI', 'sal_valor' => $salida->sal_valor);
		echo json_encode($data);
	}
	public function cliente_registrar()
	{
		esta_conectado($this);
		
		$sal_id_salida = $this->input->post('sal_id_salida');
		$data = array('emp_ruc' => $this->input->post('emp_ruc'),
				'emp_razon_social' => $this->input->post('emp_razon_social'),
				'emp_direccion' => $this->input->post('emp_direccion'),
				'emp_telefono' => $this->input->post('emp_telefono'),
				'emp_nombre_contacto' => $this->input->post('emp_nombre_contacto'));
		$emp_id_empresa = $this->empresa_model->registrar($data);
		
		$data_pcliente = array('emp_id_empresa' => $emp_id_empresa,
				'pcl_tipo ' => 1);
		$pcl_id_pcliente = $this->pcliente_model->registrar($data_pcliente);
		
		$data_salida = array('pcl_id_cliente' => $pcl_id_pcliente);
		$result = $this->salida_model->update_datos($sal_id_salida, $data_salida);
		
		$data = array('hecho' => 'SI', 'pcl_id_pcliente' => $pcl_id_pcliente);
		echo json_encode($data);
	}
	public function terminar()
	{
		esta_conectado($this);
		
		$sal_id_salida = $this->input->post('sal_id_salida');
		
		$data = array('est_id_estado' => 2);
		$result = $this->salida_model->update_datos($sal_id_salida, $data);
		
		$result = $this->salida_model->terminar_c($sal_id_salida);
		
		$data = array('hecho' => 'SI');
		echo json_encode($data);
	}
	
}
