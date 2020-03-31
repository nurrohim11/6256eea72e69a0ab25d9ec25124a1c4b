<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style type="text/css">
    @page {
        margin: 0;
    }
    * { padding: 0; margin: 0; }
    @font-face {
        font-family: "source_sans_proregular";           
        src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;

    }        
    body{
        font-family: "source_sans_proregular", Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
        padding: 200px;
        font-size: 40px
    }
    td.td-cellpadding {
	    padding: 4px;
	    font-size: 15px
	}
    td.td-detail {
	    padding: 2px;
	    text-align: center;
	}
	table.tb-center{
	    border-collapse:collapse;
	    padding:0;
	    margin: auto;
    	width: calc(100% - 40px);
	}
</style>
<body style="padding: 50px">
<?php 
	$k = $this->db->query("
		SELECT a.*,b.kode as kode_klasifikasi,b.deskripsi as bidang,c.kode as kode_sub_klasifikasi, d.kode as kode_kualifikasi, e.permohonan, (a.biaya+a.biaya_lpjkp+a.biaya_lpjkn) as t_biaya, b.deskripsi_lengkap
			from detail_klasifikasi a
			join ms_klasifikasi b
				on a.klasifikasi = b.id
			join ms_sub_klasifikasi c
				on c.id = a.sub_klasifikasi
			join ms_kualifikasi d
				on d.id = a.kualifikasi
			join ms_permohonan e
				on e.id = a.id_permohonan
			where a.token_klasifikasi = '$p->token_klasifikasi'
		")->result(); 
	?>

	<table style="width: 100%" cellpadding="7" cellspacing="0" border="0">
		<tr>
			<td style="text-align: center;width: 100%"><b style="font-size: 17px; text-align: center;">BERITA ACARA</b></td>
		</tr>
		<tr>
			<td style="text-align: center;width: 100%;padding-top: 4px"><b style="font-size: 17px; text-align: center;">RAPAT PENGURUS LPJK PROVINSI JAWA BARAT</b></td>
		</tr>
		<tr><td style="padding-top: 10px"></td></tr>
		<tr style="margin-top: 3px">
			<td style="text-align: center; margin-top: 100px">Tentang</td>
		</tr>
		<tr>
			<td style="text-align: center;padding-top: 4px"><b style="font-size: 17px; text-align: center; text-decoration: underline;">REGISTRASI TENAGA KERJA</b></td>
		</tr>
		<tr style="margin-top: 3px">
			<td style="text-align: center; padding-top: 4px">Nomor : <?php echo $p->nomor ?></td>
		</tr>
		<tr style="margin-top: 3px">
			<td style="text-align: center; padding-top: 4px">Tanggal : <?php echo date('d').' '.bulan(date('m')).' '.date('Y') ?></td>
		</tr>
	</table>
	<table class="tb-center" border="0">
		<tr><td style="width: 100%">&nbsp;</td></tr>
		<tr>
			<td style=" font-size: 15px;">
				<span>Pada hari ini <?php echo tanggal(date('w')) ?> tanggal <?php echo terbilang(date('d')) ?> bulan <?php echo bulan(date('m')) ?> tahun <?php echo terbilang(date('Y')) ?>, Pengurus Lembaga Pengembangan Jasa Kontruksi Provinsi Jawa Barat telah mengadakan rapat pemeriksaan terhadap Berita Acara dari Unit Sertifikasi Tenaga Kerja (USKT) tentang kelayakan Klasifikasi dan Kualifikasi permohonan registrasi tenaga kerja dari :</span>
			</td>
		</tr>
	</table>
	<table style="width: 100%" border="0" cellpadding="10">
		<tr><td>&nbsp;</td><td></td><td></td></tr>
		<tr>
			<td class="td-cellpadding" style="width: 40%">
				<b>Nama Tenaga Kerja</b>
			</td>
			<td class="td-cellpadding" style="width: 1px">
				<b>:</b>
			</td>
			<td class="td-cellpadding">
				<b><?php echo $p->nama ?></b>
			</td>
		</tr>
		<tr>
			<td class="td-cellpadding" style="width: 40%">
				<b>Alamat Badan Usaha</b>
			</td>
			<td class="td-cellpadding" style="width: 1px">
				<b>:</b>
			</td>
			<td class="td-cellpadding">
				<b><?php echo $p->alamat ?></b>
			</td>
		</tr>
		<tr>
			<td class="td-cellpadding" style="width: 40%">
				<b>Kabupaten / Kota</b>
			</td>
			<td class="td-cellpadding" style="width: 1px">
				<b>:</b>
			</td>
			<td class="td-cellpadding">
				<b><?php echo ucfirst(strtolower($p->ket_kota)) ?></b>
			</td>
		</tr>
		<tr>
			<td class="td-cellpadding" style="width: 40%">
				<b>No. KTP</b>
			</td>
			<td class="td-cellpadding" style="width: 1px">
				<b>:</b>
			</td>
			<td class="td-cellpadding">
				<b><?php echo $p->nik ?></b>
			</td>
		</tr>
	</table>

	<table style="width: 100%">
		<tr style="text-align: center;"><td style="width: 100%; font-size: 15px"><b>Menetapkan</b></td></tr>
		<tr style="text-align: left;"><td style="width: 100%;font-size: 15px">Sebagai Berikut</td></tr>
	</table>
	<table class="tb-center" style="width: 100%; margin-top: 2px; margin-bottom: 2px" border="1" cellspacing="0" >
		<tr>
			<th style="text-align: center; width: 5%; padding: 4px">No</th>
			<th style="text-align: center; width: 15%; padding: 4px">Bidang</th>
			<th style="text-align: center; width: 15%; padding: 4px">Kode</th>
			<th style="text-align: center; width: 15%; padding: 4px">Klasifikasi</th>
			<th style="text-align: center; width: 12%; padding: 4px">Kualifikasi</th>
			<th style="text-align: center; width: 11%; padding: 4px">Assosiasi</th>
			<th style="text-align: center; width: 15%; padding: 4px">Keterangan</th>
		</tr>
		<?php
		$no=0;
		foreach($k as $row){
			$no++;
		?>
		<tr>
			<td style="padding: 4px; text-align: center;"><?php echo $no; ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($row->bidang) ? $row->bidang : '' ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($row->kode_sub_klasifikasi) ? $row->kode_sub_klasifikasi : '' ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($row->deskripsi_lengkap) ? $row->deskripsi_lengkap : '' ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($row->kode_kualifikasi) ? $row->kode_kualifikasi : '' ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($p->assosiasi) ? $p->assosiasi : '' ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo ($row->permohonan) ? $row->permohonan : '' ?></td>
		</tr>
		<?php } ?>
	</table>

	<table style="width: 100%;margin-top: 20px; margin-bottom: 20px">
		<tr><td>Demikian Berita Acara ini dibuat untuk dipergunakan sebagai bahan proses penerbitan SBU lebih lanjut</td></tr>
	</table>

	<table style="width: 100%; margin-top: 2px; margin-bottom: 2px" border="1" cellspacing="0" >
		<tr>
			<th style="text-align: center; width: 5%; padding: 4px">No</th>
			<th style="text-align: center; width: 35%; padding: 4px">Nama</th>
			<th style="text-align: center; width: 35%; padding: 4px">Jabatan</th>
			<th style="text-align: center; width: 25%; padding: 4px">Tanda Tangan</th>
		</tr>
		<?php
		$query = $this->db->query("
			SELECT a.*,b.nama, c.jabatan FROM history_approval_skt a 
			join tb_user b 
				on b.id = a.id_user
			left join ms_jabatan c
				on c.id = b.id_jabatan
			where a.id_personal ='$p->id'
		")->result();
		$no=0;
		foreach($query as $r){
			$no++;
		?>
		<tr>
			<td style="padding: 4px; text-align: center;"><?php echo $no ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo $r->nama ?></td>
			<td style="padding: 4px; text-align: center;"><?php echo $r->jabatan ?></td>
			<?php 
			$ttd ='';
			if($r->ttd != ''){
				if (file_exists(base_url().'assets/uploads/ttd/'.$r->ttd)) {
					$ttd = base_url().'assets/uploads/ttd/'.$r->ttd;
				}else{
					$ttd = base_url().'assets/uploads/ttd/white.png';
				}
			}else{
				$ttd =base_url().'assets/uploads/ttd/white.png';
			}
			?>
			 <td style="padding: 4px; text-align: center;"><img style="width: 40px; height: auto;" src="<?php echo $ttd ?>"></td> 
		</tr>
		<?php } ?>
	</table>
</body>