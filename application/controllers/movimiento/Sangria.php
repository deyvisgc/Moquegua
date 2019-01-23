<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sangria extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->load->database();
        $this->load->model('salida_model');
        $this->load->model('datos_empresa_local_model');
        $this->load->model('rol_has_privilegio_model');
        $this->load->model('Sangria_model');
        $this->load->model('reporte_model');

        $this->load->helper('seguridad');
        $this->load->helper('util');
        $this->load->helper('url');
    }

    public function index(){
        is_logged_in_or_exit($this);
        $data_header['list_privilegio'] = get_privilegios($this);
        $data_header['pri_grupo'] = 'MOVIMIENTO';
        $data_header['pri_nombre'] = 'Sangria';
        $data_header['usuario'] = get_usuario($this);
        $data_header['title'] = "Sangria";

        $data_footer['inits_function'] = array("init_ingreso");

        $this->load->view('header', $data_header);
        $this->load->view('movimiento/sangria');
        $this->load->view('footer',$data_footer);
    }

    public function agregarSangria(){
        is_logged_in_or_exit($this);
        $usuario = get_usuario($this);

        $data = array(
            'usu_id_usuario' => $usuario['usu_id_usuario'],
            'monto' => $this->input->post('monto_form'),
            'tipo_sangria' => $this->input->post('tsangria_form'),
            'san_motivo' => $this->input->post('s_motivo')
        );

        $result = $this->Sangria_model->registrarSangria($data);

        echo json_encode($result);
    }

    public function listarCajas()
    {
        is_logged_in_or_exit($this);

        $texto = $this->input->post('texto');

        $list_ventas = $this->reporte_model->listar_cajas($texto);
        $data = array('hecho' => 'SI', 'list_ventas' => $list_ventas);

        echo json_encode($data);
    }

    public function cargar_cajas_combobox(){
        $data=$this->Sangria_model->listar_cajas_combobox();
        echo json_encode($data);
    }

    public function sangriaCajas($caja){
        is_logged_in_or_exit($this);
        $result = array('data'=>array());
        $data= $this->Sangria_model->sangria_x_caja($caja);

        foreach($data as $key => $value){
            $caja = $value['caj_descripcion'];
            $monto =$value['monto'];
            $fecha =$value['fecha'];
            $tipo_sangria =$value['tipo_sangria'];
            $usuario =$value['usu_nombre'];
            $result['data'][$key] = array(
                $caja,$monto,$fecha,$tipo_sangria,$usuario
            );
        }
        echo json_encode($result);

    }

    public function sangrias_cajas_x_fecha(){
        is_logged_in_or_exit($this);

        $fecha_ini = $this->input->post('f_inicio');
        $fecha_fin = $this->input->post('f_fin');
        $caja = $this->input->post('caja');

        $list= $this->Sangria_model->listar_sagria_x_fecha_caja($fecha_ini, $fecha_fin,$caja);
        $data = array('hecho' => 'SI', 'data' => $list);

        echo json_encode($data);
    }

    public function sangrias_cajas_x_fecha_venta(){
        is_logged_in_or_exit($this);

        $fecha_ini = $this->input->post('f_inicio2');
        $fecha_fin = $this->input->post('f_fin2');
        $caja = $this->input->post('caja2');

        $list= $this->Sangria_model->mmovimiento_diario_salida($fecha_ini, $fecha_fin,$caja);
        $list_totales = $this->Sangria_model->mmovimiento_diario_totales_salida($fecha_ini, $fecha_fin,$caja);
        $tsangria_ingreso = $this->Sangria_model->sumar_total_ingreso_sangria_x_fecha_caja($fecha_ini,$fecha_fin,$caja);
        $tsangria_salida = $this->Sangria_model->sumar_total_salida_sangria_x_fecha_caja($fecha_ini,$fecha_fin,$caja);
        $data = array('hecho' => 'SI', 'data' => $list,'total_venta'=>$list_totales,'tsingreso'=>$tsangria_ingreso,'tssalida'=>$tsangria_salida);

        echo json_encode($data);
    }
}