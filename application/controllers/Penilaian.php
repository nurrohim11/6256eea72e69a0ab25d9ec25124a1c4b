<?php
date_default_timezone_set('Asia/Jakarta');
class Penilaian extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Permohonan_model');
		$this->load->model('Penilaian_model');
	}
	function view_permohonan_bu(){
		$id= $this->input->get('id');
		$p = $this->Permohonan_model->view_permohonan_bu($id);
		$response=[];
		// print_r($p);
		if($p){
			$approval ='';
			if($p->nama_approval == ''){
				$approval='';
			}else{
				$approval =' By Keuangan';
			}
			$rekomendasi ='';
			if($p->nama_rekomendasi == ''){
				$rekomendasi='';
			}else{
				$rekomendasi =' By '.$p->nama_rekomendasi;
			}
			$response=array(
				'id' => $p->id,
				'invoice' => $p->no_invoice,
				'nama_user' => $p->nama,
				'assosiasi' => $p->assosiasi,
				'tgl_masuk' => $p->tgl_berkas_masuk,
				'tgl_pembayaran' => $p->tgl_pembayaran,
				'level_user' => level(),
				'status_keuangan' => $p->status_keuangan.$approval,
				'status_rekomendasi' => $p->status_rekomendasi.$rekomendasi,
				'bukti_setoran' => path_image(strtolower($p->tipe_permohonan)).$p->bukti_setoran,
				'badan_usaha' => $this->Permohonan_model->bidang_usaha($p->token_permohonan),
			);
			$status= true;
			$message="Berhasil";
		}else{
			$status=false;
			$message="Gagal";
		}
		echo json_encode(array('status' => $status,'message' => $message,'response' => $response));
	}


	function view_permohonan_personal(){
		$id= $this->input->get('id');
		$p = $this->Permohonan_model->view_permohonan_personal($id);
		$response=[];
		// print_r($p);
		if($p){
			$approval ='';
			if($p->nama_approval == ''){
				$approval='';
			}else{
				$approval =' By Keuangan';
				// $approval =' By '.$p->nama_approval;
			}
			$rekomendasi ='';
			if($p->nama_rekomendasi == ''){
				$rekomendasi='';
			}else{
				$rekomendasi =' By '.$p->nama_rekomendasi;
			}
			$response=array(
				'id' => $p->id,
				'invoice' => $p->no_invoice,
				'nama_user' => $p->nama,
				'assosiasi' => $p->assosiasi,
				'tgl_masuk' => $p->tgl_berkas_masuk,
				'tgl_pembayaran' => $p->tgl_pembayaran,
				'status_keuangan' => $p->status_keuangan.$approval,
				'status_rekomendasi' => $p->status_rekomendasi.$rekomendasi,
				'level_user' => level(),
				'bukti_setoran' => path_image(strtolower($p->tipe_permohonan)).$p->bukti_setoran,
				'personal' => $this->Permohonan_model->personal($p->token_permohonan),
			);
			$status= true;
			$message="Berhasil";
		}else{
			$status=false;
			$message="Gagal";
		}
		echo json_encode(array('status' => $status,'message' => $message,'response' => $response));
	}

	function penilaian_uskt(){
		get_login();
		// get_page();
		$token_permohonan = $this->input->get('token');
		$id_personal = $this->input->get('id');
		$header['title'] ="Penilaian USKT";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/penilaian.js" type="text/javascript"></script>';

		$data['dp'] = $this->Penilaian_model->detail_personal($id_personal,$token_permohonan);
		$data['dk'] = $this->Penilaian_model->detail_klasifikasi($data['dp']->token_klasifikasi);
		$data['h'] =$this->db->get_where('ms_hasil',array('status' =>1))->result();
		$data['ass'] = $this->db->get_where('ms_assesor',array('ket' => 1))->result();

		$this->load->view('template/header',$header);
		$this->load->view('penilaian/uskt',$data);
		$this->load->view('template/footer',$footer);
	}

	function process_penilaian_uskt(){
		$id_personal = $this->input->post('id_personal');
		$id_detail = $this->input->post('id');
		$ketua_assesor = $this->input->post('ketua_assesor');
		$assesor_1 = $this->input->post('assesor_1');
		$assesor_2 = $this->input->post('assesor_2');
		$hasil = $this->input->post('hasil');

		$this->db->trans_begin();
		$upd = $this->Main_model->process_data('tb_personal',array('penilaian' => 1),array('id' => $id_personal));
		if ($this->db->trans_status() === TRUE){
        	$this->db->trans_commit();
        	for($i=0; $i<count($id_detail); $i++){
        		$data = array(
        			'assesor_1' => $ketua_assesor[$i],
        			'assesor_2' => $assesor_1[$i],
        			'assesor_3' => $assesor_2[$i],
        			'hasil' => $hasil[$i],
        			'tgl_penilaian' => date('Y-m-d H:i:s'),
        			'update_at' => date('Y-m-d H:i:s')
        		);
        		$this->Main_model->process_data('detail_klasifikasi',$data,array('id' => $id_detail[$i]));
        	}
        	$status =true;
        	$message="Penilaian sudah dilakukan";
        }else{
        	$this->db->trans_rollback();
        	$status = false;
        	$message="Penilaian gagal dilakukan";
        }
        echo  json_encode(array('status' => $status,'message' =>$message));
	}

	function penilaian_usbu(){
		get_login();
		// get_page();
		$token_permohonan = $this->input->get('token');
		$id_bu = $this->input->get('id');
		$header['title'] ="Penilaian USBU";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/penilaian.js" type="text/javascript"></script>';

		$data['dp'] = $this->Penilaian_model->detail_bidang_usaha($id_bu,$token_permohonan);
		$data['dk'] = $this->Penilaian_model->detail_klasifikasi($data['dp']->token_klasifikasi);
		$data['h'] =$this->db->get_where('ms_hasil',array('status' =>1))->result();
		$data['ass'] = $this->db->get_where('ms_assesor',array('ket' => 0))->result();

		$this->load->view('template/header',$header);
		$this->load->view('penilaian/usbu',$data);
		$this->load->view('template/footer',$footer);
	}

	function process_penilaian_usbu(){
		$id_usaha = $this->input->post('id_usaha');
		$id_detail = $this->input->post('id');
		$ketua_assesor = $this->input->post('ketua_assesor');
		$assesor_1 = $this->input->post('assesor_1');
		$assesor_2 = $this->input->post('assesor_2');
		$hasil = $this->input->post('hasil');
		$upd = $this->Main_model->process_data('tb_bidang_usaha',array('penilaian' => 1),array('id' => $id_usaha));
		if ($this->db->trans_status() === TRUE){
        	$this->db->trans_commit();
        	for($i=0; $i<count($id_detail); $i++){
        		$data = array(
        			'assesor_1' => $ketua_assesor[$i],
        			'assesor_2' => $assesor_1[$i],
        			'assesor_3' => $assesor_2[$i],
        			'hasil' => $hasil[$i],
        			'tgl_penilaian' => date('Y-m-d H:i:s'),
        			'update_at' => date('Y-m-d H:i:s')
        		);
        		$this->Main_model->process_data('detail_klasifikasi',$data,array('id' => $id_detail[$i]));
        	}
        	$status =true;
        	$message="Penilaian sudah dilakukan";
        }else{
        	$this->db->trans_rollback();
        	$status = false;
        	$message="Penilaian gagal dilakukan";
        }
        echo  json_encode(array('status' => $status,'message' =>$message));
	}
}