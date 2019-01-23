<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salida_detalle_model extends CI_Model {
	function registrar($data) {
		$this->db->set('pro_id_producto', $data['pro_id_producto']);
		$this->db->set('sal_id_salida', $data['sal_id_salida']);
		$this->db->set('sad_cantidad', $data['sad_cantidad']);
		$this->db->set('sad_valor', 'IFNULL((SELECT SUM(pro_val_venta) FROM producto WHERE pro_id_producto='.$data['pro_id_producto'].'), 0)', FALSE);
		$this->db->set('sad_valor_total', 'IFNULL((SELECT SUM(pro_val_venta) FROM producto WHERE pro_id_producto='.$data['pro_id_producto'].'), 0)*'.$data['sad_cantidad'].'', FALSE);
		$this->db->set('est_id_estado', 1);
		$this->db->insert('salida_detalle');
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function quitar($sad_id_salida_detalle) {
		$this->db->where('sad_id_salida_detalle', $sad_id_salida_detalle);
		$result = $this->db->delete('salida_detalle');
		return $result;
	}
	function mbuscar_detalles($sal_id_salida) {
		$list = array();
		$query = $this->db->query("
			SELECT 
			  sad.pro_id_producto, 
			  sad.sal_id_salida, 
			  sad.sad_cantidad, 
			  sad.sad_valor, 
			  sad.sad_monto, 
			  p.pro_nombre, 
			  um.unm_nombre_corto 
			FROM salida_detalle sad 
			  INNER JOIN producto p 
			  ON sad.pro_id_producto=p.pro_id_producto 
			  INNER JOIN unidad_medida um 
			  ON p.unm_id_unidad_medida=um.unm_id_unidad_medida 
			WHERE sad.sal_id_salida=$sal_id_salida");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	
	// DUDA
	function buscar_x_id_salida_detalle($sad_id_salida_detalle) {
		$query = $this->db->query("
			SELECT 
			  sad.sad_id_salida_detalle, 
			  sad.pro_id_producto, 
			  sad.sal_id_salida, 
			  sad.sad_cantidad, 
			  sad.sad_valor, 
			  sad.sad_valor_total, 
			  p.pro_nombre, 
			  um.unm_nombre_corto 
			FROM salida_detalle sad 
			  LEFT JOIN producto p 
			  ON sad.pro_id_producto=p.pro_id_producto 
			  LEFT JOIN unidad_medida um 
			  ON p.unm_id_unidad_medida=um.unm_id_unidad_medida 
			WHERE sad.sad_id_salida_detalle=$sad_id_salida_detalle");
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return false;
	}
	// CALL: VISTA-SALIDA-CLIENTE-formulario -> CONTROL-SALIDA-DETALLE-buscar_productos_x_salida 
	function mbuscar_productos_x_salida($sal_id_salida) {
		$list = array();
		$i = 0;
		$query = $this->db->query("
			SELECT 
			  sad.sad_id_salida_detalle, 
			  sad.pro_id_producto, 
			  sad.sal_id_salida, 
			  sad.sad_cantidad, 
			  sad.sad_valor, 
			  sad.sad_valor_total, 
			  p.pro_nombre, 
			  um.unm_nombre_corto 
			FROM salida_detalle sad 
			  LEFT JOIN producto p 
			  ON sad.pro_id_producto=p.pro_id_producto 
			  LEFT JOIN unidad_medida um 
			  ON p.unm_id_unidad_medida=um.unm_id_unidad_medida 
			WHERE sad.sal_id_salida=$sal_id_salida 
			order by sad.sad_id_salida_detalle desc");
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