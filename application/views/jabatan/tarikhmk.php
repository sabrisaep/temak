<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Tarikh-Tarikh Minggu Kuliah</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<?php
			if ($listtarikh) {
				?>
				<div class="col-sm-4">
					<table class="table">
						<tr>
							<th>MK</th>
							<th>Tarikh</th>
							<th>Hingga</th>
						</tr>
						<?php
						foreach ($listtarikh as $tarikh) {
							?>
							<tr>
								<td><?php echo $tarikh->mk; ?></td>
								<td><?php echo tarikh($tarikh->tarikh); ?></td>
								<td><?php echo tarikh(tarikh4hari($tarikh->tarikh)); ?></td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
				<?php
			}

			if ($bolehubah) {
				?>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-header bg-light">
							<h4 class="card-title text-secondary">Daftar Tarikh Minggu Kuliah</h4>
						</div>
						<div class="card-body">
							<form action="<?php echo base_url('jabatan/addnewmk'); ?>" method="post">
								<p class="text-secondary">(masukkan tarikh hari Isnin sahaja)</p>
								<div class="form-group">
									<label for="jumlahmk">Jumlah Minggu Kuliah</label>
									<input type="number" name="jumlahmk" id="jumlahmk" class="form-control" required
										   min="14" max="16" value="14">
								</div>
								<div class="form-group">
									<label for="mkpertama">Tarikh Minggu Kuliah Pertama</label>
									<input type="text" name="mkpertama" id="mkpertama"
										   class="form-control tarikh bg-white" required>
								</div>
								<div class="form-group">
									<label for="cutimidsem">Tarikh Cuti Pertengahan Semester</label>
									<input type="text" name="cutimidsem" id="cutimidsem"
										   class="form-control tarikh bg-white" required>
								</div>
								<div class="form-group">
									<label for="cutiraya">Tarikh Cuti Khas Perayaan (jika ada)</label>
									<input type="text" name="cutiraya" id="cutiraya"
										   class="form-control tarikh bg-white">
								</div>
								<div class="form-group">
									<label for="cutitambah">Tarikh Cuti Tambahan (jika ada)</label>
									<input type="text" name="cutitambah" id="cutitambah"
										   class="form-control tarikh bg-white">
								</div>
								<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
								<button type="reset" class="btn btn-danger btn-fill">Batal</button>
							</form>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
