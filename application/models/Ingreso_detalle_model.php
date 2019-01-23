<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingreso_detalle_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('ingreso_detalle', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function quitar($ind_id_ingreso_detalle) {
		$this->db->where('ind_id_ingreso_detalle', $ind_id_ingreso_detalle);
		$this->db->delete('ingreso_detalle');
	}
	// CALL: VISTA-INGRESO-PROVEEDOR-formulario -> CONTROL-INGRESO-DETALLE-buscar_productos_x_ingreso
	function mbuscar_productos_x_ingreso($ing_id_ingreso) {
		$list = array();
		$i = 0;
		$query = $this->db->query("SELECT 
			  ide.ind_id_ingreso_detalle, 
			  ide.pro_id_producto, 
			  ide.ing_id_ingreso, 
			  ide.ind_cantidad, 
			  ide.ind_valor, 
			  ide.ind_numero_lote, 
			  ide.ind_valor_total, 
			  p.pro_nombre, 
			  um.unm_nombre_corto 
			FROM ingreso_detalle ide 
			  LEFT JOIN producto p 
			  ON ide.pro_id_producto=p.pro_id_producto 
			  LEFT JOIN unidad_medida um 
			  ON p.unm_id_unidad_medida=um.unm_id_unidad_medida 
			WHERE ide.ing_id_ingreso=$ing_id_ingreso 
			order by ide.ind_id_ingreso_detalle desc");
		foreach ($query->result() as $row)
		{
			$i++;
			$row->nro = $i;
			$list[] = $row;
		}
		return $list;
	}
}
?>