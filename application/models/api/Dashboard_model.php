<?php

class Dashboard_model extends CI_Model{
	
	function total_sbu(){
		return $this->db->query("
				SELECT count(*) as jml from tb_bidang_usaha a 
					where a.ba =1
			")->row();
	}
	function total_ska(){
		return $this->db->query("
				SELECT count(*) as jml from tb_personal a
				join tb_permohonan b
					on a.token_permohonan = b.token_permohonan
				where b.`type` = 1 and a.ba =1
			")->row();
	}
	function total_skt(){
		return $this->db->query("
				SELECT count(*) as jml from tb_personal a
				join tb_permohonan b
					on a.token_permohonan = b.token_permohonan
				where b.`type` = 2 and a.ba =1
			")->row();
	}
}