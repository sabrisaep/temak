<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajar_model extends CI_Model
{
	public function oneajar($idajar)
	{
		$this->db->from('ajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		return $this->db->where(['idajar' => $idajar])->get()->row();
	}

	public function pensyarahajar($pensyarah, $kursus)
	{
		$syarat = [
			'pensyarah' => $pensyarah,
			'kursus' => $kursus,
		];
		$row = $this->db->get_where('ajar', $syarat)->row();
		if ($row) {
			$idajar = $row->idajar;
		} else {
			$this->db->insert('ajar', $syarat);
			$idajar = $this->db->insert_id();
		}
		return $idajar;
	}

	public function listajar($pensyarah)
	{
		$this->db->from('ajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		return $this->db->where(['pensyarah' => $pensyarah])->get()->result();
	}

	public function saveajar($ajar)
	{
		if (!$ajar->idajar) {
			$this->db->insert('ajar', $ajar);
		} else {
			$this->db->update('ajar', $ajar, ['idajar' => $ajar->idajar]);
		}
	}

	public function deleteajar($idajar)
	{
		$jadual = $this->db->get_where('jadual', ['ajar' => $idajar])->row();
		$tempah = $this->db->get_where('tempah', ['ajar' => $idajar])->row();

		if (!$jadual and !$tempah) {
			$this->db->delete('ajar', ['idajar' => $idajar]);
		}
	}
}
