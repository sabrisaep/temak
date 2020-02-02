<div class="card">
	<div class="card-header bg-info">
		<div class="row">
			<div class="col-sm-6">
				<h4 class="card-title text-white">
					Lihat Bilik/Makmal Kosong Dan Tempah
				</h4>
			</div>
			<div class="col-sm-6 text-right">
				<form class="form-inline pull-right mb-sm-1" action="<?php echo base_url('pensyarah/tempah'); ?>"
					  method="post">
					<select name="mk" id="mk" class="form-control">
						<option value=""></option>
						<?php
						foreach ($listtarikh as $row) {
							$text = 'MK' . $row->mk . ' (' . tarikh($row->tarikh) . ' - ' . tarikh(tarikh4hari($row->tarikh)) . ')';
							echo "<option value=\"$row->mk\">$text</option>";
						}
						?>
					</select>
				</form>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?php
		if ($mk != 0) {
			?>
			<div class="table-responsive">
				<table class="table">
					<?php
					for ($hari = 1; $hari < 6; $hari++) {
						?>
						<tr>
							<th>MK<?php echo $mk; ?></th>
							<?php
							for ($masa = 1; $masa < 11; $masa++) {
								echo '<th>' . masamasa($masa) . '</th>';
							}
							?>
						</tr>
						<tr>
							<th>
								<?php
								echo namahari($hari) . '<br>';
								echo tarikh($seminggu[$hari - 1]);
								?>
							</th>
							<?php
							for ($masa = 1; $masa < 10; $masa++) {
								?>
								<td>
									<?php
									if (!isset($waktumengajar[$hari][$masa])) {
										foreach ($bilikkosong[$hari][$masa] as $bilik) {
											?>
											<a href="<?php echo base_url("pensyarah/menempah/$mk/$hari/$masa/$bilik"); ?>"><?php echo $bilik; ?></a>
											<br>
											<?php
										}
									}
									?>
								</td>
								<?php
							}
							?>
							<td></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
			<?php
		}
		?>
	</div>
</div>

<div class="card">
	<div class="card-header bg-info">
		<div class="row">
			<h4 class="card-title text-white">
				Senarai Tempahan Yang Anda Pernah Buat
			</h4>
		</div>
	</div>
	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th>Tarikh</th>
						<th>Masa</th>
						<th>Tempoh</th>
						<th>Tempat</th>
						<th>Kursus</th>
						<th>Tindakan</th>
					</tr>
					<?php
					foreach ($tempahanpensyarah as $row) {
						?>
						<tr>
							<td><?php echo tarikh($row->tarikh); ?></td>
							<td><?php echo masamasa($row->masamula); ?></td>
							<td><?php echo $row->tempoh; ?> jam</td>
							<td><?php echo $row->kodbilik; ?></td>
							<td><?php echo $row->kodkursus; ?></td>
							<td><a href="<?php echo base_url('pensyarah/deletetempah/' . $row->idtempah); ?>" class="btn btn-warning btn-fill">Padam</a></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
	</div>
</div>
