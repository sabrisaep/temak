<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('hariisnin')) {
	function hariisnin($tarikh)
	{
		if ($tarikh == '') {
			return false;
		} else {
			list($thn, $bln, $hb) = explode('-', $tarikh);
			$tarikh = mktime(0, 0, 0, $bln, $hb, $thn);
			$hari = date('w', $tarikh);
			return ($hari == 1);
		}
	}
}

if (!function_exists('tarikh')) {
	function tarikh($tarikh)
	{
		if ($tarikh == '') {
			return '';
		} else {
			list($thn, $bln, $hb) = explode('-', $tarikh);
			return "$hb-$bln-$thn";
		}
	}
}

if (!function_exists('tarikh7hari')) {
	function tarikh7hari($tarikh)
	{
		$tarikh = date_create($tarikh);
		date_add($tarikh, date_interval_create_from_date_string("7 days"));
		return date_format($tarikh, 'Y-m-d');
	}
}

if (!function_exists('tarikh4hari')) {
	function tarikh4hari($tarikh)
	{
		$tarikh = date_create($tarikh);
		date_add($tarikh, date_interval_create_from_date_string("4 days"));
		return date_format($tarikh, 'Y-m-d');
	}
}

if (!function_exists('namahari')) {
	function namahari($bil)
	{
		$nama = ['AHAD', 'ISNIN', 'SELASA', 'RABU', 'KHAMIS', 'JUMAAT', 'SABTU'];
		return $nama[$bil];
	}
}

if (!function_exists('isninkan')) {
	function isninkan($tarikh)
	{
		list($thn, $bln, $hb) = explode('-', $tarikh);
		$tarikh = mktime(0, 0, 0, $bln, $hb, $thn);
		$hari = date('w', $tarikh);
		if ($hari < 1) {
			$beza = 1;
		} elseif ($hari > 1) {
			$beza = ($hari - 1) * -1;
		} else {
			$beza = 0;
		}

		$tarikh = date_create("$thn-$bln-$hb");
		date_add($tarikh, date_interval_create_from_date_string("$beza days"));
		return date_format($tarikh, 'Y-m-d');
	}
}

if (!function_exists('masamasa')) {
	function masamasa($masa)
	{
		$namamasa = ['7-8', '8-9', '9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5', '5-6', '6-7'];
		return $namamasa[$masa];
	}
}

if (!function_exists('dapatkanhari')) {
	function dapatkanhari($tarikh)
	{
		list($thn, $bln, $hb) = explode('-', $tarikh);
		$hari = date('w', mktime(0, 0, 0, $bln, $hb, $thn));
		return $hari;
	}
}

if (!function_exists('tambahtarikh')) {
	function tambahtarikh($tarikh, $hari)
	{
		$hari--;
		list($thn, $bln, $hb) = explode('-', $tarikh);
		$tarikh = date_create("$thn-$bln-$hb");
		date_add($tarikh, date_interval_create_from_date_string("$hari days"));
		return date_format($tarikh, 'Y-m-d');
	}
}
