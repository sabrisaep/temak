<script>
	$(function () {
		$('#papar').click(function () {
			let bilik = $("input[name='bilik']:checked").val();
			let mk = $("input[name='mk']:checked").val();
			if (bilik === undefined) {
				alert('Sila pilih bilik kuliah/makmal');
			} else if (mk === undefined) {
				alert('Sila pilih minggu kuliah');
			} else {
				window.location = '<?php echo base_url('pensyarah/penggunabilik/'); ?>' + mk + '/' + bilik;
			}
		});
	});
</script>
