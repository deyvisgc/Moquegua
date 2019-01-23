<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('session');

        $this->load->database();
        $this->load->model('reporte_model');
        $this->load->model('rol_has_privilegio_model');

        $this->load->helper('seguridad');
        $this->load->helper('util');
        $this->load->helper('url');
    }

    public function index()
    {
        is_logged_in_or_exit($this);
        $data_header['list_privilegio'] = get_privilegios($this);
        $data_header['pri_grupo'] = 'REPORTE';
        $data_header['pri_nombre'] = 'Ventas del dia';
        $data_header['usuario'] = get_usuario($this);
        $data_header['title'] = "Reporte de Ventas del día";

        $data_footer['inits_function'] = array("init_salida");

        $this->load->view('header',$data_header);
        $this->load->view('reporte/ventas/index');
        $this->load->view('footer',$data_footer);
    }

    public function listarCajas(){
        is_logged_in_or_exit($this);

        $texto = $this->input->post('texto');

        $list_ventas= $this->reporte_model->listar_cajas($texto);
        $data = array('hecho'=>'SI', 'list_ventas'=>$list_ventas);

        echo json_encode($data);
    }

    public function listarProductosVendidos($caja){
        is_logged_in_or_exit($this);
        $result = array('data'=>array());
        $data= $this->reporte_model->listar_ventas_del_dia_por_caja($caja);
        foreach($data as $key => $value){
            $caja = $value['caj_descripcion'];
            $producto =$value['pro_nombre'];
            $valor =$value['sad_valor'];
            $cantidad =$value['cantidad_vendida'];
            $venta =$value['venta_total'];
            $result['data'][$key] = array(
                $caja,$producto,$valor,$cantidad,$venta
            );
        }
        echo json_encode($result);

    }




}