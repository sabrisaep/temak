<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pensyarah extends CI_Controller
{
	public $idpensyarah, $idjabatan;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tarikhmk_helper');
		$this->load->model('pensyarah_model');
		$this->load->model('ajar_model');
		$this->load->model('bilik_model');
		$this->load->model('jadual_model');
		$this->load->model('kursus_model');
		$this->load->model('tarikh_model');
		$this->load->model('tempah_model');
		$this->load->model('kekosongan_model');
		$this->load->model('jadualsiap_model');
		$this->dahlogin();
	}

	private function dahlogin()
	{
		if ($this->session->userdata('idpensyarah')) {
			$this->idpensyarah = $this->session->userdata('idpensyarah');
			$pensyarah = $this->pensyarah_model->onepensyarah($this->idpensyarah);
			$this->idjabatan = $pensyarah->jabatan;
		} else {
			redirect(base_url());
		}
	}

	private function dahsiapke()
	{
		$listpensyarah = $this->pensyarah_model->listpensyarah($this->idjabatan);
		$lengkap = true;
		$mengajar = 0;
		foreach ($listpensyarah as $row) {
			if ($row->status == 'Mengajar') {
				$mengajar++;
				if ($row->jadual == 'Belum Siap') {
					$lengkap = false;
					break;
				}
			}
		}

		if (!$lengkap or !$mengajar) {
			redirect(base_url('pensyarah/belumsiap'));
		}
	}

	public function belumsiap()
	{
		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data['listpensyarah'] = $this->pensyarah_model->listpensyarah($this->idjabatan);

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/belumsiap', $data);
		$this->load->view('pensyarah/bawah');
	}

	public function index()
	{
		redirect(base_url('pensyarah/tempah'));
	}

	private function bilikkosong($mk)
	{
		$listbilik = $this->bilik_model->listbilik($this->idjabatan);
		$semuabilik = [];
		foreach ($listbilik as $bilik) {
			$semuabilik[] = $bilik->kodbilik;
		}

		$fulljadual = $this->jadual_model->fulljadual($this->idjabatan);
		$kekosonganmk = $this->kekosongan_model->kekosonganmk($this->idjabatan, $mk);
		$kosong = [];
		foreach ($kekosonganmk as $row) {
			$kosong[] = $row->idjadual;
		}
		$jadualfull = [];
		foreach ($fulljadual as $row) {
			if (!in_array($row->idjadual, $kosong)) {
				$jadualfull[] = $row;
			}
		}
		$fulljadual = $jadualfull;

		$tarikh1 = $this->tarikh_model->gettarikh($this->idjabatan, $mk);
		$tarikh2 = tarikh4hari($tarikh1);
		$tempahanmk = $this->tempah_model->tempahanmk($tarikh1, $tarikh2);

		$timetable = [];
		foreach ($fulljadual as $jadual) {
			for ($tempoh = 0; $tempoh < $jadual->tempoh; $tempoh++) {
				$timetable[$jadual->hari][$jadual->masamula + $tempoh][] = $jadual;
			}
		}
		foreach ($tempahanmk as $tempah) {
			for ($tempoh = 0; $tempoh < $tempah->tempoh; $tempoh++) {
				$timetable[$tempah->hari][$tempah->masamula + $tempoh][] = $tempah;
			}
		}

		$bilikkosong = [];
		for ($hari = 1; $hari <= 5; $hari++) {
			for ($masa = 1; $masa <= 12; $masa++) {
				$kekosongan = $semuabilik;
				if (isset($timetable[$hari][$masa])) {
					foreach ($timetable[$hari][$masa] as $index => $jadual) {
						$key = array_search($jadual->kodbilik, $kekosongan);
						if ($key) unset($kekosongan[$key]);
					}
				}
				$bilikkosong[$hari][$masa] = $kekosongan;
			}
		}

		return $bilikkosong;
	}

	public function tempah()
	{
		$this->dahsiapke();

		$mk = 0;
		$mk = $this->input->post('mk');
		if ($mk == 0) {
			$tarikh = date('Y-m-d');
			if (!hariisnin($tarikh)) $tarikh = isninkan($tarikh);
			$mk = $this->tarikh_model->getmk($this->idjabatan, $tarikh);
			if (!$mk) $mk = 0;
		}

		$seminggu = [];
		if ($mk > 0) {
			$gettarikh = $this->tarikh_model->gettarikh($this->idjabatan, $mk);
			$tarikh1 = new DateTime($gettarikh);
			$tarikh2 = new DateTime(tarikh7hari($gettarikh));
			$interval = new DateInterval('P1D');
			$liputan = new DatePeriod($tarikh1, $interval, $tarikh2);
			foreach ($liputan as $tarikh) {
				$seminggu[] = $tarikh->format('Y-m-d');
			}
		}

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'mk' => $mk,
			'seminggu' => $seminggu,
			'listtarikh' => $this->tarikh_model->listtarikh($this->idjabatan),
			'bilikkosong' => $this->bilikkosong($mk),
			'tempahanpensyarah' => $this->tempah_model->tempahanpensyarah($this->idpensyarah),
			'waktumengajar' => $this->waktumengajar($seminggu),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/tempah', $data);
		$this->load->view('pensyarah/bawah');
		$this->load->view('pensyarah/tempah-script');
	}

	private function waktumengajar($seminggu)
	{
		$waktumengajar = [];

		$jadualindividu = $this->jadual_model->jadualindividu($this->idpensyarah);
		foreach ($jadualindividu as $row) {
			for ($tempoh = 0; $tempoh < $row->tempoh; $tempoh++) {
				$waktumengajar[$row->hari][$row->masamula + $tempoh] = $row;
			}
		}

		$tempahanpensyarah = $this->tempah_model->tempahanpensyarah($this->idpensyarah);
		foreach ($tempahanpensyarah as $row) {
			if (in_array($row->tarikh, $seminggu)) {
				$hari = dapatkanhari($row->tarikh);
				for ($tempoh = 0; $tempoh < $row->tempoh; $tempoh++) {
					$waktumengajar[$hari][$row->masamula + $tempoh] = $row;
				}
			}
		}

		return $waktumengajar;
	}

	public function menempah($mk, $hari, $masa, $kodbilik)
	{
		$gettarikh = $this->tarikh_model->gettarikh($this->idjabatan, $mk);
		$harid = $hari + 1;
		$tarikh = date_create($gettarikh);
		date_add($tarikh, date_interval_create_from_date_string("$harid days"));
		$bilik = $this->bilik_model->onebilik($kodbilik);

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'tarikh' => $gettarikh,
			'bilik' => $bilik,
			'masa' => $masa,
			'listajar' => $this->ajar_model->listajar($this->idpensyarah),
			'maxtempoh' => $this->maxtempoh($mk, $hari, $masa, $kodbilik),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/menempah', $data);
		$this->load->view('pensyarah/bawah');
	}

	private function maxtempoh($mk, $hari, $masa, $kodbilik)
	{
		$onebilik = $this->bilik_model->onebilik($kodbilik);
		$jadualbiliksehari = $this->jadual_model->jadualbiliksehari($hari, $masa, $onebilik->idbilik);

		$baki = 10 - $masa;
		if ($jadualbiliksehari) {
			$masamula = $jadualbiliksehari->masamula;
			$baki = $masamula - $masa;
		}

		# semak pula, adakah pensyarah ini free selepas itu
		# - jadual pensyarah   # - tempahan pensyarah tersebut
		$jadualseharipensyarah = $this->jadual_model->jadualseharipensyarah($this->idpensyarah, $hari, $masa);
		if ($jadualseharipensyarah) {
			$baki = $jadualseharipensyarah->masamula - $masa;
		}

		$gettarikh = $this->tarikh_model->gettarikh($this->idjabatan, $mk);
		$tempahsehari = $this->tempah_model->tempahsehari($this->idpensyarah, $gettarikh, $masa);
		if ($tempahsehari) {
			$baki2 = $tempahsehari->masamula - $masa;
			if ($baki > $baki2) $baki = $baki2;
		}

		return $baki;
	}

	public function savetempah()
	{
		$bilik = $this->input->post('bilik');
		$tarikh = $this->input->post('tarikh');
		$masamula = $this->input->post('masamula');
		$tempoh = $this->input->post('tempoh');

		$tempah = (object)[
			'ajar' => $this->input->post('ajar'),
			'bilik' => $bilik,
			'tarikh' => $tarikh,
			'masamula' => $masamula,
			'tempoh' => $tempoh,
		];

		# sebelum save, kena check dulu, adakah bertindih?
		# kaji bilik, tarikh, masamula, tempoh
		$telahada = false;
		for ($masa = $masamula; $masa < $masamula + $tempoh; $masa++) {
			$tempahbilik = $this->tempah_model->tempahbilik($bilik, $tarikh, $masa);
			if ($tempahbilik) {
				$telahada = true;
				break;
			}
		}

		if (!$telahada) {
			$idtempah = $this->tempah_model->savetempah($tempah);
			$mk = $this->tarikh_model->getmk($this->idjabatan, $tarikh);
			redirect(base_url("pensyarah/penggunabilik/$mk/$bilik"));
		} else {
			$this->session->set_flashdata('mesej', 'Maaf, tempahan anda telah bertindih dengan tempahan lain. Sila cuba sekali lagi.');
			redirect(base_url('pensyarah/tempah'));
		}
	}

	public function deletetempah($idtempah)
	{
		$this->tempah_model->deletetempah($idtempah);
		redirect(base_url('pensyarah/tempah'));
	}

	public function jadual()
	{
		$jadual = [];
		$jadualindividu = $this->jadual_model->jadualindividu($this->idpensyarah);
		foreach ($jadualindividu as $row) {
			$jadual[$row->hari][$row->masamula]['kodbilik'] = $row->kodbilik;
			$jadual[$row->hari][$row->masamula]['kodkursus'] = $row->kodkursus;
			$jadual[$row->hari][$row->masamula]['idjadual'] = $row->idjadual;
			if ($row->tempoh > 1) {
				for ($tambahan = 1; $tambahan < $row->tempoh; $tambahan++) {
					$jadual[$row->hari][$row->masamula + $tambahan]['kodbilik'] = $row->kodbilik;
					$jadual[$row->hari][$row->masamula + $tambahan]['kodkursus'] = $row->kodkursus;
					$jadual[$row->hari][$row->masamula + $tambahan]['idjadual'] = $row->idjadual;
				}
			}
		}

		$statusjadual = 'Belum Siap';
		$jadualsiap = $this->jadualsiap_model->jadualsiap($this->idpensyarah);
		if ($jadualsiap) {
			$statusjadual = 'Siap';
		}

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'jadual' => $jadual,
			'status' => $statusjadual,
			'kursus' => $this->kursus_model->listkursus($this->idjabatan),
			'bilik' => $this->bilik_model->listbilik($this->idjabatan),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/jadual', $data);
		$this->load->view('pensyarah/bawah');
	}

	public function savejadual()
	{
		$kursus = $this->input->post('kursus');

		$jadual = (object)[
			'idjadual' => $this->input->post('idjadual'),
			'ajar' => $this->ajar_model->pensyarahajar($this->idpensyarah, $kursus),
			'bilik' => $this->input->post('bilik'),
			'hari' => $this->input->post('hari'),
			'masamula' => $this->input->post('masamula'),
			'tempoh' => $this->input->post('tempoh'),
		];

		$semakjadual = $this->jadual_model->semakjadual($this->idjabatan, $jadual, $this->idpensyarah);

		if (count($semakjadual) == 0) {
			$this->jadual_model->savejadual($jadual);
			redirect(base_url('pensyarah/jadual'));
		} else {
			$this->session->set_flashdata('jadual', $jadual);
			$this->session->set_flashdata('semakjadual', $semakjadual);
			redirect(base_url('pensyarah/jadualbertindih'));
		}
	}

	public function jadualbertindih()
	{
		if (!($this->session->flashdata('jadual'))) redirect(base_url('pensyarah/jadual'));

		$jadual = $this->session->flashdata('jadual');
		$oneajar = $this->ajar_model->oneajar($jadual->ajar);
		$jadual->kodkursus = $oneajar->kodkursus;
		$onebilik = $this->bilik_model->onebilik($jadual->bilik);
		$jadual->kodbilik = $onebilik->kodbilik;
		$masakelas = '';
		for ($masamula = $jadual->masamula; $masamula < ($jadual->tempoh + $jadual->masamula); $masamula++) {
			$masakelas .= masamasa($masamula) . ' / ';
		}
		$masakelas = substr($masakelas, 0, -3);
		$jadual->masakelas = $masakelas;
		$onepensyarah = $this->pensyarah_model->onepensyarah($oneajar->pensyarah);
		$jadual->namapensyarah = $onepensyarah->namapensyarah;

		$semakjadual = $this->session->flashdata('semakjadual');
		$oneajar = $this->ajar_model->oneajar($semakjadual->ajar);
		$semakjadual->kodkursus = $oneajar->kodkursus;
		$onebilik = $this->bilik_model->onebilik($semakjadual->bilik);
		$semakjadual->kodbilik = $onebilik->kodbilik;
		$masakelas = '';
		for ($masamula = $semakjadual->masamula; $masamula < ($semakjadual->tempoh + $semakjadual->masamula); $masamula++) {
			$masakelas .= masamasa($masamula) . ' / ';
		}
		$masakelas = substr($masakelas, 0, -3);
		$semakjadual->masakelas = $masakelas;
		$onepensyarah = $this->pensyarah_model->onepensyarah($oneajar->pensyarah);
		$semakjadual->namapensyarah = $onepensyarah->namapensyarah;

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'jadual' => $jadual,
			'semakjadual' => $semakjadual,
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/jadualbertindih', $data);
		$this->load->view('pensyarah/bawah');

	}

	public function deletejadual($idjadual)
	{
		$this->jadual_model->deletejadual($idjadual);
		redirect(base_url('pensyarah/jadual'));
	}

	public function statusjadual($status)
	{
		if ($status == 'siap') {
			$this->jadualsiap_model->addnew($this->idpensyarah);
		} else {
			$this->jadualsiap_model->deleteold($this->idpensyarah);
		}
		redirect(base_url('pensyarah/jadual'));
	}

	public function pengguna()
	{
		# pilih MK & bilik kuliah --> penggunabilik
		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'listtarikh' => $this->tarikh_model->listtarikh($this->idjabatan),
			'listbilik' => $this->bilik_model->listbilik($this->idjabatan),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/lihatpengguna', $data);
		$this->load->view('pensyarah/bawah');
		$this->load->view('pensyarah/lihatpengguna-script');
	}

	public function penggunabilik($mk, $bilik)
	{
		$seminggu = [];
		if ($mk > 0) {
			$gettarikh = $this->tarikh_model->gettarikh($this->idjabatan, $mk);
			$tarikh1 = new DateTime($gettarikh);
			$tarikh2 = new DateTime(tarikh7hari($gettarikh));
			$interval = new DateInterval('P1D');
			$liputan = new DatePeriod($tarikh1, $interval, $tarikh2);
			foreach ($liputan as $tarikh) {
				$seminggu[] = $tarikh->format('Y-m-d');
			}
		}

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'mk' => $mk,
			'seminggu' => $seminggu,
			'onebilik' => $this->bilik_model->onebilik($bilik),
			'onemkbilik' => $this->onemkbilik($this->idjabatan, $bilik, $mk),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/penggunabilik', $data);
		$this->load->view('pensyarah/bawah');
	}

	private function onemkbilik($idjabatan, $bilik, $mk)
	{
		$onemkbilik = $this->bilik_model->onemkbilik($idjabatan, $bilik, $mk);
		#echo '<pre>', print_r($onemkbilik); exit;
		$rows = [];
		foreach ($onemkbilik as $row) {
			for ($tempoh = 0; $tempoh < $row->tempoh; $tempoh++) {
				$rows[$row->hari][$row->masamula + $tempoh] = $row;
			}
		}
		return $rows;
	}

	public function maklumkan()
	{
		$listkekosongan = $this->kekosongan_model->listkekosongan($this->idpensyarah);
		$kekosongan = [];
		foreach ($listkekosongan as $row) {
			$gettarikh = $this->tarikh_model->gettarikh($this->idjabatan, $row->mk);
			$row->tarikh = tambahtarikh($gettarikh, $row->hari);
			$kekosongan[] = $row;
		}

		$atas['pensyarah'] = $this->pensyarah_model->onepensyarah($this->idpensyarah);
		$data = [
			'listkekosongan' => $kekosongan,
			'jadualindividu' => $this->jadual_model->jadualindividu($this->idpensyarah),
			'listtarikh' => $this->tarikh_model->listtarikh($this->idjabatan),
		];

		$this->load->view('pensyarah/atas', $atas);
		$this->load->view('pensyarah/maklumkan', $data);
		$this->load->view('pensyarah/bawah');
		$this->load->view('pensyarah/maklumkan-script');
	}

	public function savekekosongan()
	{
		$jenis = $this->input->post('jenis');
		if ($jenis == 'tarikh') {
			$tarikh1 = tarikh($this->input->post('tarikh1'));
			$tarikh2 = tarikh($this->input->post('tarikh2'));
			if ($tarikh1 > $tarikh2) {
				list($tarikh1, $tarikh2) = [$tarikh2, $tarikh1];
			}
			$tarikh1 = new DateTime($tarikh1);
			$tarikh2 = new DateTime($tarikh2);
			$interval = new DateInterval('P1D');
			$tarikh2 = $tarikh2->add($interval);
			$liputan = new DatePeriod($tarikh1, $interval, $tarikh2);
			foreach ($liputan as $tarikh) {
				$tarikh = $tarikh->format('Y-m-d');
				$tarikhisnin = isninkan($tarikh);
				$mk = $this->tarikh_model->getmk($this->idjabatan, $tarikhisnin);
				list($thn, $bln, $hb) = explode('-', $tarikh);
				$date = mktime(0, 0, 0, $bln, $hb, $thn);
				$hari = date('w', $date);
				$jadualsehari = $this->jadual_model->jadualsehari($this->idpensyarah, $hari);
				foreach ($jadualsehari as $jadual) {
					$kekosongan = [
						'jadual' => $jadual->idjadual,
						'mk' => $mk,
					];
					$this->kekosongan_model->savekekosongan($kekosongan);
				}
			}
		} elseif ($jenis == 'sehari') {
			$tarikh = $this->input->post('tarikh');
			$tarikhisnin = isninkan(tarikh($tarikh));
			$mk = $this->tarikh_model->getmk($this->idjabatan, $tarikhisnin);
			list($hb, $bln, $thn) = explode('-', $tarikh);
			$date = mktime(0, 0, 0, $bln, $hb, $thn);
			$hari = date('w', $date);
			$jadualsehari = $this->jadual_model->jadualsehari($this->idpensyarah, $hari);
			foreach ($jadualsehari as $jadual) {
				$kekosongan = [
					'jadual' => $jadual->idjadual,
					'mk' => $mk,
				];
				$this->kekosongan_model->savekekosongan($kekosongan);
			}
		} elseif ($jenis = 'waktu') {
			$kekosongan = [
				'jadual' => $this->input->post('idjadual'),
				'mk' => $this->input->post('mk'),
			];
			$this->kekosongan_model->savekekosongan($kekosongan);
		}
		redirect(base_url('pensyarah/maklumkan'));
	}

	public function deletekekosongan($idkekosongan)
	{
		$this->kekosongan_model->deletekekosongan($idkekosongan);
		redirect(base_url('pensyarah/maklumkan'));
	}
}
