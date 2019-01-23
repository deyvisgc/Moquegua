<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temp_ingreso_model extends CI_Model {
	function magregar($data) {
		$result = $this->db->query("call proc_temp_ingreso_agregar(@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			".$data['pro_id_producto'].", 
			".$data['valor'].", 
			".$data['cantidad'].", 
			'".$data['numero_lote']."', 
			'".$data['fecha_vencimiento']."' 
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		return $result->row();
	}
	function mquitar($data) {
		$result = $this->db->query("call proc_temp_ingreso_quitar(@out_hecho, 
			@out_estado, 
			".$data['usu_id_usuario'].", 
			".$data['pro_id_producto']." 
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
			  t.temp_numero_lote numero_lote, 
			  t.temp_fecha_vencimiento fecha_vencimiento, 
			  unm.unm_nombre_corto uni_med, 
			  t.temp_cantidad cantidad, 
			  t.temp_valor precio, 
			  (t.temp_cantidad*t.temp_valor) total 
			FROM temp t 
			  INNER JOIN producto pro 
			  ON pro.pro_id_producto=t.pro_id_producto 
			  INNER JOIN unidad_medida unm 
			  ON unm.unm_id_unidad_medida=pro.unm_id_unidad_medida 
			WHERE 
			  usu_id_usuario=$usu_id_usuario AND 
			  temp_tipo_movimiento='INGRESO' ");
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
			  ifnull(sum(temp_cantidad*temp_valor),0) sum_total 
			FROM temp t 
			WHERE 
			  usu_id_usuario=$usu_id_usuario AND 
			  temp_tipo_movimiento='INGRESO'");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return array('count_productos'=>'0', 'sum_total'=>'0.00');
	}
	
	function mbuscar_productos_x_descripcion($usu_id_usuario, $descripcion) {
		$list = array();
		$query = $this->db->query("select 
			  pro.pro_id_producto, 
			  pro.pro_nombre, 
			  unm.unm_id_unidad_medida, 
			  unm.unm_nombre_corto, 
			  pro.pro_val_compra, 
			  pro.pro_cantidad, 
			  pro.pro_foto, 
			  pro.pro_perecible 
			from producto pro 
			  inner join unidad_medida unm 
			  on unm.unm_id_unidad_medida=pro.unm_id_unidad_medida 
			  and pro.pro_eliminado='NO' 
			  and unm.unm_eliminado='NO' 
			  and pro.est_id_estado=11 
			  and unm.est_id_estado=11 
			where 
			  (pro.pro_codigo='".$descripcion."' or 
			    pro.pro_nombre like '%".$descripcion."%') and 
			  pro.pro_id_producto not in (SELECT t.pro_id_producto FROM temp t WHERE t.temp_tipo_movimiento='INGRESO' AND t.usu_id_usuario=".$usu_id_usuario.") 
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
			WHERE tdo_tabla='INGRESO' 
			ORDER BY tdo_orden");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function mgetsal_nro_documento($tdo_id_tipo_documento) { // REVISAR
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
	function mbuscar_proveedor($texto) {
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
			where (pc.pcl_tipo='2' or pc.pcl_tipo='3') and 
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
}
?>