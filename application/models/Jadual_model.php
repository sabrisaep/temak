<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadual_model extends CI_Model
{
	public function onejadual($idjadual)
	{
		return $this->db->get_where('jadual', ['idjadual' => $idjadual])->row();
	}

	public function jadualindividu($pensyarah)
	{
		$this->db->from('jadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		$this->db->where(['pensyarah' => $pensyarah]);
		return $this->db->order_by('hari, masamula')->get()->result();
	}

	public function jadualseharipensyarah($pensyarah, $hari, $masa)
	{
		$this->db->from('jadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$syarat = [
			'pensyarah' => $pensyarah,
			'hari' => $hari,
			'masamula >' => $masa,
		];
		return $this->db->where($syarat)->limit(1)->get()->row();
	}

	public function jadualsehari($pensyarah, $hari)
	{
		$this->db->from('jadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$syarat = [
			'pensyarah' => $pensyarah,
			'hari' => $hari,
		];
		return $this->db->where($syarat)->get()->result();
	}

	public function jadualbiliksehari($hari, $masa, $bilik)
	{
		$syarat = [
			'hari' => $hari,
			'masamula >' => $masa,
			'bilik' => $bilik,
		];
		$this->db->from('jadual');
		$this->db->where($syarat)->limit(1);
		return $this->db->get()->row();
	}

	public function fulljadual($jabatan)
	{
		$this->db->from('jadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->join('kursus', 'ajar.kursus = kursus.idkursus');
		$this->db->where(['bilik.jabatan' => $jabatan]);
		return $this->db->get()->result();
	}

	public function semakjadual($jabatan, $jadual, $idpensyarah)
	{
		$return = [];

		# semak, pastikan bilik tak bertindan dengan orang lain
		$this->db->from('jadual');
		$this->db->join('bilik', 'jadual.bilik = bilik.idbilik');
		$syarat = [
			'jabatan' => $jabatan,
			'bilik' => $jadual->bilik,
			'hari' => $jadual->hari,
		];
		$this->db->where($syarat);
		$result = $this->db->get()->result();
		foreach ($result as $row) {
			# jika $jadual ada dalam $row
			for ($masamula = $row->masamula; $masamula < ($row->tempoh + $row->masamula); $masamula++) {
				if ($masamula == $jadual->masamula) {
					$return = $row;
					break;
				}
			}

			# jika $row ada dalam $jadual
			if (count($return) == 0) {
				for ($masamula = $jadual->masamula; $masamula < ($jadual->tempoh + $jadual->masamula); $masamula++) {
					if ($masamula == $row->masamula) {
						$return = $row;
						break;
					}
				}
			}
		}

		# seterusnya, kena semak,
		# adakah bertindih hari & masa,
		# walaupun bilik lain,
		# oleh pensyarah yang sama ($idpensyarah)
		$this->db->from('jadual');
		$this->db->join('ajar', 'jadual.ajar = ajar.idajar');
		$this->db->where(['pensyarah' => $idpensyarah, 'hari' => $jadual->hari]);
		$result = $this->db->get()->result();
		foreach ($result as $row) {
			# jika $jadual ada dalam $row
			for ($masamula = $row->masamula; $masamula < ($row->tempoh + $row->masamula); $masamula++) {
				if ($masamula == $jadual->masamula) {
					$return = $row;
					break;
				}
			}

			# jika $row ada dalam $jadual
			if (count($return) == 0) {
				for ($masamula = $jadual->masamula; $masamula < ($jadual->tempoh + $jadual->masamula); $masamula++) {
					if ($masamula == $row->masamula) {
						$return = $row;
						break;
					}
				}
			}
		}

		return $return;
	}

	public function savejadual($jadual)
	{
		if (!$jadual->idjadual) {
			$this->db->insert('jadual', $jadual);
		} else {
			$this->db->update('jadual', $jadual, ['idjadual' => $jadual->idjadual]);
		}
	}

	public function deletejadual($idjadual)
	{
		$this->db->delete('jadual', ['idjadual' => $idjadual]);
	}

	public function pensyarahbelum($idjabatan)
	{
		$this->db->select('bukanguru.pensyarah')->from('bukanguru');
		$this->db->join('pensyarah', 'bukanguru.pensyarah = pensyarah.idpensyarah');
		$result = $this->db->get()->result();
		$bukanguru = '';
		foreach ($result as $row) {
			$bukanguru .= $row->pensyarah . ',';
		}
		if (strlen($bukanguru) > 0) $bukanguru = substr($bukanguru, -1);

		$this->db->select('ajar.pensyarah')->from('ajar');
		$this->db->join('pensyarah', 'ajar.pensyarah = pensyarah.idpensyarah');
		$this->db->join('jadual', 'ajar.idajar = jadual.ajar');
		$result = $this->db->get()->result();
		$jadual = '';
		foreach ($result as $row) {
			$jadual .= $row->pensyarah . ',';
		}
		if (strlen($jadual) > 0) $jadual = substr($jadual, -1);

		$this->db->from('pensyarah');
		$this->db->where(['jabatan' => $idjabatan]);
		$this->db->where_in('idpensyarah', $bukanguru);
		$this->db->where_not_in('idpensyarah', $jadual);
		return $this->db->get()->result();
	}
}
