<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pensyarah_model extends CI_Model
{
	public function onepensyarahnokp($nokp)
	{
		return $this->db->get_where('pensyarah', ['nokp' => $nokp])->row();
	}

	public function onepensyarah($idpensyarah)
	{
		return $this->db->get_where('pensyarah', ['idpensyarah' => $idpensyarah])->row();
	}

	public function listpensyarah($jabatan)
	{
		$result = $this->db->get_where('pensyarah', ['jabatan' => $jabatan])->result();
		foreach ($result as $row) {
			$syarat = ['pensyarah' => $row->idpensyarah];

			$bukanguru = $this->db->get_where('bukanguru', $syarat)->row();
			if ($bukanguru) $row->status = 'Mengajar';
			else $row->status = 'Tidak Mengajar';

			$jadualsiap = $this->db->get_where('jadualsiap', $syarat)->row();
			if ($jadualsiap) $row->jadual = 'Siap';
			else $row->jadual = 'Belum Siap';

			$rows[] = $row;
		}
		return $rows;
	}
}
