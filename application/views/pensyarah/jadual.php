<div class="card">
	<div class="card-header bg-info">
		<div class="row">
			<div class="col-sm-6">
				<h4 class="card-title text-white">Jadual Waktu Anda</h4>
			</div>
			<div class="col-sm-6 text-right">
				<h4 class="card-title text-white">Status: <?php echo $status; ?></h4>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th></th>
					<?php
					for ($masa = 1; $masa < 12; $masa++) {
						echo '<th>' . masamasa($masa) . '</th>';
					}
					?>
				</tr>
				<?php
				for ($hari = 1; $hari < 6; $hari++) {
					?>
					<tr>
						<th><?php echo namahari($hari); ?></th>
						<?php
						for ($masa = 1; $masa < 12; $masa++) {
							?>
							<td>
								<?php
								if (isset($jadual[$hari][$masa])) {
									echo $jadual[$hari][$masa]['kodbilik'], '<br>';
									echo $jadual[$hari][$masa]['kodkursus'], '<br>';
									if ($status != 'Siap') {
										?>
										<a href="<?php echo base_url('pensyarah/deletejadual/' . $jadual[$hari][$masa]['idjadual']); ?>">Padam</a>
										<?php
									}
								}
								?>
							</td>
							<?php
						}
						?>
					</tr>
					<?php
				}
				?>
			</table>

			<div class="row">
				<div class="col-sm-10">
					<?php
					if ($status != 'Siap') {
						?>
						<div class="card">
							<div class="card-header bg-info">
								<h4 class="card-title text-white">Tambah Waktu Kelas</h4>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url('pensyarah/savejadual'); ?>" method="post">
									<div class="row">
										<div class="col-sm-2">
											<label for="kursus">Kursus</label>
											<select name="kursus" id="kursus" class="form-control" required>
												<option value=""></option>
												<?php
												foreach ($kursus as $rowo) {
													echo "<option value=\"$rowo->idkursus\">$rowo->kodkursus</option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label for="bilik">Tempat</label>
											<select name="bilik" id="bilik" class="form-control" required>
												<option value=""></option>
												<?php
												foreach ($bilik as $rowo) {
													echo "<option value=\"$rowo->idbilik\">$rowo->kodbilik</option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label for="hari">Hari</label>
											<select name="hari" id="hari" required class="form-control">
												<option value=""></option>
												<?php
												for ($hari = 1; $hari <= 5; $hari++) {
													echo '<option value="' . $hari . '">' . namahari($hari) . '</option>';
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label for="masamula">Masa</label>
											<select name="masamula" id="masamula" required class="form-control">
												<option value=""></option>
												<?php
												for ($masa = 1; $masa < 12; $masa++) {
													echo '<option value="' . $masa . '">' . masamasa($masa) . '</option>';
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label for="tempoh">Tempoh (jam)</label>
											<input type="number" name="tempoh" id="tempoh" required value="1" min="1"
												   class="form-control">
										</div>
										<div class="col-sm-2">
											<button type="submit" class="btn btn-primary btn-fill mt-sm-3">Simpan
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="col-sm-2">
					<div class="card">
						<div class="card-header bg-info">
							<h4 class="card-title text-white">Status</h4>
						</div>
						<div class="card-body">
							<?php
							if ($status == 'Belum Siap') {
								?>
								Jika ingin ubah status kepada Siap, klik butang berikut;
								<p><a href="<?php echo base_url('pensyarah/statusjadual/siap'); ?>"
									  class="btn btn-primary btn-fill">Siap</a></p>
								<?php
							} else {
								?>
								Jika ingin ubah status kepada Belum Siap, klik butang berikut;
								<p><a href="<?php echo base_url('pensyarah/statusjadual/belum'); ?>"
									  class="btn btn-primary btn-fill">Belum Siap</a></p>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
