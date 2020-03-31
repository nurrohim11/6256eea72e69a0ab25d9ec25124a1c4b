<?php
date_default_timezone_set('Asia/Jakarta');
class Permohonan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('api/Permohonan_model');
	}

	function sbu(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id_user = isset($params['id_user']) ? $params['id_user'] : '';
			$result = $this->Permohonan_model->permohonan_sbu($id_user);
			if($result){
				foreach($result as $row){
					$response[]= array(
						'id' => $row->id,
						'npwp' => $row->npwp,
						'nama' => $row->nama_bu,
						'alamat' => $row->alamat,
						'kota' => ucfirst(strtolower($row->ket_kota)),
						'status_approval' => $row->status_approval,
						'kbli' => $row->kbli,
						'token_permohonan' => $row->token_permohonan,
						'token_klasifikasi' => $row->token_klasifikasi
					);	
				}
				$status=200;
				$message="Berhasil";
			}else{
				$status = 404;
				$Message ="Data tidak ada";
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}
	function skt(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id_user = isset($params['id_user']) ? $params['id_user'] : '';
			$result = $this->Permohonan_model->permohonan_skt($id_user);
			if($result){
				foreach($result as $row){
					$response[]= array(
						'id' => $row->id,
						'nik' => $row->nik,
						'nama' => $row->nama,
						'alamat' => $row->alamat,
						'tgl_lahir' => $row->tgl_lahir,
						'jenis_kelamin' => $row->jenis_kelamin,
						'tipe_permohonan' => $row->tipe_permohonan,
						'status_approval' => $row->status_approval,
						'token_permohonan' => $row->token_permohonan,
						'token_klasifikasi' => $row->token_klasifikasi
					);	
				}
				$status=200;
				$message="Berhasil";
			}else{
				$status = 404;
				$message ="Data tidak ada";
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function process_sbu(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth== true){
			$response=[];
			$params = get_params();
			$id_user = isset($params['id_user']) ? $params['id_user'] : '';
			$id_bu = isset($params['id_bidang_usaha']) ? $params['id_bidang_usaha'] : '';
			$ttd = isset($params['ttd']) ? $params['ttd'] : '';

			$cek = $this->db->get_where('history_approval_sbu',array('id_bu' =>$id_bu,'id_user' =>$id_user));
			$bu = $this->db->get_where('tb_bidang_usaha',array('id' =>$id_bu))->row();
			if($ttd == ''){
				$status =404;
				$message="Anda belum memberikan tanda tangan";
			}else {
				if(count($cek->result()) > 0){
					$status=400;
					$message="Maaf, anda sudah menyetujui badan usaha ".$bu->nama_bu;
				}else{
				 	$random = date('ymdHis');
					$path = "assets/uploads/ttd/".$random.".png";
		    		$actual = $random.".png";
		    		$data = array(
		    			'ttd' => $actual,
		    			'id_user' => $id_user,
		    			'id_bu' => $id_bu,
		    			'insert_at'=>date('Y-m-d H:i:s')
		    		);
		    		$prosess = $this->Main_model->process_data('history_approval_sbu',$data);
		    		if($prosess){
		    			$bu = $this->db->query("
		    				SELECT * FROM history_approval_sbu a
		    					where a.id_bu = '$id_bu' 
		    			")->result();
						if(count($bu)>=3){
							$this->Main_model->process_data('tb_bidang_usaha',array('nomor' => update_nomor('BAR-BU')),array('id' => $id_bu));
						}
			    		file_put_contents($path,base64_decode($ttd));
		    			$status=200;
		    			$message="Anda menyetujui badan usaha ".$bu->nama_bu;
		    		}else{
		    			$status=400;
		    			$message="Permintaan gagal diproses";
		    		}				
				}
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function process_skt(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth== true){
			$response=[];
			$params = get_params();
			$id_user = isset($params['id_user']) ? $params['id_user'] : '';
			$id_personal = isset($params['id_personal']) ? $params['id_personal'] : '';
			$ttd = isset($params['ttd']) ? $params['ttd'] : '';

			$cek = $this->db->get_where('history_approval_skt',array('id_personal' =>$id_personal,'id_user' =>$id_user));
			$bu = $this->db->get_where('tb_personal',array('id' =>$id_personal))->row();
			if(count($cek->result()) > 0){
				$status=400;
				$message="Maaf, anda sudah menyetujui skt ".$bu->nama;
			}else{
			 	$random = date('ymdHis');
				$path = "assets/uploads/ttd/".$random.".png";
	    		$actual = $random.".png";
	    		$data = array(
	    			'ttd' => $actual,
	    			'id_user' => $id_user,
	    			'id_personal' => $id_personal,
	    			'insert_at'=>date('Y-m-d H:i:s')
	    		);
	    		$prosess = $this->Main_model->process_data('history_approval_skt',$data);
	    		if($prosess){
	    			$per = $this->db->query("
	    				SELECT * FROM history_approval_skt a
	    					where a.id_personal = '$id_personal' 
	    			")->result();
					if(count($per)>=3){
						$this->Main_model->process_data('tb_personal',array('nomor' => update_nomor('BAR-TK')),array('id' => $id_personal));
					}
		    		file_put_contents($path,base64_decode($ttd));
	    			$status=200;
	    			$message="Anda menyetujui skt ".$bu->nama;
	    		}else{
	    			$status=400;
	    			$message="Permintaan gagal diproses";
	    		}				
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function detail_klasifikasi(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$params = get_params();
			$response =[];
			$token_klasifikasi = isset($params['token']) ? $params['token'] : '';

			$res = $this->Permohonan_model->detail_klasifikasi($token_klasifikasi);
			if($res){
				foreach($res as $row){
					$response[]= array(
						'id' => $row->id,
						'kode_klasifikasi' => $row->kode_klasifikasi,
						'deskripsi_klasifikasi' => $row->deskripsi_klasifikasi,
						'deskripsi_lengkap_klasifikasi' => $row->deskripsi_lengkap_klasifikasi,
						'kode_sub_klasifikasi' => $row->kode_sub_klasifikasi,
						'deskripsi_sub_klasifikasi' => $row->deskripsi_sub_klasifikasi,
						'lingkup_pekerjaan_klasifikasi' => $row->lingkup_pekerjaan_klasifikasi,
						'kode_kualifikasi' => $row->kode_kualifikasi,
						'total_biaya' => $row->total_biaya
					);	
				}
				$status=200;
				$message="Berhasil";
			}else{
				$status= 404;
				$message="Detail klasifikasi tidak ada";
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}
}