<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tempah_model extends CI_Model
{
	/*
	public function onetempah($idtempah)
	{
		return $this->db->get_where('tempah', ['idtempah' => $idtempah])->row();
	}
	*/
	public function listtempah($ajar)
	{
		return $this->db->get_where('tempah', ['ajar' => $ajar])->result();
	}

	public function tempahanmk($tarikh1, $tarikh2)
	{
		$this->db->from('tempah');
		$this->db->join('bilik', 'tempah.bilik = bilik.idbilik');
		$this->db->where("tarikh BETWEEN '$tarikh1' AND '$tarikh2'");
		$result = $this->db->get()->result();
		$rows = [];
		foreach ($result as $row) {
			$row->hari = dapatkanhari($row->tarikh);
			$rows[] = $row;
		}
		return $rows;
	}

	public function tempahanpensyarah($idpensyarah)
	{
		$this->db->from('tempah');
		$this->db->join('bilik', 'tempah.bilik = bilik.idbilik');
		$this->db->join('ajar', 'tempah.ajar = ajar.idajar');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->where(['pensyarah' => $idpensyarah])->order_by('tarikh, masamula');
		return $this->db->get()->result();
	}

	public function tempahsehari($idpensyarah, $tarikh, $masa)
	{
		$syarat = [
			'pensyarah' => $idpensyarah,
			'tarikh' => $tarikh,
			'masamula >' => $masa,
		];
		$this->db->from('tempah');
		$this->db->join('bilik', 'tempah.bilik = bilik.idbilik');
		$this->db->join('ajar', 'tempah.ajar = ajar.idajar');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->where($syarat)->order_by('tarikh, masamula');
		return $this->db->limit(1)->get()->row();
	}

	public function tempahbilik($bilik, $tarikh, $masa)
	{
		$syarat = [
			'bilik' => $bilik,
			'tarikh' => $tarikh,
			'masamula' => $masa,
		];
		return $this->db->get_where('tempah', $syarat)->row();
	}

	public function savetempah($tempah)
	{
		if (!$tempah->idtempah) {
			$this->db->insert('tempah', $tempah);
			$idtempah = $tempah->idtempah;
		} else {
			$this->db->update('tempah', $tempah, ['idtempah' => $tempah->idtempah]);
			$idtempah = $this->db->insert_id();
		}
		return $idtempah;
	}

	public function deletetempah($idtempah)
	{
		$this->db->delete('tempah', ['idtempah' => $idtempah]);
	}
}
