<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Lihat Pengguna Bilik Dalam MK Tertentu</h4>
	</div>
	<div class="card-body">
		<label>Sila Pilih Bilik Kuliah/Makmal</label>
		<div class="row">
			<?php
			foreach ($listbilik as $row) {
				?>
				<div class="col-sm-1 form-check">
					<label class="form-check-label">
						<input value="<?php echo $row->idbilik; ?>" type="radio" name="bilik" class="form-check-input">
						<?php echo $row->kodbilik; ?>
					</label>
				</div>
				<?php
			}
			?>
		</div>

		<label for="">Sila Pilih Minggu Kuliah</label>
		<div class="row">
			<?php
			foreach ($listtarikh as $row) {
				?>
				<div class="col-sm-2 form-check">
					<div class="border border-info rounded text-center">
					<label class="form-check-label">
						<input value="<?php echo $row->mk; ?>" type="radio" name="mk" class="form-check-input">
						MK<?php echo $row->mk; ?>
					<br>
					<?php echo tarikh($row->tarikh) . '<br>' . tarikh(tarikh4hari($row->tarikh)); ?>
					</label>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<button type="button" class="btn btn-primary btn-fill" id="papar">Papar</button>
	</div>
</div>
