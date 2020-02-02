<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kekosongan_model extends CI_Model
{
	public function listkekosongan($idpensyarah)
	{
		$this->db->from('kekosongan');
		$this->db->join('jadual', 'kekosongan.jadual = jadual.idjadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		$this->db->where(['pensyarah' => $idpensyarah])->order_by('mk, hari, masamula');
		return $this->db->get()->result();
	}

	public function kekosonganmk($idjabatan, $mk)
	{
		$syarat = [
			'jabatan' => $idjabatan,
			'mk' => $mk,
		];
		$this->db->from('kekosongan');
		$this->db->join('jadual', 'kekosongan.jadual = jadual.idjadual');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		return $this->db->where($syarat)->get()->result();
	}

	public function savekekosongan($kekosongan)
	{
		$bil = $this->db->from('kekosongan')->where($kekosongan)->count_all_results();
		if ($bil == 0) $this->db->insert('kekosongan', $kekosongan);
	}

	public function deletekekosongan($idkekosongan)
	{
		$this->db->delete('kekosongan', ['idkekosongan' => $idkekosongan]);
	}

	public function clearkekosongan($idjadual)
	{
		$this->db->delete('kekosongan', ['jadual' => $idjadual]);
	}
}
