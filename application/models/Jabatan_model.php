<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan_model extends CI_Model
{
	public function onejabatankod($kodjabatan)
	{
		return $this->db->get_where('jabatan', ['kodjabatan' => $kodjabatan])->row();
	}

	public function onejabatan($idjabatan)
	{
		return $this->db->get_where('jabatan', ['idjabatan' => $idjabatan])->row();
	}
}
