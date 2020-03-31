<?php
class Penilaian_model extends CI_Model{

	function detail_personal($id_personal,$token_permohonan){
		return $this->db->query("
			SELECT a.*,b.id_assosiasi,c.nama, c.asosiasi,DATE(b.tgl_berkas_masuk) as tgl_berkas_masuk 
			from tb_personal a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			join (
				SELECT d.nama,d.id, d.alamat, e.nama as asosiasi, e.jenis_asosiasi from tb_user d
				join ms_assosiasi e
					on e.kode = d.kode
			) as c
				on b.id_assosiasi = c.id
					where b.status=1 and a.id ='$id_personal' and a.token_permohonan = '$token_permohonan'
			")->row();
	}

	function detail_bidang_usaha($id_personal,$token_permohonan){
		return $this->db->query("
			SELECT a.*,b.id_assosiasi,c.nama, c.asosiasi,DATE(b.tgl_berkas_masuk) as tgl_berkas_masuk, d.kota as ket_kota, e.kbli
			from tb_bidang_usaha a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			join (
				SELECT d.nama,d.id, d.alamat, e.nama as asosiasi, e.jenis_asosiasi from tb_user d
				join ms_assosiasi e
					on e.kode = d.kode
			) as c
				on b.id_assosiasi = c.id
			left join ms_kota d
				on d.id = a.kota	
			left join ms_kbli e
				on e.id = a.id_kbli				
					where b.status=1 and a.id ='$id_personal' and a.token_permohonan = '$token_permohonan'
			")->row();
	}

	function detail_klasifikasi($token_klasifikasi){
		return $this->db->query("
				SELECT a.id,b.kode as kode_klasifikasi,b.deskripsi as deskripsi_klasifikasi, b.deskripsi_lengkap as deskripsi_lengkap_klasifikasi,
					c.kode as kode_sub_klasifikasi, c.deskripsi as deskripsi_sub_klasifikasi, c.lingkup_pekerjaan as lingkup_pekerjaan_klasifikasi,
					d.kode as kode_kualifikasi,
					(a.biaya+a.biaya_lpjkn+a.biaya_lpjkp) as total_biaya
					FROM detail_klasifikasi a
					join ms_klasifikasi b
						on b.id = a.klasifikasi
					join ms_sub_klasifikasi c
						on c.id = a.sub_klasifikasi
					join ms_kualifikasi d
						on d.id = a.kualifikasi
						where a.token_klasifikasi ='$token_klasifikasi'
			")->result();
	}
}