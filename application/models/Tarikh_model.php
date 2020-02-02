<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarikh_model extends CI_Model
{
	public function onetarikh($idtarikh)
	{
		return $this->db->get_where('tarikh', ['idtarikh' => $idtarikh])->row();
	}

	public function listtarikh($jabatan)
	{
		return $this->db->from('tarikh')->where(['jabatan' => $jabatan])->order_by('mk')->get()->result();
	}

	public function savetarikh($tarikh)
	{
		if (!$tarikh->idtarikh) {
			$this->db->insert('tarikh', $tarikh);
		} else {
			$this->db->update('tarikh', $tarikh, ['idtarikh' => $tarikh->idtarikh]);
		}
	}

	public function cleartarikh($jabatan)
	{
		$this->db->delete('tarikh', ['jabatan' => $jabatan]);
	}

	public function getmk($jabatan, $tarikh)
	{
		$syarat = [
			'jabatan' => $jabatan,
			'tarikh' => $tarikh,
		];
		$row = $this->db->get_where('tarikh', $syarat)->row();
		if ($row) {
			return $row->mk;
		}
	}

	public function gettarikh($jabatan, $mk)
	{
		$syarat = [
			'jabatan' => $jabatan,
			'mk' => $mk,
		];
		$row = $this->db->get_where('tarikh', $syarat)->row();
		if ($row) return $row->tarikh;
	}

	public function resetdata()
	{
		$this->db->truncate('tarikh');
	}
}
