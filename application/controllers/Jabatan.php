<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
	public $idjabatan;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tarikhmk_helper');
		$this->load->model('pensyarah_model');
		$this->load->model('jabatan_model');
		$this->load->model('bilik_model');
		$this->load->model('bukanguru_model');
		$this->load->model('kursus_model');
		$this->load->model('tarikh_model');
		$this->load->model('jadual_model');
		$this->load->model('ajar_model');
		$this->load->model('tempah_model');
		$this->load->model('kekosongan_model');
		$this->load->model('jadualsiap_model');
		$this->dahlogin();
	}

	private function dahlogin()
	{
		if ($this->session->userdata('idjabatan')) {
			$this->idjabatan = $this->session->userdata('idjabatan');
		} else {
			redirect(base_url());
		}
	}

	public function index()
	{
		redirect(base_url('jabatan/bilik'));
	}

	# mula bilik
	public function bilik()
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data['bilik'] = $this->bilik_model->listbilik($this->idjabatan);

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/bilik', $data);
		$this->load->view('jabatan/bawah');
	}

	public function editbilik($idbilik)
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data = [
			'onebilik' => $this->bilik_model->onebilik($idbilik),
			'bilik' => $this->bilik_model->listbilik($this->idjabatan),
		];

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/bilik', $data);
		$this->load->view('jabatan/bawah');
	}

	public function savebilik()
	{
		$bilik = (object)[
			'idbilik' => $this->input->post('idbilik'),
			'jabatan' => $this->idjabatan,
			'kodbilik' => strtoupper($this->input->post('kodbilik')),
		];
		$this->bilik_model->savebilik($bilik);
		redirect(base_url('jabatan/bilik'));
	}

	public function deletebilik($idbilik)
	{
		$this->bilik_model->deletebilik($idbilik);
		redirect(base_url('jabatan/bilik'));
	}
	# tamat bilik

	# mula kursus
	public function kursus()
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data['kursus'] = $this->kursus_model->listkursus($this->idjabatan);

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/kursus', $data);
		$this->load->view('jabatan/bawah');
	}

	public function editkursus($idkursus)
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data = [
			'onekursus' => $this->kursus_model->onekursus($idkursus),
			'kursus' => $this->kursus_model->listkursus($this->idjabatan),
		];

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/kursus', $data);
		$this->load->view('jabatan/bawah');
	}

	public function savekursus()
	{
		$kursus = (object)[
			'idkursus' => $this->input->post('idkursus'),
			'jabatan' => $this->idjabatan,
			'kodkursus' => strtoupper($this->input->post('kodkursus')),
			'namakursus' => strtoupper($this->input->post('namakursus')),
		];
		$this->kursus_model->savekursus($kursus);
		redirect(base_url('jabatan/kursus'));
	}

	public function deletekursus($idkursus)
	{
		$this->kursus_model->deletekursus($idkursus);
		redirect(base_url('jabatan/kursus'));
	}
	# tamat kursus

	# mula pensyarah
	public function pensyarah()
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data['listpensyarah'] = $this->pensyarah_model->listpensyarah($this->idjabatan);

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/pensyarah', $data);
		$this->load->view('jabatan/bawah');
		#$this->load->view('jabatan/pensyarah-script');
	}

	public function statuspensyarah($idpensyarah)
	{
		$mengajar = $this->bukanguru_model->mengajar($idpensyarah);
		if ($mengajar) {
			$this->bukanguru_model->deleteold($idpensyarah);
		} else {
			$this->bukanguru_model->addnew(['pensyarah' => $idpensyarah]);
		}
		redirect(base_url('jabatan/pensyarah'));
	}
	# tamat pensyarah

	# mula tarikh minggu kuliah
	public function tarikhmk()
	{
		$bolehubah = !$this->jadualsiap_model->adasiap($this->idjabatan);

		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data = [
			'listtarikh' => $this->tarikh_model->listtarikh($this->idjabatan),
			'bolehubah' => $bolehubah,
		];

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/tarikhmk', $data);
		$this->load->view('jabatan/bawah');
		$this->load->view('jabatan/tarikh-script');
	}

	public function addnewmk()
	{
		$jumlahmk = $this->input->post('jumlahmk');
		$mkpertama = tarikh($this->input->post('mkpertama'));
		$cutimidsem = tarikh($this->input->post('cutimidsem'));

		$cutiraya = $this->input->post('cutiraya');
		if ($cutiraya == '') $cutiraya = $cutimidsem;
		$cutiraya = tarikh($cutiraya);
		$cutitambah = $this->input->post('cutitambah');
		if ($cutitambah == '') $cutitambah = $cutimidsem;

		if (hariisnin($mkpertama) and hariisnin($cutimidsem) and hariisnin($cutiraya) and hariisnin($cutitambah)) {
			$this->tarikh_model->cleartarikh($this->idjabatan);

			$tarikhmk = $mkpertama;
			$tarikhms = $cutimidsem;
			$tarikhry = $cutiraya;
			$tarikhtm = $cutitambah;

			for ($mk = 1; $mk <= $jumlahmk; $mk++) {
				if ($tarikhmk != $tarikhms and $tarikhmk != $tarikhry and $tarikhmk != $tarikhtm) {
					$tarikh = (object)[
						'idtarikh' => 0,
						'jabatan' => $this->idjabatan,
						'mk' => $mk,
						'tarikh' => $tarikhmk,
					];
					$this->tarikh_model->savetarikh($tarikh);
				} else {
					$mk--;
				}

				$tarikhmk = tarikh7hari($tarikhmk);
			}
		} else {
			$this->session->set_flashdata('mesej', 'Maaf, ada tarikh yang anda masukkan bukan hari Isnin.');
		}
		redirect(base_url('jabatan/tarikhmk'));
	}

	public function cleartarikh()
	{
		$this->tarikh_model->cleartarikh($this->idjabatan);
		redirect(base_url('jabatan/tarikhmk'));
	}
	# tamat tarikh minggu kuliah

	# mula jadual
	public function jadual()
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data['listpensyarah'] = $this->pensyarah_model->listpensyarah($this->idjabatan);

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/jadual', $data);
		$this->load->view('jabatan/bawah');
	}

	public function jadualindividu($idpensyarah)
	{
		$jadual = [];
		$jadualindividu = $this->jadual_model->jadualindividu($idpensyarah);
		foreach ($jadualindividu as $row) {
			$jadual[$row->hari][$row->masamula]['kodbilik'] = $row->kodbilik;
			$jadual[$row->hari][$row->masamula]['kodkursus'] = $row->kodkursus;
			if ($row->tempoh > 1) {
				for ($tambahan = 1; $tambahan < $row->tempoh; $tambahan++) {
					$jadual[$row->hari][$row->masamula + $tambahan]['kodbilik'] = $row->kodbilik;
					$jadual[$row->hari][$row->masamula + $tambahan]['kodkursus'] = $row->kodkursus;
				}
			}
		}

		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$data = [
			'onepensyarah' => $this->pensyarah_model->onepensyarah($idpensyarah),
			'jadual' => $jadual,
		];

		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/jadualindividu', $data);
		$this->load->view('jabatan/bawah');
	}
	# tamat jadual

	# mula reset data
	public function resetdata()
	{
		$atas['jabatan'] = $this->jabatan_model->onejabatan($this->idjabatan);
		$this->load->view('jabatan/atas', $atas);
		$this->load->view('jabatan/resetdata');
		$this->load->view('jabatan/bawah');
		$this->load->view('jabatan/resetdata-script');
	}

	public function resetkandata()
	{
		$listpensyarah = $this->pensyarah_model->listpensyarah($this->idjabatan);
		foreach ($listpensyarah as $pensyarah) {
			$listajar = $this->ajar_model->listajar($pensyarah->idpensyarah);
			foreach ($listajar as $row) {
				$listtempah = $this->tempah_model->listtempah($row->idajar);
				foreach ($listtempah as $tempah) {
					$this->tempah_model->deletetempah($tempah->idtempah);
				}
				$this->ajar_model->deleteajar($row->idajar);
			}
			$this->jadualsiap_model->deleteold($pensyarah->idpensyarah);
		}

		$fulljadual = $this->jadual_model->fulljadual($this->idjabatan);
		foreach ($fulljadual as $row) {
			$this->kekosongan_model->clearkekosongan($row->idjadual);
			$this->jadual_model->deletejadual($row->idjadual);
		}

		$this->tarikh_model->cleartarikh($this->idjabatan);

		$this->session->set_flashdata('mesej', 'Data telah direset.');
		redirect(base_url('jabatan/resetdata'));
	}
	# tamat reset data
}
