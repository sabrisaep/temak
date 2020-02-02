<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Jadual Waktu Pensyarah</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Bil</th>
					<th>Nama Pensyarah</th>
					<th>Status</th>
					<th>Papar</th>
				</tr>
				<?php
				$bil = 1;
				foreach ($listpensyarah as $row) {
					if ($row->status == 'Mengajar') {
						?>
						<tr>
							<td><?php echo $bil++; ?></td>
							<td><?php echo $row->namapensyarah; ?></td>
							<td><?php echo $row->jadual; ?></td>
							<td>
								<?php
								if ($row->jadual == 'Siap') {
									?>
									<a href="<?php echo base_url('jabatan/jadualindividu/' . $row->idpensyarah); ?>" class="btn btn-primary btn-fill">Jadual</a>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
		</div>
	</div>
</div>
