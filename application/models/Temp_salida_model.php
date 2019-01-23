<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temp_salida_model extends CI_Model {
	function magregar($data) {
		$result = $this->db->query("call proc_temp_salida_agregar(@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			".$data['pro_id_producto'].", 
			".$data['cantidad'].", 
			".$data['precio'].",
			".$data['n_orden'].",
			".$data['totalganancia'].")");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		return $result->row();
	}
	function mquitar($data) {
		$result = $this->db->query("call proc_temp_salida_quitar(@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			".$data['pro_id_producto'].",
			".$data['n_orden']."
			
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		return $result->row();
	}
	
	function mbuscar_productos_elejidos($usu_id_usuario) {
		$list = array();
		$query = $this->db->query("
			SELECT 
			  pro.pro_id_producto, 
			  pro.pro_codigo codigo, 
			  pro.pro_nombre descripcion, 
			  unm.unm_nombre_corto uni_med, 
			 
			  t.temp_cantidad cantidad, 
			  t.temp_valor precio, 
			
			  t.pro_ganancias ganancias, 
			    t.tem_orden n_orden, 
			  (t.temp_cantidad*t.temp_valor) total 
			FROM temp t 
			  INNER JOIN producto pro 
			  ON pro.pro_id_producto=t.pro_id_producto 
			  INNER JOIN unidad_medida unm 
			  ON unm.unm_id_unidad_medida=pro.unm_id_unidad_medida 
			WHERE 
			  usu_id_usuario=$usu_id_usuario AND 
			  temp_tipo_movimiento='SALIDA' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function msum_count_productos_elejidos($usu_id_usuario) {
		$query = $this->db->query("
			SELECT 
			  ifnull(count(usu_id_usuario),0) count_productos, 
			  FORMAT(round(ifnull(SUM(temp_cantidad*temp_valor),0),1),2) sum_total 
			FROM temp t 
			WHERE 
			  usu_id_usuario=$usu_id_usuario AND 
			  temp_tipo_movimiento='SALIDA'");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('count_productos'=>'0', 'sum_total'=>'0.00');
	}
	
	function mbuscar_s_productos_x_descripcion($usu_id_usuario, $descripcion) {
		$list = array();
		$query = $this->db->query("select 
			  pro.pro_id_producto, 
			  pro.pro_nombre, 
			  unm.unm_id_unidad_medida, 
			  unm.unm_nombre_corto, 
			  pro.pro_val_venta,
			  pro_val_compra, 
			  pro.pro_cantidad, 
			  pro.pro_foto, 
			  pro.pro_xm_cantidad1, 
			  pro.pro_xm_valor1, 
			  pro.pro_xm_cantidad2, 
			  pro.pro_xm_valor2, 
			  pro.pro_xm_cantidad3, 
			  pro.pro_xm_valor3, 
			  pro.pro_val_oferta 
			from producto pro 
			  inner join unidad_medida unm 
			  on unm.unm_id_unidad_medida=pro.unm_id_unidad_medida 
			  and pro.pro_eliminado='NO' 
			  and unm.unm_eliminado='NO' 
			  and pro.est_id_estado=11 
			  and unm.est_id_estado=11 
			where 
			  pro.pro_nombre like '%".$descripcion."%' and 
			  pro.pro_cantidad > 1 and 
			  pro.pro_cantidad > (SELECT IFNULL(SUM(temp_cantidad),0) FROM temp t WHERE t.temp_tipo_movimiento='SALIDA' AND t.pro_id_producto=pro.pro_id_producto)
			order by pro.pro_nombre ");
		foreach ($query->result() as $row)
		{
			$row->value = $row->pro_nombre;
			$list[] = $row;
		}
		return $list;
	}
	
	function mdocumento_salida() {
		$list = array();
		$query = $this->db->query("SELECT tdo_id_tipo_documento, 
			  tdo_nombre, 
			  tdo_tamanho, 
			  tdo_orden, 
			  tdo_valor1 
			FROM tipo_documento 
			WHERE tdo_tabla='SALIDA' 
			ORDER BY tdo_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mgetsal_nro_documento($tdo_id_tipo_documento) {
		$query = $this->db->query("SELECT 
			  CONCAT(REPEAT('0',(tdo_tamanho-LENGTH(numero))),numero) numero, 
			  tdo_valor1 
			FROM 
			  (SELECT tdo.tdo_tamanho, tdo.tdo_valor1 
				FROM tipo_documento tdo 
				WHERE tdo.tdo_id_tipo_documento=$tdo_id_tipo_documento ) t1 
			  ,
			  (SELECT IFNULL(MAX(CAST(sal.sal_numero_doc_cliente AS UNSIGNED)),0)+1 numero 
				FROM salida sal 
				WHERE sal.tdo_id_tipo_documento=$tdo_id_tipo_documento ) t2 ");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('numero' => '', 'tdo_valor1' => '0.00');
	}
	function mbuscar_cliente($texto) {
		$list = array();
		$query = $this->db->query("SELECT 
			  pc.pcl_id_pcliente, 
			  e.emp_ruc, 
			  e.emp_razon_social, 
			  e.emp_direccion, 
			  e.emp_nombre_contacto 
			FROM pcliente pc 
			INNER JOIN empresa e 
			ON pc.emp_id_empresa=e.emp_id_empresa 
			where (pc.pcl_tipo='1' or pc.pcl_tipo='3') and 
			  (e.emp_razon_social like '%".$texto."%' or 
			  e.emp_ruc like '%".$texto."%') 
			  and pc.pcl_eliminado='NO' ");
		foreach ($query->result() as $row)
		{
			$row->value = $row->emp_razon_social;
			$list[] = $row;
		}
		return $list;
	}
	 function mbuscar_clientes() {
        $list = array();
        $query = $this->db->query("SELECT 
			  pc.pcl_id_pcliente, 
			  e.emp_ruc, 
			  e.emp_razon_social, 
			  e.emp_direccion, 
			  e.emp_nombre_contacto 
			FROM pcliente pc 
			INNER JOIN empresa e 
			ON pc.emp_id_empresa=e.emp_id_empresa 
			where (pc.pcl_tipo='1' or pc.pcl_tipo='3') and 
			  (e.emp_razon_social ='ANONIMO') 
			  and pc.pcl_eliminado='NO' ");
        foreach ($query->result() as $row)
        {
            $row->value = $row->emp_razon_social;
            $list[] = $row;
        }
        return $list;
    }
}
?>