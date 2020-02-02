<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kursus_model extends CI_Model
{
	public function onekursus($idkursus)
	{
		return $this->db->get_where('kursus', ['idkursus' => $idkursus])->row();
	}

	public function listkursus($jabatan)
	{
		$this->db->from('kursus')->where(['jabatan' => $jabatan]);
		return $this->db->order_by('kodkursus')->get()->result();
	}

	public function savekursus($kursus)
	{
		if (!$kursus->idkursus) {
			$this->db->insert('kursus', $kursus);
		} else {
			$this->db->update('kursus', $kursus, ['idkursus' => $kursus->idkursus]);
		}
		$error = $this->db->error();
		if ($error['code'] == 1062) {
			$this->session->set_flashdata('mesej', 'Maaf, kursus ini telah ada dalam senarai');
		}
	}

	public function deletekursus($idkursus)
	{
		$ajar = $this->db->get_where('ajar', ['kursus' => $idkursus])->row();

		if (!$ajar) {
			$this->db->delete('kursus', ['idkursus' => $idkursus]);
		} else {
			$this->session->set_flashdata('mesej', 'Maaf, kursus ini dalam jadual waktu. Tidak boleh dipadam.');
		}
	}
}
