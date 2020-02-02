<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Senarai Bilik Kuliah Dan Makmal</h4>
	</div>
	<div class="card-body">

		<div class="row">
			<div class="col-sm-6">
				<table class="table">
					<tr>
						<th>Bil</th>
						<th>Kod Bilik</th>
						<th>Tindakan</th>
					</tr>
					<?php
					$bil = 1;
					foreach ($bilik as $row) {
						?>
						<tr>
							<td><?php echo $bil++; ?></td>
							<td><?php echo $row->kodbilik; ?></td>
							<td>
								<a href="<?php echo base_url('jabatan/editbilik/'.$row->idbilik); ?>" class="btn btn-primary btn-fill">Edit</a>
								<a href="<?php echo base_url('jabatan/deletebilik/'.$row->idbilik); ?>" class="btn btn-warning btn-fill">Padam</a>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<div class="col-sm-6">
				<?php
				if (!isset($onebilik)) {
					?>
					<div class="card">
						<div class="card-header bg-light">
							<h4 class="card-title text-secondary">Daftar Bilik Baru</h4>
						</div>
						<div class="card-body">
							<form action="<?php echo base_url('jabatan/savebilik'); ?>" method="post">
								<input type="hidden" name="idbilik" value="0">
								<div class="row">
									<div class="col-sm-3 text-right">
										<label class="form-control-plaintext" for="kodbilik">Kod Bilik</label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="kodbilik" id="kodbilik" required>
									</div>
									<div class="col-sm-5">
										<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
										<a href="<?php echo base_url('jabatan/bilik'); ?>" class="btn btn-danger btn-fill">Batal</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="card">
						<div class="card-header bg-light">
							<h4 class="card-title text-secondary">Edit Kod Bilik</h4>
						</div>
						<div class="card-body">
							<form action="<?php echo base_url('jabatan/savebilik'); ?>" method="post">
								<input type="hidden" name="idbilik" value="<?php echo $onebilik->idbilik; ?>">
								<div class="row">
									<div class="col-sm-3 text-right">
										<label class="form-control-plaintext" for="kodbilik">Kod Bilik</label>
									</div>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="kodbilik" id="kodbilik" required value="<?php echo $onebilik->kodbilik; ?>">
									</div>
									<div class="col-sm-5">
										<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
										<a href="<?php echo base_url('jabatan/bilik'); ?>" class="btn btn-danger btn-fill">Batal</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>

	</div>
</div>
