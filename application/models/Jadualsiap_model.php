<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadualsiap_model extends CI_Model
{
	public function jadualsiap($pensyarah)
	{
		return $this->db->get_where('jadualsiap', ['pensyarah' => $pensyarah])->row();
	}

	public function addnew($pensyarah)
	{
		$this->db->insert('jadualsiap', ['pensyarah' => $pensyarah]);
	}

	public function deleteold($pensyarah)
	{
		$this->db->delete('jadualsiap', ['pensyarah' => $pensyarah]);
	}

	public function adasiap($idjabatan)
	{
		$this->db->from('jadualsiap');
		$this->db->join('pensyarah', 'jadualsiap.pensyarah = pensyarah.idpensyarah');
		$this->db->where(['jabatan' => $idjabatan]);
		$result = $this->db->get()->result();
		if (count($result)) {
			return true;
		} else {
			return false;
		}
	}
}
