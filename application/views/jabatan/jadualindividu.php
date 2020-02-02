<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">Jadual Waktu <?php echo $onepensyarah->namapensyarah; ?></h4>
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
									echo $jadual[$hari][$masa]['kodkursus'];
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
		</div>
	</div>
</div>
