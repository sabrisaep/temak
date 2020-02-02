</div>
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
<script src="<?php echo base_url('assets/light'); ?>/assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

<?php
if ($this->session->flashdata('mesej')) {
	?>
	<script>
		alert('<?php echo $this->session->flashdata('mesej'); ?>');
	</script>
	<?php
}
?>

<script>
	$(function () {
		$("a:contains('Padam')").click(function () {
			return confirm('Adakah anda pasti?');
		});
	});
</script>

</html>
