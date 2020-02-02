<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Senarai Kursus</h4>
	</div>
	<div class="card-body">

		<?php
		if (!isset($onekursus)) {
			?>
			<div class="card">
				<div class="card-header bg-light">
					<h4 class="card-title text-secondary">Daftar Kursus Baru</h4>
				</div>
				<div class="card-body">
					<form action="<?php echo base_url('jabatan/savekursus'); ?>" method="post">
						<input type="hidden" name="idkursus" value="0">
						<div class="row">
							<div class="col-sm-2">
								<label class="form-control-plaintext" for="kodkursus">Kod kursus</label>
								<input type="text" class="form-control" name="kodkursus" id="kodkursus" required>
							</div>
							<div class="col-sm-7">
								<label class="form-control-plaintext" for="namakursus">Nama kursus</label>
								<input type="text" class="form-control" name="namakursus" id="namakursus" required>
							</div>
							<div class="col-sm-3 mt-sm-3">
								<div class="mt-sm-3">
									<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
									<a href="<?php echo base_url('jabatan/kursus'); ?>" class="btn btn-danger btn-fill">Batal</a>
								</div>
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
					<h4 class="card-title text-secondary">Daftar Kursus Baru</h4>
				</div>
				<div class="card-body">
					<form action="<?php echo base_url('jabatan/savekursus'); ?>" method="post">
						<input type="hidden" name="idkursus" value="<?php echo $onekursus->idkursus; ?>">
						<div class="row">
							<div class="col-sm-2">
								<label class="form-control-plaintext" for="kodkursus">Kod kursus</label>
								<input type="text" class="form-control" name="kodkursus" id="kodkursus" required value="<?php echo $onekursus->kodkursus; ?>">
							</div>
							<div class="col-sm-7">
								<label class="form-control-plaintext" for="namakursus">Nama kursus</label>
								<input type="text" class="form-control" name="namakursus" id="namakursus" required value="<?php echo $onekursus->namakursus; ?>">
							</div>
							<div class="col-sm-3 mt-sm-3">
								<div class="mt-sm-3">
									<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
									<a href="<?php echo base_url('jabatan/kursus'); ?>" class="btn btn-danger btn-fill">Batal</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php
			# =X8
			?>
			<div class="card">
				<div class="card-header bg-light">
					<h4 class="card-title text-secondary">Edit Kursus</h4>
				</div>
				<div class="card-body">
					<form action="<?php echo base_url('jabatan/savekursus'); ?>" method="post">
						<input type="hidden" name="idkursus" value="<?php echo $onekursus->idkursus; ?>">
						<div class="row">
							<div class="col-sm-3 text-right">
								<label class="form-control-plaintext" for="kodkursus">Kod kursus</label>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="kodkursus" id="kodkursus" required
									  >
							</div>
							<div class="col-sm-5">
								<button type="submit" class="btn btn-primary btn-fill">Simpan</button>
								<a href="<?php echo base_url('jabatan/kursus'); ?>" class="btn btn-danger btn-fill">Batal</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?php
		}
		?>

		<table class="table">
			<tr>
				<th>Bil</th>
				<th>Kod Kursus</th>
				<th>Nama Kursus</th>
				<th>Tindakan</th>
			</tr>
			<?php
			$bil = 1;
			foreach ($kursus as $row) {
				?>
				<tr>
					<td><?php echo $bil++; ?></td>
					<td><?php echo $row->kodkursus; ?></td>
					<td><?php echo $row->namakursus; ?></td>
					<td>
						<a href="<?php echo base_url('jabatan/editkursus/' . $row->idkursus); ?>"
						   class="btn btn-primary btn-fill">Edit</a>
						<a href="<?php echo base_url('jabatan/deletekursus/' . $row->idkursus); ?>"
						   class="btn btn-warning btn-fill">Padam</a>
					</td>
				</tr>
				<?php
			}
			?>
		</table>

	</div>
</div>
