<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mukadepan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('jabatan_model');
		$this->load->model('pensyarah_model');
		$this->load->model('bukanguru_model');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function masuk()
	{
		$idp = $this->input->post('idp');
		$kata = $this->input->post('kata');

		$onejabatan = $this->jabatan_model->onejabatankod($idp);
		if ($onejabatan) {
			if (password_verify($kata, $onejabatan->kata)) {
				$this->session->set_userdata(['idjabatan' => $onejabatan->idjabatan]);
				redirect(base_url('jabatan'));
			} else {
				$this->session->set_flashdata('mesej', 'Maaf, ID Pengguna/Kata Laluan Salah.');
				redirect(base_url());
			}
		} else {
			$onepensyarah = $this->pensyarah_model->onepensyarahnokp($idp);
			if ($onepensyarah) {
				if (password_verify($kata, $onepensyarah->kata)) {
					$mengajar = $this->bukanguru_model->mengajar($onepensyarah->idpensyarah);
					if ($mengajar) {
						$this->session->set_userdata(['idpensyarah' => $onepensyarah->idpensyarah]);
						redirect(base_url('pensyarah'));
					} else {
						$this->session->set_flashdata('mesej', 'Maaf, anda bukan pensyarah yang mengajar.');
						redirect(base_url());
					}
				} else {
					$this->session->set_flashdata('mesej', 'Maaf, ID Pengguna/Kata Laluan Salah.');
					redirect(base_url());
				}
			} else {
				$this->session->set_flashdata('mesej', 'Maaf, ID Pengguna/Kata Laluan Salah.');
				redirect(base_url());
			}
		}
	}

	public function keluar()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
