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
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
	<!-- CSS Files -->
	<link href="<?php echo base_url('assets/light'); ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo base_url('assets/light'); ?>/assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet"/>

	<link rel="stylesheet" href="<?php echo base_url('assets/zebra/zebra_datepicker.min.css'); ?>">

</head>

<body>
<div class="wrapper">
	<div class="sidebar" data-image="<?php echo base_url('assets/light'); ?>/assets/img/sidebar-5.jpg" data-color="purple">
		<!--
	Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

	Tip 2: you can also add an image using data-image tag
-->
		<div class="sidebar-wrapper">
			<div class="logo">
				<a href="." class="simple-text">
					TemBiKul
				</a>
			</div>
			<ul class="nav">
				<li>
					<a class="nav-link" href="<?php echo base_url('pensyarah/tempah'); ?>">
						<i class="nc-icon nc-cart-simple"></i>
						<p>Tempah Bilik</p>
					</a>
				</li>
				<li>
					<a class="nav-link" href="<?php echo base_url('pensyarah/jadual'); ?>">
						<i class="nc-icon nc-notes"></i>
						<p>Jadual Waktu</p>
					</a>
				</li>
				<li>
					<a class="nav-link" href="<?php echo base_url('pensyarah/pengguna'); ?>">
						<i class="nc-icon nc-tablet-2"></i>
						<p>Pengguna Bilik</p>
					</a>
				</li>
				<li>
					<a class="nav-link" href="<?php echo base_url('pensyarah/maklumkan'); ?>">
						<i class="nc-icon nc-chat-round"></i>
						<p>Maklumkan</p>
					</a>
				</li>
				<li>
					<a class="nav-link" href="<?php echo base_url('mukadepan/keluar'); ?>">
						<i class="nc-icon nc-button-power"></i>
						<p>Keluar</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="main-panel">
		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg" color-on-scroll="500">
			<div class="container-fluid">
				<?php echo $pensyarah->namapensyarah; ?>
				<button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
						aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-bar burger-lines"></span>
					<span class="navbar-toggler-bar burger-lines"></span>
					<span class="navbar-toggler-bar burger-lines"></span>
				</button>
			</div>
		</nav>
		<!-- End Navbar -->
		<div class="content">
			<div class="container-fluid">
