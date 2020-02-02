<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Senarai Staf Dan Status Mengajar</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<p>Klik pada status untuk tukar antara mengajar dan tidak mengajar</p>
			<table class="table">
				<tr>
					<th>Bil</th>
					<th>Nama</th>
					<th>Skim</th>
					<th>Status</th>
				</tr>
				<?php
				$bil = 1;
				foreach ($listpensyarah as $row) {
					?>
					<tr>
						<td><?php echo $bil++; ?></td>
						<td><?php echo $row->namapensyarah; ?></td>
						<td><?php echo $row->skim; ?></td>
						<td>
							<a href="<?php echo base_url('jabatan/statuspensyarah/' . $row->idpensyarah); ?>"><?php echo $row->status; ?></a>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>
</div>
