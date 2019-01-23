<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_model extends CI_Model {
	function registrar($data) {
		$this->db->insert('persona', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	function update_datos($per_id_persona, $data) {
		$this->db->where('per_id_persona', $per_id_persona);
        return $this->db->update('persona', $data);
	}
}
?>