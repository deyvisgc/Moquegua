<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sangria_model extends CI_Model {

   function registrarSangria($data) {
        $result = $this->db->query("call MANAGE_SANGRIA(
			".$data['usu_id_usuario'].",
			".$data['monto'].",
			'".$data['tipo_sangria']."',
			'".$data['san_motivo']."'
			)");
        return $result;
    }
    function sangria_x_caja($caja){
        $query="SELECT c.caj_descripcion,s.monto,s.fecha,s.tipo_sangria,u.usu_nombre 
        FROM sangria AS s, caja as c,usuario as u
        WHERE s.caj_id_caja=c.caj_id_caja AND s.usu_id_usuario=u.usu_id_usuario AND c.caj_descripcion 
        LIKE '%".$caja."%' ";
        $data=$this->db->query($query);
        return $data->result_array();
    }

    function listar_sagria_x_fecha_caja($fecha_ini,$fecha_fin,$caja){
        $list=array();
        $query=$this->db->query("SELECT c.caj_descripcion,s.monto,s.fecha,s.tipo_sangria,u.usu_nombre 
        FROM sangria AS s, caja as c,usuario as u
        WHERE s.caj_id_caja=c.caj_id_caja AND s.usu_id_usuario=u.usu_id_usuario AND c.caj_descripcion='$caja'
        AND STR_TO_DATE(s.fecha, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d')
        AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') ORDER BY s.fecha DESC");

        foreach ($query->result() as $row)
        {
            $list[] = $row;
        }
        return $list;
    }

    function sumar_total_ingreso_sangria_x_fecha($fecha_ini,$fecha_fin){
        $query=$this->db->query("
        SELECT ifnull(round(SUM(monto),2),0) as monto_ingreso FROM sangria AS s 
        WHERE s.tipo_sangria='ingreso' 
        AND STR_TO_DATE(s.fecha, '%Y-%m-%d') 
        BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d')
        AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d');
        ");
        foreach ($query->result() as $row){
            return $row;
        }
        return array('monto_ingreso'=>'0.00');
    }

    function sumar_total_ingreso_sangria_x_fecha_caja($fecha_ini,$fecha_fin,$caja){
        $query=$this->db->query("
        SELECT ifnull(round(SUM(monto),2),0) as monto_ingreso FROM sangria AS s, caja as c 
        WHERE c.caj_id_caja=s.caj_id_caja AND c.caj_descripcion='$caja' AND s.tipo_sangria='ingreso' 
        AND  STR_TO_DATE(s.fecha, '%Y-%m-%d') 
        BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d')
        AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d');
        ");
        foreach ($query->result() as $row){
            return $row;
        }
        return array('monto_ingreso'=>'0.00');
    }

    function sumar_total_salida_sangria_x_fecha($fecha_ini,$fecha_fin){
        $query=$this->db->query("
        SELECT ifnull(round(SUM(monto),2),0) as monto_retiro 
        FROM sangria AS s 
        WHERE s.tipo_sangria='retiro' 
        AND STR_TO_DATE(s.fecha, '%Y-%m-%d') 
        BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d')
        AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d');
        ");
        foreach ($query->result() as $row){
            return $row;
        }
        return array('monto_retiro'=>'0.00');
    }
    function sumar_total_salida_sangria_x_fecha_caja($fecha_ini,$fecha_fin,$caja){
        $query=$this->db->query("
        SELECT ifnull(round(SUM(monto),2),0) as monto_retiro 
        FROM sangria AS s,caja AS c
        WHERE c.caj_id_caja=s.caj_id_caja AND c.caj_descripcion='$caja' AND s.tipo_sangria='retiro'
        AND STR_TO_DATE(s.fecha, '%Y-%m-%d') 
        BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d')
        AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d');
        ");
        foreach ($query->result() as $row){
            return $row;
        }
        return array('monto_retiro'=>'0.00');
    }

    function mmovimiento_diario_salida($fecha_ini, $fecha_fin,$caja) {
        $list = array();
        $query = $this->db->query("SELECT 
			  sal_fecha_doc_cliente, 
			  sal_fecha_registro, 
			  tdo_id_tipo_documento,
			  c.caj_descripcion, 
			  IFNULL((SELECT tdo.tdo_nombre FROM tipo_documento tdo WHERE tdo.tdo_id_tipo_documento=sal.tdo_id_tipo_documento),'') tdo_nombre, 
			  sal_numero_doc_cliente, 
			  (SELECT emp.emp_razon_social FROM pcliente pcl INNER JOIN empresa emp ON pcl.emp_id_empresa=emp.emp_id_empresa WHERE pcl.pcl_id_pcliente=sal.pcl_id_cliente) emp_razon_social, 
			  FORMAT(sal_monto, 2, 'de_DE') sal_monto 
			FROM salida sal, caja as c 
			WHERE sal.caj_id_caja=c.caj_id_caja AND c.caj_descripcion='$caja' AND STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			ORDER BY sal_fecha_registro DESC ");
        foreach ($query->result() as $row)
        {
            $list[] = $row;
        }
        return $list;
    }

    function mmovimiento_diario_totales_salida($fecha_ini, $fecha_fin,$caja) {
        $query = $this->db->query("SELECT 
			  IFNULL(sal_monto,0) sal_monto 
			FROM (SELECT
			  (SELECT 
			      SUM(sal_monto) 
			    FROM salida sal,caja as c 
			    WHERE c.caj_id_caja=sal.caj_id_caja AND c.caj_descripcion='$caja' AND STR_TO_DATE(sal_fecha_doc_cliente, '%Y-%m-%d') 
			    BETWEEN STR_TO_DATE('$fecha_ini', '%Y-%m-%d') 
			    AND STR_TO_DATE('$fecha_fin', '%Y-%m-%d') 
			  ) sal_monto 
			) tabla ");
        foreach ($query->result() as $row)
        {
            return $row;
        }
        return array('ing_valor' => '00.00',
            'sal_valor' => '00.00',
            'total' => '00.00');
    }
    
    function listar_cajas_combobox(){
        $query="select c.caj_descripcion from caja as c";
        $data = $this->db->query($query);
        return $data->result_array();
    }


}