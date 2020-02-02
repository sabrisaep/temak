<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Maklumkan Pengosongan Kelas</h4>
	</div>
	<div class="card-body">
		<p>
			Sekiranya anda membatalkan kelas kerana mesyuarat, menghadiri kursus/bengkel
			atau bercuti, maklumkan di sini supaya kelas tersebut dapat digunakan oleh
			pensyarah lain.
		</p>

		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header bg-info">
						<h4 class="card-title text-white">
							Kelas Dibatalkan Selama Beberapa Hari
						</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('pensyarah/savekekosongan'); ?>" method="post">
							<input type="hidden" name="jenis" value="tarikh">
							<div class="row">
								<div class="col-sm-4 form-group">
									<label for="tarikh1">Tarikh Mula</label>
									<input name="tarikh1" id="tarikh1" type="text" class="form-control tarikh bg-white" required>
								</div>
								<div class="col-sm-4 form-group">
									<label for="tarikh2">Tarikh Tamat</label>
									<input name="tarikh2" id="tarikh2" type="text" class="form-control tarikh bg-white" required>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary btn-fill mt-sm-4">Simpan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header bg-info">
						<h4 class="card-title text-white">
							Kelas Dibatalkan Untuk Satu Hari Sahaja
						</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('pensyarah/savekekosongan'); ?>" method="post">
							<input type="hidden" name="jenis" value="sehari">
							<div class="row">
								<div class="col-sm-4 form-group">
									<label for="tarikh">Tarikh</label>
									<input name="tarikh" id="tarikh" type="text" class="form-control tarikh bg-white" required>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-primary btn-fill mt-sm-4">Simpan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header bg-info">
				<h4 class="card-title text-white">
					Kelas Dibatalkan Untuk Satu Waktu Sahaja
				</h4>
			</div>
			<div class="card-body">
				<form action="<?php echo base_url('pensyarah/savekekosongan'); ?>" method="post">
					<input type="hidden" name="jenis" value="waktu">
					<div class="row">
						<div class="col-sm-8">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<th>Pilih</th>
										<th>Hari</th>
										<th>Masa</th>
										<th>Tempoh</th>
										<th>Kursus</th>
										<th>Tempat</th>
									</tr>
									<?php
									foreach ($jadualindividu as $row) {
										?>
										<tr>
											<td>
												<input type="radio" name="idjadual" id="idjadual<?php echo $row->idjadual; ?>" value="<?php echo $row->idjadual; ?>">
											</td>
											<td><label for="idjadual<?php echo $row->idjadual; ?>"><?php echo namahari($row->hari); ?></label></td>
											<td><label for="idjadual<?php echo $row->idjadual; ?>"><?php echo masamasa($row->masamula); ?></label></td>
											<td><label for="idjadual<?php echo $row->idjadual; ?>"><?php echo $row->tempoh; ?> jam</label></td>
											<td><label for="idjadual<?php echo $row->idjadual; ?>"><?php echo $row->kodkursus; ?></label></td>
											<td><label for="idjadual<?php echo $row->idjadual; ?>"><?php echo $row->kodbilik; ?></label></td>
										</tr>
										<?php
									}
									?>
								</table>
							</div>
						</div>
						<div class="col-sm-4">
							<label for="mk">Minggu Kuliah</label>
							<select name="mk" id="mk" class="form-control" required>
								<option value=""></option>
								<?php
								foreach ($listtarikh as $row) {
									echo "<option value=\"$row->mk\">MK$row->mk (" . tarikh($row->tarikh) . " - " . tarikh(tarikh4hari($row->tarikh)) . ")</option>";
								}
								?>
							</select>
							<button type="submit" class="btn btn-primary btn-fill pull-right mt-sm-3">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Senarai Kelas Yang Anda Batalkan</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Bil</th>
					<th>MK</th>
					<th>Tarikh</th>
					<th>Hari</th>
					<th>Masa</th>
					<th>Tempoh</th>
					<th>Kursus</th>
					<th>Tempat</th>
					<th>Tindakan</th>
				</tr>
				<?php
				$bil = 1;
				foreach ($listkekosongan as $row) {
					?>
					<tr>
						<td><?php echo $bil++; ?></td>
						<td>MK<?php echo $row->mk; ?></td>
						<td><?php echo tarikh($row->tarikh); ?></td>
						<td><?php echo namahari($row->hari); ?></td>
						<td><?php echo masamasa($row->masamula); ?></td>
						<td><?php echo $row->tempoh; ?> jam</td>
						<td><?php echo $row->kodkursus; ?></td>
						<td><?php echo $row->kodbilik; ?></td>
						<td>
							<a href="<?php echo base_url('pensyarah/deletekekosongan/' . $row->idkekosongan); ?>"
							   class="btn btn-warning btn-fill">Padam</a>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>
</div>
