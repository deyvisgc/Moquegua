<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidad_medida_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('unidad_medida', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function update_datos($unm_id_unidad_medida, $data) {
		$this->db->where('unm_id_unidad_medida', $unm_id_unidad_medida);
        return $this->db->update('unidad_medida', $data);
	}
	function buscar_all() {
		$list = array();
		$query = $this->db->query("select 
				  unm_id_unidad_medida, 
				  unm_nombre, 
				  unm_nombre_corto 
				from unidad_medida 
				where unm_eliminado='NO' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_x_nombre_o_corto($texto) {
		$list = array();
		$query = $this->db->query("select 
				  unm_id_unidad_medida, 
				  unm_nombre, 
				  unm_nombre_corto, 
				  est.est_id_estado, 
				  est.est_nombre 
				from unidad_medida unm 
				  inner join estado est 
				  on est.est_id_estado=unm.est_id_estado 
				where (unm_nombre like '%".$texto."%' 
				  or unm_nombre_corto like '%".$texto."%') 
				  and unm_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	// OTROS
	// CALL: VISTA-PRODUCTO-INDEX -> CONTROL-UNIDAD-MEDIDA-buscar_xll_habilitados
	function buscar_all_habilitados() {
		$list = array();
		$query = $this->db->query("select 
				  unm_id_unidad_medida, 
				  unm_nombre, 
				  unm_nombre_corto 
				from unidad_medida um 
				where est_id_estado=11 
				and unm_eliminado='NO' 
				order by unm_nombre ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>