<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimiento_model extends CI_Model {
	function mregistrar($data) {
		$this->db->insert('movimiento', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
}
?>