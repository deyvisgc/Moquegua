<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clase_model extends CI_Model {
	function registrar($data) {
		$this->db->set('cla_nombre', $data['cla_nombre']);
		$this->db->set('cla_id_clase_superior', $data['cla_id_clase_superior'], FALSE);
		$this->db->set('est_id_estado', $data['est_id_estado']);
		$this->db->set('cla_eliminado', "NO");
		$this->db->insert('clase');
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function update_datos($cla_id_clase, $data) {
		$this->db->set('cla_nombre', $data['cla_nombre']);
		$this->db->set('cla_id_clase_superior', $data['cla_id_clase_superior'], FALSE);
		$this->db->set('est_id_estado', $data['est_id_estado']);
		$this->db->where('cla_id_clase', $cla_id_clase);
        return $this->db->update('clase');
	}
	function update_datos2($cla_id_clase, $data) {
		$this->db->where('cla_id_clase', $cla_id_clase);
        return $this->db->update('clase', $data);
	}
	function buscar_all() {
		$list = array();
		$query = $this->db->query("select 
			  cla_id_clase, 
			  cla_nombre, 
			  cla_id_clase_superior 
			from clase 
			where cla_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_x_nombre($texto) {
		$list = array();
		$query = $this->db->query("select 
			  cla_id_clase, 
			  cla_nombre, 
			  IFNULL(cla_id_clase_superior, '') cla_id_clase_superior, 
			  IFNULL((select cla_nombre from clase cs where cs.cla_id_clase=c.cla_id_clase_superior), '') cla_nombre_superior, 
			  est_id_estado, 
			  (select est_nombre from estado e where e.est_id_estado=c.est_id_estado) est_nombre 
			from clase c 
			where cla_nombre like '%".$texto."%' 
			  and cla_eliminado='NO' ");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_all_superior() {
		$list = array();
		$query = $this->db->query("select 
			  cla_id_clase, 
			  cla_nombre 
			from clase c 
			where cla_id_clase_superior is null 
			  and cla_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	// OTROS
	// CALL: VISTA-PRODUCTO-INDEX -> CONTROL-CLASE-buscar_xll_habilitados
	// CALL: VISTA-INGRESO-PROVEEDOR-INDEX -> CONTROL-CLASE-buscar_xll_habilitados
	function buscar_all_habilitados() {
		$list = array();
		$query = $this->db->query("select 
			  cla_id_clase, 
			  cla_nombre, 
			  IFNULL(cla_id_clase_superior, '') cla_id_clase_superior, 
			  IFNULL((select cla_nombre from clase cs where cs.cla_id_clase=c.cla_id_clase_superior), '') cla_nombre_superior 
			from clase c 
			where est_id_estado=11 
			  and cla_eliminado='NO' 
			order by cla_nombre_superior, cla_nombre");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>