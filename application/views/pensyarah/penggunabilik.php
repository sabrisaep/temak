<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Jadual Penggunaan <?php echo $onebilik->kodbilik; ?></h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th>MK<?php echo $mk; ?></th>
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
								if (isset($onemkbilik[$hari][$masa])) {
									echo $onemkbilik[$hari][$masa]->kodkursus . '<br>';
									echo substr($onemkbilik[$hari][$masa]->namapensyarah, 0, 7);
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
			<p>NOTA: [G] = kelas ganti</p>
		</div>
	</div>
</div>
