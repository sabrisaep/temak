<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8"/>
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/light'); ?>/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/light'); ?>/assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Sistem Tempahan Bilik Kuliah Dan Makmal (TemBiKul)</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		  name='viewport'/>
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
	<!-- CSS Files -->
	<link href="<?php echo base_url('assets/light'); ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo base_url('assets/light'); ?>/assets/css/light-bootstrap-dashboard.css?v=2.0.0 "
		  rel="stylesheet"/>
	<!-- CSS Just for tembikul, contains image of students in BKJ1 -->
	<link href="<?php echo base_url('assets/'); ?>tembikul.css" rel="stylesheet"/>
</head>

<body>
<div class="wrapper">
	<div class="container">
				<h2 class="text-center text-white bg-primary p-sm-2 rounded">
					Sistem Tempahan Bilik Kuliah Dan Makmal
				</h2>
		<div class="row">
<!--			<div class="col-sm-1"></div>-->
			<div class="col-sm-3 mb-3">
				<div class="card h-100">
					<div class="card-header bg-info">
						<h4 class="card-title text-white text-center">Log Masuk</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('mukadepan/masuk'); ?>" method="post">
							<div class="form-group">
								<label for="idp">ID Pengguna</label>
								<input type="text" name="idp" id="idp" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="kata">Kata Laluan</label>
								<input type="password" name="kata" id="kata" class="form-control" required>
							</div>
							<button type="submit" class="btn btn-info btn-fill form-control">Masuk</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-9 mb-3">
				<div class="card h-100">
					<div class="card-header bg-info">
						<h4 class="card-title text-white text-center">Fungsi TemBiKul</h4>
					</div>
					<div class="card-body text-justify">
						<p>
							Sistem Tempahan Bilik Kuliah Dan Makmal (TemBiKul) ini digunakan semasa
							hendak membuat kelas ganti. Ia bermula dengan pentadbir sistem
							di peringkat jabatan masukkan senarai makmal dan bilik kuliah,
							status staf jabatan yang mengajar dan tarikh-tarikh minggu
							kuliah. Selepas itu, setiap pensyarah masukkan jadual wkatu
							masing-masing. Setelah semua itu selesai, barulah pensyarah
							boleh melihat kekosongan makmal dan bilik kuliah. Seterusnya
							membuat tempahan berdasarkan kekosongan tersebut. Selain
							daripada itu, pensyarah yang akan membatalkan kelasnya kerana
							bercuti, hadir mesyuarat ataupun berkursus, digalakkan
							memaklumkan kekosongan kelas tersebut agar boleh digunakan
							oleh pensyarah lain.
						</p>
						<p class="text-center">
							Untuk sebarang pertanyaan, sila hubungi
							Pizoh &amp; Hawa @ JTMK PTSS
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</div>
<!--   -->
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url('assets/light'); ?>/assets/js/core/jquery.3.2.1.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url('assets/light'); ?>/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('assets/light'); ?>/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?php echo base_url('assets/light'); ?>/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="<?php echo base_url('assets/light'); ?>/assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo base_url('assets/light'); ?>/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?php echo base_url('assets/light'); ?>/assets/js/light-bootstrap-dashboard.js?v=2.0.0 "
		type="text/javascript"></script>

</html>

<script>
	$(function () {
		$('#idp').focus();
	});
</script>

<?php
if ($this->session->flashdata('mesej')) {
	?>
	<script>
		alert('<?php echo $this->session->flashdata('mesej'); ?>');
	</script>
	<?php
}
