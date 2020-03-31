<div style="text-align: center;">
	<h2>Daftar Rekomendasi</h2>
</div>
<table>
	<tr>
		<td style="width: 150px">No. Invoice</td>
		<td>:</td>
		<td><?php echo $p->no_invoice ?></td>
	</tr>
	<tr>
		<td>Tanggal dan Waktu</td>
		<td>:</td>
		<td><?php echo date('d F Y H:i:s') ?></td>
	</tr>
	<tr><td colspan="3">&nbsp;</td></tr>
	<table border="1" cellpadding="4" cellspacing="0" style="width: 100%">
		<tr>
			<td style="width: 2px">No.</td>
			<td>NIK</td>
			<td>Nama</td>
			<td>Sub Klasifikasi</td>
			<td>Kualifikasi</td>
			<td>Assosiasi</td>
			<td>Jenis</td>
			<td>Keterangan</td>
		</tr>
		<!-- http://localhost/project/pengajuan/permohonan/generate_pdf -->
		<?php
		$bu = $this->db->query("SELECT a.*, c.tipe_permohonan FROM tb_personal a join tb_permohonan b on b.token_permohonan = a.token_permohonan join ms_tipe_permohonan c on c.kode = b.type  where a.token_permohonan ='$p->token_permohonan'")->result();
		$no=0;
		foreach($bu as $row){
			$no++;
			$k = $this->db->query("
				SELECT a.*,b.kode as kode_klasifikasi,c.kode as kode_sub_klasifikasi, d.kode as kode_kualifikasi, e.permohonan, f.permohonan as ket,
		          	(a.biaya+a.biaya_lpjkp+a.biaya_lpjkn) as t_biaya
					from detail_klasifikasi a
					join ms_klasifikasi b
						on a.klasifikasi = b.id
					join ms_sub_klasifikasi c
						on c.id = a.sub_klasifikasi
					join ms_kualifikasi d
						on d.id = a.kualifikasi
					join ms_permohonan e
						on e.id = a.id_permohonan
					left join ms_permohonan f
						on f.id = a.id_permohonan
					where a.token_klasifikasi = '$row->token_klasifikasi'
				")->result();
		?>
		<tr>
			<td valign="top"><?php echo $no ?></td>
			<td valign="top"><?php echo $row->nik ?></td>
			<td valign="top"><?php echo $row->nama ?></td>
			<td valign="top">
				<table>
					<?php foreach($k as $val){ ?>
					<tr><td><?php echo $val->kode_sub_klasifikasi ?></td></tr>
					<?php } ?>
				</table>
			</td>
			<td valign="top">
				<table>
					<?php foreach($k as $val){ ?>
					<tr><td><?php echo $val->kode_kualifikasi ?></td></tr>
					<?php } ?>
				</table>
			</td>
			<td valign="top">
				<table>
					<?php foreach($k as $val){ ?>
					<tr><td><?php echo $ass->assosiasi ?></td></tr>
					<?php } ?>
				</table>
			</td>
			<td valign="top"><?php echo $row->tipe_permohonan ?></td>
			<td valign="top">
				<table>
					<?php foreach($k as $val){ ?>
					<tr><td><?php echo $val->ket ?></td></tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<?php } ?>
	</table>
</table>
<table cellspacing="0" style="margin-top: 30px; width: 100%">
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">&nbsp;
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">&nbsp;
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">Badan Pelaksana
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">Lembaga Pengembangan	Jasa Konstruksi
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">Provinsi Jawa Barat
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3"><p></p>
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3"><p></p>
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3"><p></p>
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3"><b style="text-decoration: underline;">M. Taufik, BE</b>
		<td style="width: 25%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width: 25%; text-align: center;" colspan="3">Manajer Eksekutif
		<td style="width: 25%">&nbsp;</td>
	</tr>
</table>