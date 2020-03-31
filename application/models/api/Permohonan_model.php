<?php
class Permohonan_model extends CI_Model{

	function permohonan_sbu($id_user){
		return $this->db->query("
			SELECT a.*,b.kbli, c.kota as ket_kota, 
				(CASE 
					when d.id is null then '0'
					else '1' 
					end
				) as status_approval
				from tb_bidang_usaha a
				left join ms_kbli b
					on a.id_kbli = b.id
				left join ms_kota c
					on c.id = a.kota
				left join (
					select * from history_approval_sbu e
					where e.id_user ='$id_user'
				) as d
				on d.id_bu = a.id
				where a.ba =1 
				order by a.insert_at desc
			")->result();
	}

	function permohonan_skt($id_user){
		return $this->db->query("
			SELECT a.*,c.tipe_permohonan, 
				(CASE 
					when d.id is null then '0'
					else '1' 
					end
				) as status_approval from tb_personal a
				join tb_permohonan b
					on a.token_permohonan = b.token_permohonan
				join ms_tipe_permohonan c
					on b.`type` = c.kode
				left join (
					select * from history_approval_skt e
					where e.id_user ='$id_user'
				) as d
				on d.id_personal = a.id
				where a.ba=1 
				order by a.insert_at desc
			")->result();
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