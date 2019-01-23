<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {
	function mregistrar($data) {
		$this->db->insert('producto', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function mactualizar($pro_id_producto, $data) {
		$this->db->where('pro_id_producto', $pro_id_producto);
        return $this->db->update('producto', $data);
	}
	function mstock_ajustar($data) {
		$result = $this->db->query("call proc_stock_ajustar(@out_hecho, 
			@out_estado, 
			".$data['pro_id_producto'].", 
			".$data['cantidad'].", 
			'".$data['operador']."', 
			'".$data['usu_id_usuario']."' 
			)");
		$result = $this->db->query("SELECT @out_hecho as hecho, @out_estado as estado");
		return $result->row();
	}
	function buscar_all() {
		$list = array();
		$query = $this->db->query("select 
			  p.pro_id_producto, 
			  p.pro_codigo, 
			  IFNULL(cla_clase,'') cla_clase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_clase),'') clase_nombre, 
			  IFNULL(cla_subclase,'') cla_subclase, 
			  IFNULL((SELECT cc.cla_nombre FROM clase cc WHERE cc.cla_id_clase=p.cla_subclase),'') subclase_nombre, 
			  p.pro_nombre, 
			  p.pro_val_compra, 
			  p.pro_val_venta, 
			  p.pro_cantidad, 
			  p.pro_cantidad_min, 
			  p.est_id_estado, 
			  p.pro_foto, 
			  p.pro_perecible, 
			  p.pro_xm_cantidad1, 
			  p.pro_xm_valor1, 
			  p.pro_xm_cantidad2, 
			  p.pro_xm_valor2, 
			  p.pro_xm_cantidad3, 
			  p.pro_xm_valor3, 
			  p.pro_val_oferta, 
			  um.unm_id_unidad_medida, 
			  um.unm_nombre, 
			  um.unm_nombre_corto, 
			  e.est_nombre 
			from producto p 
			  inner join unidad_medida um 
			  on p.unm_id_unidad_medida=um.unm_id_unidad_medida 
			  inner join estado e 
			  on p.est_id_estado=e.est_id_estado 
			where p.pro_eliminado='NO' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	// ---
	function mbuscar_all_habilitados() {
		$list = array();
		$query = $this->db->query("select 
			  p.pro_id_producto, 
			  p.pro_codigo, 
			  p.pro_nombre, 
			  p.pro_cantidad 
			from producto p 
			where p.pro_eliminado='NO' 
			  and p.est_id_estado=11 ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>