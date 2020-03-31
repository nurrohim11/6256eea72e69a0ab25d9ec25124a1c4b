<?php
$lpjkp = 0;
$lpjkn =0; ?>
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
	<table style="width: 100%" cellpadding="7" cellspacing="0" border="0">
		<tr>
			<td rowspan="4" style="width: 20%;"><img style="width: 70%" src="<?php echo base_url() ?>assets/apps/img/logo_lpjk.png"></td>
			<td style="text-align: center;width: 80%"><b style="font-size: 20px; text-align: center;">INVOICE</b></td>
		</tr>
		<tr>
			<td style="text-align: center;width: 80%;padding-top: 4px"><font style="font-size: 15px; text-align: center;">LEMBAGA PENGEMBANGAN JASA KONTRUKSI</font></td>
		</tr>
		<tr>
			<td style="text-align: center;width: 80%;padding-top: 4px"><font style="font-size: 15px; text-align: center;">PROVINSI JAWA BARAT</font></td>
		</tr>
		<tr><td style="padding-top: 10px"></td></tr>
	</table>

	<table style="width: 100%" cellpadding="7" cellspacing="0" border="0">
		<tr>
			<td style="width: 20%;padding-top: 3px;padding-bottom: 3px"><font style="font-size: 14px">No. Invoice</font></td>
			<td style="width: 2%"><font style="font-size: 14px">:</font></td>
			<td style="width: 29%"><font style="font-size: 14px"><?php echo $p->no_invoice ?></font></td>
		</tr>
		<tr>
			<td style="width: 15%;padding-top: 3px;padding-bottom: 3px"><font style="font-size: 14px">Assosiasi</font></td>
			<td>:</td>
			<td><?php echo $p->asosiasi ?></td>
		</tr>
		<tr>
			<td style="width: 15%;padding-top: 3px;padding-bottom: 3px"><font style="font-size: 14px">Tgl Masuk</font></td>
			<td>:</td>
			<td><?php echo tgl_indo($p->tgl_masuk) ?></td>
		</tr>
		<tr>
			<td style="width: 15%;padding-top: 3px;padding-bottom: 3px"><font style="font-size: 14px">Tgl Bayar</font></td>
			<td>:</td>
			<td><?php echo tgl_indo($p->tgl_bayar) ?></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
	</table>


	<table style="width: 100%" cellpadding="7" cellspacing="0" border="0">
		<tr>
			<td style="width: 100%;padding-top: 4px;padding-bottom: 4px" colspan="7"><font style="font-size: 14px">Rincian Permohonan</font></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>

	<table style="width: 100%" cellpadding="7" cellspacing="0" border="1">
		<tr style="background: #ffff24">
			<td style="width: 4%;padding-left: 4px;padding-right: 4px; padding-top: 4px;padding-bottom: 4px">No.</td>
			<td style="width: 19%;padding-left: 4px; padding-right: 4px;">NIK</td>
			<td style="width: 15%;padding-left: 4px; padding-right: 4px; ">Nama</td>
			<td style="width: 12%;padding-left: 4px; padding-right: 4px; ">Kota</td>
			<td style="width: 18%;padding-left: 4px; padding-right: 4px; ">Alamat</td>
			<td style="width: 15%;padding-left: 4px; padding-right: 4px; ">Gender</td>
			<td style="width: 15%;padding-left: 4px; padding-right: 4px; ">Asosiasi</td>
		</tr>
		<?php $no=0;
		foreach($personal as $row){
			$no++;
			$token =$row['token_klasifikasi'];
			?>
		<tr>
			<td  style="width: 4%;padding-left: 4px; padding-right: 4px; padding-top: 4px;">
				<?php echo $no ?>
			</td>
			<td style="width: 19%;padding-left: 4px; padding-right: 4px; padding-top: 4px;">
				<?php echo $row['nik'] ?>
			</td>
			<td style="width: 15%;padding-left: 4px; padding-right: 4px; padding-top: 4px; ">
				<?php echo $row['nama'] ?>
			</td>
			<td style="width: 12%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px">
				<?php echo ucwords(strtolower($row['kota'])) ?>
			</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px; ">
				<?php echo $row['alamat'] ?>
			</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px; padding-top: 4px;  padding-bottom: 4px;">
				<?php echo $row['gender'] ?>
			</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px; padding-top: 4px;  padding-bottom: 4px;">
				<?php echo ucwords(ucfirst(strtolower($row['asosiasi']))) ?>
			</td>
		</tr>
		<tr style="">
			<td  style="width: 4%;padding-left: 4px;padding-right: 4px; padding-top: 4px;padding-bottom: 4px">&nbsp;</td>
			<td style="width: 19%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;background: #ffff24">Klasifikasi</td>
			<td style="width: 15%;padding-left: 4px;  padding-top: 4px; padding-bottom: 4px;background: #ffff24">Sub Klasifikasi</td>
			<td style="width: 12%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;background: #ffff24 ">Kualifikasi</td>
			<td  style="width: 18%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;background: #ffff24">Permohonan</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;background: #ffff24">Biaya LPJKP</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;background: #ffff24">Biaya LPJKN</td>
		</tr>
		
		<?php 

		$detail = $this->db->query("
				SELECT a.token_klasifikasi,b.kode as kode_klasifikasi, 
					c.kode as kode_sub_klasifikasi, d.kode as kode_kualifikasi, e.permohonan, 
					a.biaya_lpjkn, a.biaya_lpjkp 
					from detail_klasifikasi a
					join ms_klasifikasi b
						on b.id = a.klasifikasi
					join ms_sub_klasifikasi c
						on c.id = a.sub_klasifikasi
					join ms_kualifikasi d
						on d.id = a.kualifikasi
					join ms_permohonan e
						on e.id = a.id_permohonan
					where a.token_klasifikasi ='$token'
				")->result();
		foreach($detail as $ro){ 
			$lpjkp += $ro->biaya_lpjkp;
			$lpjkn += $ro->biaya_lpjkn;
			?>

			<tr style="">
				<td  style="width: 4%;padding-left: 4px;padding-right: 4px; padding-top: 4px;padding-bottom: 4px">&nbsp;</td>
				<td style="width: 19%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;"><?php echo $ro->kode_klasifikasi ?></td>
				<td style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;"><?php echo $ro->kode_sub_klasifikasi ?></td>
				<td style="width: 12%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px; "><?php echo $ro->kode_kualifikasi ?></td>
				<td  style="width: 18%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;"><?php echo $ro->permohonan ?></td>
				<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;"><?php echo money($ro->biaya_lpjkp) ?></td>
				<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;"><?php echo money($ro->biaya_lpjkn) ?></td>
			</tr>
		<?php } ?>
		<tr style="">
			<td  style="width: 4%;padding-left: 4px;padding-right: 4px; padding-top: 4px;padding-bottom: 4px">&nbsp;</td>
			<td colspan="3" style="width: auto;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;background: #ffff24">Biaya Pengembangan Jasa Kontruksi</td>
			<td  style="width: 18%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;background: #ffff24">&nbsp;</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;background: #ffff24">Biaya LPJKP</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;background: #ffff24">Biaya LPJKN</td>
		</tr>
		<?php 
		$p = $this->db->query("
			SELECT a.*,b.kode from tb_biaya_pengembangan a
				join ms_klasifikasi b
					on b.id = a.id_klasifikasi
				where a.token_klasifikasi = '$token'
			")->result();
			foreach($p as $r){ 
			$lpjkp += $r->lpjkp;
			$lpjkn += $r->lpjkn;
			?>
		<tr style="">
			<td  style="width: 4%;padding-left: 4px;padding-right: 4px; padding-top: 4px;padding-bottom: 4px">&nbsp;</td>
			<td colspan="3" style="width: auto;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;"><?php echo $r->kode ?></td>
			<td  style="width: 18%;padding-left: 4px; padding-right: 4px; padding-top: 4px; padding-bottom: 4px;">&nbsp;</td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;"><?php echo money($r->lpjkp) ?></td>
			<td  style="width: 15%;padding-left: 4px; padding-right: 4px;  padding-top: 4px; padding-bottom: 4px;"><?php echo money($r->lpjkn) ?></td>
		</tr>
			<?php } ?>
		<?php } ?>
		<tr >
			<td style="width: 4%;padding-left: 4px; padding-right: 4px; padding-top: 4px;padding-bottom: 4px"></td>
			<td style="width: 19%;padding-left: 4px; padding-right: 4px;"></td>
			<td style="width: 15%;padding-left: 4px; padding-right: 4px; "></td>
			<td style="width: 12%;padding-left: 4px; padding-right: 4px; "></td>
			<td style="width: 18%;padding-left: 4px; padding-right: 4px;padding-top: 4px;padding-bottom: 4px "><b>Jumlah</b></td>
			<td style="text-align: center; width: 15%;padding-left: 4px; padding-right: 4px; "><b><?php echo money($lpjkp) ?></b></td>
			<td style="text-align: center; width: 15%;padding-left: 4px; padding-right: 4px; "><b><?php echo money($lpjkn) ?></b></td>
		</tr>
		<tr style="background: #ffff24">
			<td style="width: 4%;padding-left: 4px; padding-right: 4px; padding-top: 4px;padding-bottom: 4px"></td>
			<td style="width: 19%;padding-left: 4px; padding-right: 4px;"></td>
			<td style="width: 17%;padding-left: 4px; padding-right: 4px; "></td>
			<td style="width: 12%;padding-left: 4px; padding-right: 4px; "></td>
			<td style="width: 18%;padding-left: 4px; padding-right: 4px;padding-top: 4px;padding-bottom: 4px "><b>Total Biaya</b></td>
			<td colspan="2" style="text-align: center; width: auto;padding-left: 4px; padding-right: 4px; "><b><?php echo money($lpjkp+$lpjkn) ?></b></td>
		</tr>
	</table>
	<table style="width: 100%" cellpadding="7" cellspacing="0" border="0">
		<tr><td style="padding-bottom: 4px; padding-top: 4px;  "><?php echo ucwords("berdasarkan peraturan LPJK nasional nomor 3 tahun 2017 tentang sertifikasi dan registrasi badan usaha") ?></td></tr>
	</table>
</body>