<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Tempah Bilik Kuliah/Makmal Yang Kosong</h4>
	</div>
	<div class="card-body">
		<p>Tempahan anda akan berjaya sekira tiada pensyarah lain yang melakukan tempahan serentak dengan anda.</p>

		<form action="<?php echo base_url('pensyarah/savetempah'); ?>" method="post">
			<input type="hidden" name="bilik" value="<?php echo $bilik->idbilik; ?>">
			<input type="hidden" name="tarikh" value="<?php echo $tarikh; ?>">
			<input type="hidden" name="masamula" value="<?php echo $masa; ?>">
			<div class="row">
				<div class="col-sm-2">
					<label for="tarikh">Tarikh</label>
					<input type="text" class="form-control" readonly value="<?php echo tarikh($tarikh); ?>" id="tarikh">
				</div>
				<div class="col-sm-2">
					<label for="makmal">Bilik/Makmal</label>
					<input type="text" class="form-control" readonly value="<?php echo $bilik->kodbilik; ?>" id="makmal">
				</div>
				<div class="col-sm-2">
					<label for="masa">Masa</label>
					<input type="text" class="form-control" readonly value="<?php echo masamasa($masa); ?>" id="masa">
				</div>
				<div class="col-sm-2">
					<label for="tempoh">Tempoh (jam)</label>
					<input type="number" class="form-control" required value="1" min="1" max="<?php echo $maxtempoh; ?>" name="tempoh" id="tempoh">
				</div>
				<div class="col-sm-2">
					<label for="ajar">Kod Kursus</label>
					<select name="ajar" id="ajar" class="form-control" required>
						<option value=""></option>
						<?php
						foreach ($listajar as $rowo) {
							echo "<option value=\"$rowo->idajar\">$rowo->kodkursus</option>";
						}
						?>
					</select>
				</div>
				<div class="col-sm-2">
					<button type="submit" class="btn btn-primary btn-fill mt-sm-4">Simpan</button>
				</div>
			</div>
		</form>

	</div>
</div>
