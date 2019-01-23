<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pcliente_model extends CI_Model {
	function mregistrar($data) {
		$this->db->insert('pcliente',$data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function mactualizar($pcl_id_pcliente, $data) {
		$this->db->where('pcl_id_pcliente', $pcl_id_pcliente);
        return $this->db->update('pcliente', $data);
	}
	function buscar_proveedores() {
		$list = array();
		$query = $this->db->query("SELECT 
			  pcl_id_pcliente, 
			  emp_ruc, 
			  emp_razon_social, 
			  emp_direccion, 
			  emp_nombre_contacto 
			FROM pcliente pc 
			  INNER JOIN empresa e 
			  ON pc.emp_id_empresa=e.emp_id_empresa 
			where (pc.pcl_tipo='2' 
			  or pc.pcl_tipo='3') 
			  and pc.pcl_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_clientes() {
		$list = array();
		$query = $this->db->query("SELECT 
			  pcl_id_pcliente, 
			  emp_ruc, 
			  emp_razon_social, 
			  emp_direccion, 
			  emp_nombre_contacto 
			FROM pcliente pc 
			  INNER JOIN empresa e 
			  ON pc.emp_id_empresa=e.emp_id_empresa 
			where (pc.pcl_tipo='1' 
			  or pc.pcl_tipo='3') 
			  and pc.pcl_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
	function buscar_x_razon_social_o_ruc($texto) {
		$list = array();
		$query = $this->db->query("SELECT 
			  pc.pcl_id_pcliente, 
			  IF(pc.pcl_tipo = '1', 'CLIENTE', IF(pc.pcl_tipo = '2', 'PROVEEDOR', IF(pc.pcl_tipo = '3', 'AMBOS', 'X'))) pcl_tipo_nombre, 
			  pc.pcl_tipo, 
			  est.est_id_estado, 
			  est.est_nombre, 
			  e.emp_id_empresa, 
			  e.emp_ruc, 
			  e.emp_razon_social, 
			  e.emp_direccion, 
			  e.emp_telefono, 
			  e.emp_nombre_contacto 
			FROM pcliente pc 
			  INNER JOIN empresa e 
			  ON pc.emp_id_empresa=e.emp_id_empresa 
			  INNER JOIN estado est 
			  ON pc.est_id_estado=est.est_id_estado 
			where (e.emp_ruc like '%".$texto."%' 
			  or e.emp_razon_social like '%".$texto."%') 
			  and pc.pcl_eliminado='NO'");
		foreach ($query->result() as $row)
		{
			$list[] = $row;
		}
		return $list;
	}
}
?>