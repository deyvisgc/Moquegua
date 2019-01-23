<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();
		$this->load->model('salida_model');
		$this->load->model('salida_detalle_model');
		$this->load->model('datos_empresa_local_model');
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
		$data_header['pri_nombre'] = 'Venta';
		$data_header['usuario'] = get_usuario($this);
		$data_header['title'] = "VENTA";
		
		$data_body['datos_empresa_local'] = $this->datos_empresa_local_model->buscar_id_unico();
		
		$data_footer['inits_function'] = array("init_salida");
		
		$this->load->view('header', $data_header);
		$this->load->view('movimiento/salida/cliente/index', $data_body);
		$this->load->view('footer', $data_footer);
		
	}
	public function registrar()
	{
		is_logged_in_or_exit($this);
		
		$usuario = get_usuario($this);
		$data = array(
			'usu_id_usuario' => $usuario['usu_id_usuario'],
			'pcl_id_cliente' => $this->input->post('pcl_id_cliente'),
			'sal_fecha_doc_cliente' => $this->input->post('sal_fecha_doc_cliente'),
			'tdo_id_tipo_documento' => $this->input->post('tdo_id_tipo_documento'),
			'sal_monto_efectivo' => $this->input->post('sal_monto_efectivo'),
			'sal_monto_tar_credito' => $this->input->post('sal_monto_tar_credito'),
			'sal_monto_tar_debito' => $this->input->post('sal_monto_tar_debito'),
			'sal_descuento' => $this->input->post('sal_descuento'),
			'sal_motivo' => $this->input->post('sal_motivo'),
			'sal_vuelto'=>$this->input->post('sal_vuelto'),
		    't_venta' => $this->input->post('t_venta'));
		$result = $this->salida_model->mregistrar($data);

		echo json_encode($result);
	}
	public function mostrar_documento()
	{
		is_logged_in_or_exit($this);
		$sal_id_salida = $this->input->post('sal_id_salida');
		$salida = $this->salida_model->mbuscar_one($sal_id_salida);
		$list_salida_detalle = $this->salida_detalle_model->mbuscar_detalles($sal_id_salida);
		
		$data['salida'] = $salida;
		$data['list_salida_detalle'] = $list_salida_detalle;
		
		$this->load->view('movimiento/salida/documento/index', $data);
	}
	
	public function cliente_registrar()	// DUDA
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
	public function cargarAnonimo(){
        is_logged_in_or_exit($this);
        $usuario = get_usuario($this);
        $result = $this->temp_salida_model->mbuscar_clientes();
        echo json_encode($result);
    }
}
