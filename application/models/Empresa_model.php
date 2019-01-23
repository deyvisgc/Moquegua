<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('empresa',$data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function update_datos($emp_id_empresa, $data) {
		$this->db->where('emp_id_empresa', $emp_id_empresa);
        return $this->db->update('empresa', $data);
	}
}
?>