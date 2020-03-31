<?php
date_default_timezone_set('Asia/Jakarta');
use Dompdf\Dompdf;
class Permohonan extends CI_Controller
{
    public $filename;
	function __construct(){
		parent::__construct();
		$this->load->model('Permohonan_model');
        $this->filename = "laporan.pdf";
	}
	function sbu(){
		get_login();
		get_page();
		$header['title'] ="Tambah Permohonan SBU";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/permohonan.js" type="text/javascript"></script>';

		$data['kota'] = $this->Permohonan_model->ms_kota();
		$data['kbli'] = $this->Permohonan_model->ms_kbli();
		$data['assosiasi'] = $this->Main_model->ms_user(2);
		$this->load->view('template/header',$header);
		$this->load->view('permohonan/sbu',$data);
		$this->load->view('template/footer',$footer);
	}

	function prosess_badan_usaha(){
		$token_permohonan = $this->input->post('token_permohonan');
		$token_klasifikasi = $this->input->post('token_klasifikasi');
		$npwp = $this->input->post('npwp');
		$nama_bu = $this->input->post('nama_bu');
		$kota = $this->input->post('kota');
		$alamat = $this->input->post('alamat');
		$kbli = $this->input->post('kbli');
		$penanggung_jawab = $this->input->post('penanggung_jawab');

		$klasifikasi = $this->input->post('klasifikasi');
		$sub_klasifikasi = $this->input->post('sub_klasifikasi');
		$kualifikasi = $this->input->post('kualifikasi');
		$permohonan = $this->input->post('permohonan');
		// $biaya = $this->input->post('biaya');

		$data_induk = array(
			'npwp'=>$npwp,
			'nama_bu' => $nama_bu,
			'kota' => $kota,
			'alamat' =>$alamat,
			'token_permohonan' => $token_permohonan,
			'token_klasifikasi' => $token_klasifikasi,
			'id_kbli' => $kbli,
			'penanggung_jawab' => $penanggung_jawab,
			'insert_at' => date('Y-m-d H:i:s'),
			'user_insert' => username()
		);
		$save = $this->db->insert('tb_bidang_usaha',$data_induk);
		if($save){
			$data_detail=[];
			if(!empty($klasifikasi)){
				$unique_klasifikasi = array_unique($klasifikasi);
				$kla=[];
				foreach($unique_klasifikasi as $row){
					$kla[]= array(
						'token_klasifikasi' => $token_klasifikasi,
						'id_klasifikasi' => $row,
						'lpjkp' => app_setting('biaya_pengembangan_lpjkp'),
						'lpjkn' => app_setting('biaya_pengembangan_lpjkn'), 
						'insert_at' => date('Y-m-d H:i:s')
					);
				}
				$sk = $this->db->insert_batch('tb_biaya_pengembangan',$kla);
				if($sk){
					for($i=0; $i<count($klasifikasi); $i++){
						$b = $this->db->get_where('tb_biaya',array('kelompok' => $kbli,'id_permohonan' => $permohonan[$i],'id_kualifikasi' => $kualifikasi[$i],'jenis' => 'sbu'))->row();
						$data_detail[]=array(
							'klasifikasi' => $klasifikasi[$i],
							'sub_klasifikasi' => $sub_klasifikasi[$i],
							'kualifikasi' => $kualifikasi[$i],
							'id_permohonan' => $permohonan[$i],
							'biaya' => 0,
							'token_klasifikasi' => $token_klasifikasi,
							'biaya_lpjkp' => ($b->lpjkp) ? $b->lpjkp : 0,
							'biaya_lpjkn' => ($b->lpjkn) ? $b->lpjkn : 0,
						);
					}
					$s = $this->db->insert_batch('detail_klasifikasi',$data_detail);
					if($s){
						$status=1;
						$message='Bidang usaha berhasil ditambahkan';	
					}else{
						$status=0;
						$message='Gagal menyimpan data klasifikasi';
					}	
				}else{
					$status=0;
					$message='Gagal menyimpan data klasifikasi';
				}
			}else{
				$status=1;
				$message='Bidang usaha berhasil ditambahkan';
			}
		}else{
			$status =0;
			$message='Data gagal dimasukkan';
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}

	function delete_bu_sbu(){
		$id = $this->input->get('id');
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
        	$upd = $this->Main_model->process_data('tb_bidang_usaha',array('status' => 0),array('id' => $id));
        	if($upd){
        		$status=1;
        		$message="Bidang usaha berhasil dihapus";
        	}else{
        		$status=0;
        		$message="Bidang usaha gagal dihapus";
        	}
        	echo json_encode(array('status' => $status,'message' =>$message));
        }else{
        	show_404();
        }

	}

	function data_klasifikasi(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
        	$query= $this->db->query("SELECT * FROM ms_klasifikasi a where a.flag=0")->result();
        	$result='';
        	$result .= '<option></option>';
        	if($query){
        		foreach($query as $row){
        			$result.= '<option value="'.$row->id.'">'.$row->kode.'</option>';
        		}
        	}else{
        		$result .= '';
        	}
        	echo $result;
        }else{
        	show_404();
        }
	}

	function data_klasifikasi_tenaga_kerja(){
		get_login();
		$is_ajax = $this->input->is_ajax_request();
		if($is_ajax){
        	$query= $this->db->query("SELECT * FROM ms_klasifikasi a where a.flag=1")->result();
        	$result='';
        	$result .= '<option></option>';
        	if($query){
        		foreach($query as $row){
        			$result.= '<option value="'.$row->id.'">'.$row->kode.'</option>';
        		}
        	}else{
        		$result .= '';
        	}
        	echo $result;
		}else{
			show_404();
		}
	}

	function data_sub_klasifikasi(){
		get_login();
		$is_ajax = $this->input->is_ajax_request();
		if($is_ajax){
			$id_klasifikasi = $this->input->get('id_klasifikasi');
        	$query= $this->db->query("SELECT * FROM ms_sub_klasifikasi where id_klasifikasi ='$id_klasifikasi'")->result();
        	$result='';
        	$result .= '<option></option>';
        	if($query){
        		foreach($query as $row){
        			$result.= '<option value="'.$row->id.'">'.$row->kode.'</option>';
        		}
        	}else{
        		$result .= '';
        	}
        	echo $result;
		}else{
			show_404();
		}
	}

	function data_kualifikasi(){
		get_login();
		$is_ajax = $this->input->is_ajax_request();
		if($is_ajax){
			$flag = $this->input->post('flag');
			// print_r($flag);
        	$query= $this->db->query("SELECT * FROM ms_kualifikasi a where a.flag ='$flag'")->result();
        	$result='';
        	$result .= '<option></option>';
        	if($query){
        		foreach($query as $row){
        			$result.= '<option value="'.$row->id.'">'.$row->kode.'</option>';
        		}
        	}else{
        		$result .= '';
        	}
        	echo $result;
		}else{
			show_404();
		}
	}

	function data_permohonan_sbu(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $token = $this->input->get('token');

            $json = $this->Permohonan_model->json_permohonan_sbu($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$token);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function proses_permohonan_sbu(){
		get_login();
		$id_user='';
		$level =level();
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$tgl_pembayaran = $this->input->post('tgl_pembayaran');
		$token = $this->input->post('token');
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$no =nomor();
		$config['upload_path'] = './assets/uploads/sbu/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '2048000'; // max size in KB
		$config['max_width'] = '20000'; //max resolution width
		$config['max_height'] = '20000';  //max resolution height
		$config['file_name'] = $no.rname(strtolower($_FILES['bukti_setoran']['name']));

		if($level==1){
			$id_user = $this->input->post('assosiasi');
		}else{
			$id_user = userId();
		}

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('bukti_setoran')){
			$status=0;
			$message =$this->upload->display_errors();
		}
		else{
			$image = $no.rname(strtolower($_FILES['bukti_setoran']['name']));
			$data_p = array(
				'id_assosiasi' => $id_user,
				'no_invoice' => update_counter('INV'),
				'tgl_berkas_masuk' => $tgl_permohonan.' '.date('H:i:s'),
				'tgl_pembayaran' => $tgl_pembayaran.' '.date('H:i:s'),
				'token_permohonan' => $token,
				'bukti_setoran' => $image,
				'type' => 0,
				'insert_at' => date('Y-m-d H:i:s'),
				'user_insert' => username()
			);
			$save = $this->Main_model->process_data('tb_permohonan',$data_p);
			if($save){
				$status=1;
				$message="Permohonan berhasil disimpan";
			}else{
				$status=0;
				$message="Permohonan gagal disimpan";
			}
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}
	// SKA
	function ska(){
		get_login();
		get_page();
		$header['title'] ="Tambah Permohonan SKA";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/permohonan.js" type="text/javascript"></script>';

		$data['kota'] = $this->Permohonan_model->ms_kota();
		$data['assosiasi'] = $this->Main_model->ms_user(2);
		$this->load->view('template/header',$header);
		$this->load->view('permohonan/ska',$data);
		$this->load->view('template/footer',$footer);
	}

	function data_permohonan(){
		$flag= $this->input->get('flag');
		$query = $this->db->get_where('ms_permohonan',array('flag' => $flag))->result();
		$result='';
		$result .= '<option></option>';
		if($query){
			foreach($query as $row){
				$result.='<option value="'.$row->id.'">'.$row->permohonan.'</option>';
			}
		}
		echo $result;
	}

	function data_permohonan_ska(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $token = $this->input->get('token');

            $json = $this->Permohonan_model->json_permohonan_ska($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$token);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function prosess_personal(){
		$token_permohonan = $this->input->post('token_permohonan');
		$token_klasifikasi = $this->input->post('token_klasifikasi');
		$nik = $this->input->post('nik');
		$nama_personal = $this->input->post('nama_personal');
		$alamat = $this->input->post('alamat');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$kota = $this->input->post('kota');

		$klasifikasi = $this->input->post('klasifikasi');
		$sub_klasifikasi = $this->input->post('sub_klasifikasi');
		$kualifikasi = $this->input->post('kualifikasi');
		$permohonan = $this->input->post('permohonan');
		// $biaya = $this->input->post('biaya');

		$data_induk = array(
			'nik'=>$nik,
			'nama' => $nama_personal,
			'alamat' =>$alamat,
			'tgl_lahir' =>$tgl_lahir,
			'jenis_kelamin' =>$jenis_kelamin,
			'token_permohonan' => $token_permohonan,
			'kota' => $kota,
			'token_klasifikasi' => $token_klasifikasi,
			'insert_at' => date('Y-m-d H:i:s'),
			'user_insert' => username()
		);
		$save = $this->db->insert('tb_personal',$data_induk);
		if($save){
			$data_detail=[];
			if(!empty($klasifikasi)){
				// $unique_klasifikasi = array_unique($klasifikasi);
				$kla=[];
				// foreach($unique_klasifikasi as $row){
				// 	$kla[]= array(
				// 		'token_klasifikasi' => $token_klasifikasi,
				// 		'id_klasifikasi' => $row,
				// 		'lpjkp' => app_setting('biaya_pengembangan_lpjkp'),
				// 		'lpjkn' => app_setting('biaya_pengembangan_lpjkn'),
				// 		'insert_at' => date('Y-m-d H:i:s')
				// 	);
				// }
				for($i=0; $i<count($klasifikasi); $i++){
					$kla[]= array(
						'token_klasifikasi' => $token_klasifikasi,
						'id_klasifikasi' => $klasifikasi[$i],
						'lpjkp' => app_setting('biaya_pengembangan_lpjkp'),
						'lpjkn' => app_setting('biaya_pengembangan_lpjkn'),
						'insert_at' => date('Y-m-d H:i:s')
					);
				}
				$sk = $this->db->insert_batch('tb_biaya_pengembangan',$kla);
				if($sk){
					for($i=0; $i<count($klasifikasi); $i++){

						$b = $this->db->get_where('tb_biaya',array('kelompok' => 0,'id_permohonan' => $permohonan[$i],'id_kualifikasi' => $kualifikasi[$i],'jenis' => 'ska'))->row();

						$data_detail[]=array(
							'klasifikasi' => $klasifikasi[$i],
							'sub_klasifikasi' => $sub_klasifikasi[$i],
							'kualifikasi' => $kualifikasi[$i],
							'id_permohonan' => $permohonan[$i],
							'biaya' => 0,
							'token_klasifikasi' => $token_klasifikasi,
							'biaya_lpjkp' => ($b->lpjkp) ? $b->lpjkp : 0,
							'biaya_lpjkn' => ($b->lpjkn) ? $b->lpjkn : 0,
						);
					}
					$s = $this->db->insert_batch('detail_klasifikasi',$data_detail);
					if($s){
						$status=1;
						$message='Personal berhasil ditambahkan';	
					}else{
						$status=0;
						$message='Gagal menyimpan data klasifikasi';
					}
				}else{
					$status=0;
					$message='Gagal menyimpan data klasifikasi';
				}
			}else{
				$status=1;
				$message='Personal berhasil ditambahkan';
			}
		}else{
			$status =0;
			$message='Data gagal dimasukkan';
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}
	function delete_personal_ska(){
		$id = $this->input->get('id');
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
        	$upd = $this->Main_model->process_data('tb_personal',array('status' => 0),array('id' => $id));
        	if($upd){
        		$status=1;
        		$message="Personal berhasil dihapus";
        	}else{
        		$status=0;
        		$message="Personal gagal dihapus";
        	}
        	echo json_encode(array('status' => $status,'message' =>$message));
        }else{
        	show_404();
        }

	}

	function proses_permohonan_ska(){
		get_login();
		$id_user='';
		$level =level();
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$tgl_pembayaran = $this->input->post('tgl_pembayaran');
		$token = $this->input->post('token');
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$no =nomor();
		$config['upload_path'] = './assets/uploads/ska/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '2048000'; // max size in KB
		$config['max_width'] = '20000'; //max resolution width
		$config['max_height'] = '20000';  //max resolution height
		$config['file_name'] = $no.rname(strtolower($_FILES['bukti_setoran']['name']));

		if($level==1){
			$id_user = $this->input->post('assosiasi');
		}else{
			$id_user = userId();
		}

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('bukti_setoran')){
			$status=0;
			$message =$this->upload->display_errors();
		}
		else{
			$image = $no.rname(strtolower($_FILES['bukti_setoran']['name']));
			$data_p = array(
				'id_assosiasi' => $id_user,
				'no_invoice' => update_counter('INV'),
				'tgl_berkas_masuk' => $tgl_permohonan.' '.date('H:i:s'),
				'tgl_pembayaran' => $tgl_pembayaran.' '.date('H:i:s'),
				'token_permohonan' => $token,
				'bukti_setoran' => $image,
				'type' => 1,
				'insert_at' => date('Y-m-d H:i:s'),
				'user_insert' => username()
			);
			$save = $this->Main_model->process_data('tb_permohonan',$data_p);
			if($save){
				$status=1;
				$message="Permohonan berhasil disimpan";
			}else{
				$status=0;
				$message="Permohonan gagal disimpan";
			}
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}

	// SKT
	function skt(){
		get_login();
		get_page();
		$header['title'] ="Tambah Permohonan SKT";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/skt.js" type="text/javascript"></script>';

		$data['kota'] = $this->Permohonan_model->ms_kota();
		$data['assosiasi'] = $this->Main_model->ms_user(2);
		$this->load->view('template/header',$header);
		$this->load->view('permohonan/skt',$data);
		$this->load->view('template/footer',$footer);
	}
	function data_permohonan_skt(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $token = $this->input->get('token');

            $json = $this->Permohonan_model->json_permohonan_skt($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$token);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function data_klasifikasi_tenaga_kerja_skt(){
		get_login();
		$is_ajax = $this->input->is_ajax_request();
		if($is_ajax){
        	$query= $this->db->query("SELECT * FROM ms_klasifikasi a where a.flag=2")->result();
        	$result='';
        	$result .= '<option></option>';
        	if($query){
        		foreach($query as $row){
        			$result.= '<option value="'.$row->id.'">'.$row->kode.'</option>';
        		}
        	}else{
        		$result .= '';
        	}
        	echo $result;
		}else{
			show_404();
		}
	}


	function prosess_personal_skt(){
		$token_permohonan = $this->input->post('token_permohonan');
		$token_klasifikasi = $this->input->post('token_klasifikasi');
		$nik = $this->input->post('nik');
		$nama_personal = $this->input->post('nama_personal');
		$alamat = $this->input->post('alamat');
		$tgl_lahir = $this->input->post('tgl_lahir');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$kota = $this->input->post('kota');

		$klasifikasi = $this->input->post('klasifikasi');
		$sub_klasifikasi = $this->input->post('sub_klasifikasi');
		$kualifikasi = $this->input->post('kualifikasi');
		$permohonan = $this->input->post('permohonan');
		// $biaya = $this->input->post('biaya');

		$data_induk = array(
			'nik'=>$nik,
			'nama' => $nama_personal,
			'alamat' =>$alamat,
			'tgl_lahir' =>$tgl_lahir,
			'jenis_kelamin' =>$jenis_kelamin,
			'kota' =>$kota,
			'token_permohonan' => $token_permohonan,
			'token_klasifikasi' => $token_klasifikasi,
			'insert_at' => date('Y-m-d H:i:s'),
			'user_insert' => username()
		);
		$save = $this->db->insert('tb_personal',$data_induk);
		if($save){
			$data_detail=[];
			if(!empty($klasifikasi)){
				// $unique_klasifikasi = array_unique($klasifikasi);
				$kla=[];
				// foreach($unique_klasifikasi as $row){
				// 	$kla[]= array(
				// 		'token_klasifikasi' => $token_klasifikasi,
				// 		'id_klasifikasi' => $row,
				// 		'lpjkp' => app_setting('biaya_pengembangan_lpjkp'),
				// 		'lpjkn' => app_setting('biaya_pengembangan_lpjkn'),
				// 		'insert_at' => date('Y-m-d H:i:s')
				// 	);
				// }
				for($i=0; $i<count($klasifikasi); $i++){
					$kla[]= array(
						'token_klasifikasi' => $token_klasifikasi,
						'id_klasifikasi' => $klasifikasi[$i],
						'lpjkp' => app_setting('biaya_pengembangan_lpjkp'),
						'lpjkn' => app_setting('biaya_pengembangan_lpjkn'),
						'insert_at' => date('Y-m-d H:i:s')
					);
				}
				$sk = $this->db->insert_batch('tb_biaya_pengembangan',$kla);
				if($sk){
					for($i=0; $i<count($klasifikasi); $i++){
						$b = $this->db->get_where('tb_biaya',array('kelompok' => 0,'id_permohonan' => $permohonan[$i],'id_kualifikasi' => $kualifikasi[$i],'jenis' => 'skt'))->row();
						$data_detail[]=array(
							'klasifikasi' => $klasifikasi[$i],
							'sub_klasifikasi' => $sub_klasifikasi[$i],
							'kualifikasi' => $kualifikasi[$i],
							'id_permohonan' => $permohonan[$i],
							'biaya' => 0,
							'token_klasifikasi' => $token_klasifikasi,
							'biaya_lpjkp' => ($b->lpjkp) ? $b->lpjkp : '',
							'biaya_lpjkn' => ($b->lpjkn) ? $b->lpjkn : '',
						);
					}
					$s = $this->db->insert_batch('detail_klasifikasi',$data_detail);
					if($s){
						$status=1;
						$message='Personal berhasil ditambahkan';	
					}else{
						$status=0;
						$message='Gagal menyimpan data klasifikasi';
					}	
				}else{
					$status=0;
					$message='Gagal menyimpan data klasifikasi';
				}
			}else{
				$status=1;
				$message='Personal berhasil ditambahkan';
			}
		}else{
			$status =0;
			$message='Data gagal dimasukkan';
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}

	function delete_personal_skt(){
		$id = $this->input->get('id');
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
        	$upd = $this->Main_model->process_data('tb_personal',array('status' => 0),array('id' => $id));
        	if($upd){
        		$status=1;
        		$message="Personal berhasil dihapus";
        	}else{
        		$status=0;
        		$message="Personal gagal dihapus";
        	}
        	echo json_encode(array('status' => $status,'message' =>$message));
        }else{
        	show_404();
        }

	}

	function proses_permohonan_skt(){
		get_login();
		$id_user='';
		$level =level();
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$tgl_pembayaran = $this->input->post('tgl_pembayaran');
		$token = $this->input->post('token');
		$tgl_permohonan = $this->input->post('tgl_permohonan');
		$no =nomor();
		$config['upload_path'] = './assets/uploads/skt/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '2048000'; // max size in KB
		$config['max_width'] = '20000'; //max resolution width
		$config['max_height'] = '20000';  //max resolution height
		$config['file_name'] = $no.rname(strtolower($_FILES['bukti_setoran']['name']));

		if($level==1){
			$id_user = $this->input->post('assosiasi');
		}else{
			$id_user = userId();
		}

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('bukti_setoran')){
			$status=0;
			$message =$this->upload->display_errors();
		}
		else{
			$image = $no.rname(strtolower($_FILES['bukti_setoran']['name']));
			$data_p = array(
				'id_assosiasi' => $id_user,
				'no_invoice' => update_counter('INV'),
				'tgl_berkas_masuk' => $tgl_permohonan.' '.date('H:i:s'),
				'tgl_pembayaran' => $tgl_pembayaran.' '.date('H:i:s'),
				'token_permohonan' => $token,
				'bukti_setoran' => $image,
				'type' => 2,
				'insert_at' => date('Y-m-d H:i:s'),
				'user_insert' => username()
			);
			$save = $this->Main_model->process_data('tb_permohonan',$data_p);
			if($save){
				$status=1;
				$message="Permohonan berhasil disimpan";
			}else{
				$status=0;
				$message="Permohonan gagal disimpan";
			}
		}
		echo json_encode(array('status' => $status,'message' =>$message));
	}

	function list_permohonan(){
		get_login();
		get_page();
		$header['title'] ="List Permohonan";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/permohonan.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/list');
		$this->load->view('template/footer',$footer);
	}

	function data_permohonan_all(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Permohonan_model->json_permohonan($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function delete_permohonan(){
		$id= $this->input->get('id');

        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
        	$upd = $this->Main_model->process_data('tb_permohonan',array('status' => 0),array('id' => $id));
        	if($upd){
        		$status=true;
        		$message="Permohonan dibatalkan";
        	}else{
        		$status=false;
        		$message="Permohonan gagal dibatalkan";
        	}
        	echo json_encode(array('status' => $status,'message' =>$message));
        }else{
        	show_404();
        }
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
				'badan_usaha' => $this->Permohonan_model->bidang_usaha($p->token_permohonan)
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

	function download_file_permohonan_sbu(){
		$id = $this->input->get('id');
		ob_start();
		$data['bu'] = $this->Permohonan_model->detail_bidang_usaha($id);
		$data['p'] = $this->db->query("
			SELECT a.*,e.nama as asosiasi, DATE(a.tgl_berkas_masuk) as tgl_masuk, DATE(a.tgl_pembayaran) as tgl_bayar 
			from tb_permohonan a
				left join (
				    select f.id,g.nama from tb_user f
				    join ms_assosiasi g
				        on f.kode = g.kode
				    where f.status =1
				) e
					on e.id = a.id_assosiasi
				where a.id = '$id'
			")->row();
		$this->load->view('permohonan/cetak_permohonan_sbu',$data);
		$html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
		$pdf = new HTML2PDF('P','A4','en',true, 'UTF-8', array(15, 15, 15, 15));
		$pdf->WriteHTML($html);
		$pdf->Output('wkwkwkwk.pdf', false);
		// $pdf->Output(str_replace("/", "", $data['p']->no_invoice).""date('Y-m-d').'.pdf', 'D');
	}

	function download_file_permohonan_skt(){
		$id = $this->input->get('id');
		ob_start();
		$data['personal'] = $this->Permohonan_model->detail_personal($id);
		$data['p'] = $this->db->query("
			SELECT a.*,e.nama as asosiasi, DATE(a.tgl_berkas_masuk) as tgl_masuk, DATE(a.tgl_pembayaran) as tgl_bayar from tb_permohonan a
				left join (
				    select f.id,g.nama from tb_user f
				    join ms_assosiasi g
				        on f.kode = g.kode
				    where f.status =1
				) e
					on e.id = a.id_assosiasi
				where a.id = '$id'
			")->row();
		$this->load->view('permohonan/cetak_permohonan_skt',$data);
		$html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
		$pdf = new HTML2PDF('P','A4','en',true, 'UTF-8', array(15, 15, 15, 15));
		$pdf->WriteHTML($html);
		$pdf->Output('wkwkwkwk.pdf', false);
		// $pdf->Output(str_replace("/", "", $data['p']->no_invoice).""date('Y-m-d').'.pdf', 'D');
	}

	function approval_permohonan(){
		get_login();
		get_page();
		$header['title'] ="Permohonan yang belum diapproval";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/approval.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/approval_permohonan');
		$this->load->view('template/footer',$footer);
	}

	function data_permohonan_approval(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Permohonan_model->json_permohonan_approval($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function prosess_approval_permohonan(){
		$id = $this->input->get('id');

		$is_ajax = $this->input->is_ajax_request();
		if($is_ajax){
			$data= array(
				'keuangan' => 1,
				'tgl_approval_keuangan' => date('Y-m-d H:i:s'),
				'user_approval' => userId()
			);
			$hapus= $this->Main_model->process_data('tb_permohonan',$data,array('id' => $id));
			if($hapus){
				$status=true;
				$message ="Permohonan sudah di approval";
			}else{
				$status =false;
				$message="Permohonan gagal di prosess";
			}
			echo json_encode(array('status' => $status,'message' => $message));
		}else{
			show_404();
		}
	}

	function history_approval(){
		get_login();
		get_page();
		$header['title'] ="History approval";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/approval.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/history_approval');
		$this->load->view('template/footer',$footer);
	}

	function data_history_approval(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $json = $this->Permohonan_model->json_history_approval($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$start_date,$end_date);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function rekomendasi_permohonan(){
		get_login();
		get_page();
		$header['title'] ="Permohonan yang belum direkomendasikan";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/rekomendasi.js" type="text/javascript"></script>';
		$data['assosiasi'] = $this->Main_model->ms_user(2);

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/rekomendasi_permohonan',$data);
		$this->load->view('template/footer',$footer);
	}

	function history_rekomendasi(){
		get_login();
		get_page();
		$header['title'] ="History rekomendasi";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/rekomendasi.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/history_rekomendasi');
		$this->load->view('template/footer',$footer);
	}

	function data_history_rekomendasi(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $json = $this->Permohonan_model->json_history_rekomendasi($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$start_date,$end_date);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function data_rekomendasi_permohonan(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $assosiasi = $this->input->get('assosiasi');

            $json = $this->Permohonan_model->json_permohonan_rekomendasi($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$assosiasi);

            echo json_encode($json);
        }else{
            show_404();
        }
    }

    function proses_rekomendasi_permohonan(){
    	if($this->input->is_ajax_request()){
    		$id= $this->input->get('id');
    		$no_rek = update_counter('REK');
    		$dt = $this->db->get_where('tb_permohonan',array('id' => $id))->row();
			$data= array(
				'rekomendasi' => 1,
				'tgl_rekomendasi' => date('Y-m-d H:i:s'),
				'user_rekomendasi' => userId(),
				'no_rekomendasi' => $no_rek
			);
			$rek= $this->Main_model->process_data('tb_permohonan',$data,array('id' => $id));
			if($rek){
				$id_p =$id;
				$status=true;
				$message ="Permohonan sudah di rekomendasikan";
			}else{
				$id_p =$id;
				$status =false;
				$message="Permohonan gagal di rekomendasikan";
			}
			echo json_encode(array('status' => $status,'message' => $message,'idp' => $id_p));
    	}else{
    		show_404();
    	}
    }

    function cetak_rekomendasi(){
		$id= $this->input->get('id');
		$dt = $this->db->get_where('tb_permohonan',array('id' => $id))->row();
		$assosiasi = $dt->id_assosiasi;
	    $data = array(
	    	'p' =>$dt,
	    	'ass' => $this->db->query("
		    		SELECT a.*,b.nama as assosiasi from tb_user a
						join ms_assosiasi b
							on b.kode =a.kode
						where a.id = '$assosiasi'
					")->row()
	    );
	    if($dt->type==0){
		    $this->pdfdom->setPaper('A4', 'potrait');
			$this->pdfdom->load_view('pdf/rekomendasi_usbu',$data);
			$this->pdfdom->render();
			$this->pdfdom->stream("Rekomendasi-".str_replace("/", "", $dt->no_invoice).".pdf");
	    }else{
		    $this->pdfdom->setPaper('A4', 'potrait');
			$this->pdfdom->load_view('pdf/rekomendasi_ustk',$data);
			$this->pdfdom->render();
			$this->pdfdom->stream("Rekomendasi-".str_replace("/", "", $dt->no_invoice).".pdf");
	    }
    }

	function penilaian(){
		get_login();
		get_page();
		$header['title'] ="Penilaian permohonan";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/penilaian.js" type="text/javascript"></script>';
		$data['assosiasi'] = $this->Main_model->ms_user(2);

		$this->load->view('template/header',$header);
		$this->load->view('permohonan/penilaian',$data);
		$this->load->view('template/footer',$footer);
	}

	function data_penilaian_permohonan(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Permohonan_model->json_penilaian_permohonan($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}
}