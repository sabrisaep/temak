<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukanguru_model extends CI_Model
{
	public function mengajar($pensyarah)
	{
		return $this->db->get_where('bukanguru', ['pensyarah' => $pensyarah])->row();
	}

	public function addnew($pensyarah)
	{
		$this->db->insert('bukanguru', $pensyarah);
	}

	public function deleteold($pensyarah)
	{
		$this->db->delete('bukanguru', ['pensyarah' => $pensyarah]);
	}
}
