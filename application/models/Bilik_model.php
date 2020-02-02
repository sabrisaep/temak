<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bilik_model extends CI_Model
{
	public function onebilik($idbilik)    # boleh terima idbilik dan kodbilik
	{
		if (is_numeric($idbilik)) $syarat = ['idbilik' => $idbilik];
		else $syarat = ['kodbilik' => $idbilik];
		return $this->db->get_where('bilik', $syarat)->row();
	}

	public function listbilik($jabatan)
	{
		$this->db->from('bilik')->where(['jabatan' => $jabatan]);
		return $this->db->order_by('kodbilik')->get()->result();
	}

	public function savebilik($bilik)
	{
		if (!$bilik->idbilik) {
			$this->db->insert('bilik', $bilik);
		} else {
			$this->db->update('bilik', $bilik, ['idbilik' => $bilik->idbilik]);
		}
		$error = $this->db->error();
		if ($error['code'] == 1062) {
			$this->session->set_flashdata('mesej', 'Maaf, bilik ini telah ada dalam senarai');
		}
	}

	public function deletebilik($idbilik)
	{
		$jadual = $this->db->get_where('jadual', ['bilik' => $idbilik])->row();
		$tempah = $this->db->get_where('tempah', ['bilik' => $idbilik])->row();

		if (!$jadual and !$tempah) {
			$this->db->delete('bilik', ['idbilik' => $idbilik]);
		} else {
			$this->session->set_flashdata('mesej', 'Maaf, bilik ini ada dalam jadual waktu. Tidak boleh dipadam.');
		}
	}

	public function onemkbilik($jabatan, $bilik, $mk)
	{
		$this->db->select('jadual')->from('kekosongan');
		$this->db->join('jadual', 'kekosongan.jadual = jadual.idjadual');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		$syarat = ['mk' => $mk, 'bilik' => $bilik, 'jabatan' => $jabatan];
		$kekosongan = $this->db->where($syarat)->get()->result();
		$kosong = [];
		foreach ($kekosongan as $row) {
			$kosong[] = $row->jadual;
		}

		$this->db->from('bilik');
		$this->db->join('jadual', 'bilik.idbilik = jadual.bilik');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->where(['idbilik' => $bilik]);
		if (count($kosong)) {
			$this->db->where_not_in('jadual.idjadual', $kosong);
		}
		$result1 = $this->db->get()->result();

		$this->db->from('bilik');
		$this->db->join('tempah', 'bilik.idbilik = tempah.bilik');
		$this->db->join('ajar', 'tempah.ajar = ajar.idajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->where(['idbilik' => $bilik]);
//		$this->db->where_not_in('jadual.idjadual', $kosong);
		$result2 = $this->db->get()->result();
		$rows = [];
		foreach ($result2 as $row) {
			$row->hari = dapatkanhari($row->tarikh);
			$row->namapensyarah = '[G] ' . $row->namapensyarah;
			$rows[] = $row;
		}
		$result2 = $rows;

		$result = array_merge($result1, $result2);
		return $result;
	}
}
