<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Senarai Pensyarah Yang Belum Isi Jadual Waktu</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>Bil</th>
					<th>Nama</th>
					<th>Status</th>
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
						</tr>
						<?php
					}
				}
				?>
			</table>
		</div>
	</div>
</div>
