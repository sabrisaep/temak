<div class="card">
	<div class="card-header bg-info">
		<h4 class="card-title text-white">
			Jadual Waktu Bertindih
			<?php
			if ($jadual->bilik == $semakjadual->bilik) {
				echo '(waktu yang sama di bilik yang sama)';
			}
			if ($jadual->namapensyarah == $semakjadual->namapensyarah) {
				echo '(waktu yang sama telah anda masukkan sebelum ini)';
			}
			?>
		</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header bg-info">
						<h4 class="card-title text-white">Waktu Kelas Yang Anda Cuba Masukkan</h4>
					</div>
					<div class="card-body">
						<table class="table">
							<tr>
								<th>Kursus</th>
								<td><?php echo $jadual->kodkursus; ?></td>
							</tr>
							<tr>
								<th>Tempat</th>
								<td><?php echo $jadual->kodbilik; ?></td>
							</tr>
							<tr>
								<th>Hari</th>
								<td><?php echo namahari($jadual->hari); ?></td>
							</tr>
							<tr>
								<th>Masa</th>
								<td><?php echo $jadual->masakelas; ?></td>
							</tr>
							<tr>
								<th>Tempoh</th>
								<td><?php echo $jadual->tempoh; ?> jam</td>
							</tr>
							<tr>
								<th>Nama Pensyarah</th>
								<td><?php echo $jadual->namapensyarah; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header bg-info">
						<h4 class="card-title text-white">Waktu Kelas Sedia Ada</h4>
					</div>
					<div class="card-body">
						<table class="table">
							<tr>
								<th>Kursus</th>
								<td><?php echo $semakjadual->kodkursus; ?></td>
							</tr>
							<tr>
								<th>Tempat</th>
								<td><?php echo $semakjadual->kodbilik; ?></td>
							</tr>
							<tr>
								<th>Hari</th>
								<td><?php echo namahari($semakjadual->hari); ?></td>
							</tr>
							<tr>
								<th>Masa</th>
								<td><?php echo $semakjadual->masakelas; ?></td>
							</tr>
							<tr>
								<th>Tempoh</th>
								<td><?php echo $semakjadual->tempoh; ?> jam</td>
							</tr>
							<tr>
								<th>Nama Pensyarah</th>
								<td><?php echo $semakjadual->namapensyarah; ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<p>
			Sila klik pada
			<a href="<?php echo base_url('pensyarah/jadual'); ?>">Jadual Waktu</a>
			dan isi semula.
		</p>
	</div>
</div>
