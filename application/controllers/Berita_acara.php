<?php
date_default_timezone_set('Asia/Jakarta');
class Berita_acara extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('Berita_acara_model');
	}
	function sbu(){
		get_login();
		get_page();
		$header['title'] ="Berita Acara SBU";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/berita_acara.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('berita_acara/sbu');
		$this->load->view('template/footer',$footer);
	}

	function data_berita_acara_sbu(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Berita_acara_model->json_berita_acara_sbu($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}
	function data_klasifikasi(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');
            $token = $this->input->get('token');

            $json = $this->Berita_acara_model->json_klasifikasi($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir'],$token);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function process_ba_sbu(){
		get_login();
		$arr = $this->input->post('detail');
		$id_bu = $this->input->post('id_bu');
		if(!empty($arr)){
			$upd = $this->Main_model->process_data('tb_bidang_usaha',array('ba' => 1),array('id' => $id_bu));
			if($upd){
				foreach($arr as $row){
					$data = array(
						'cek_ba' => 1
					);
					$this->Main_model->process_data('detail_klasifikasi',$data,array('id' => $row['id']));
				}
				$status = true;
				$message="Pengecekan selesai dilakukan";
				notifikasi_pengurus();
			}else{
				$status=false;
				$message="Pengecekan gagal dilakukan";
			}
		}else{
			$status = false;
			$message="Belum ada yang dipilih";
		}
		echo json_encode(array('status' => $status,'message' => $message));
	}

	function ska(){
		get_login();
		get_page();
		$header['title'] ="Berita Acara SKA";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/berita_acara.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('berita_acara/ska');
		$this->load->view('template/footer',$footer);
	}

	function data_berita_acara_ska(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Berita_acara_model->json_berita_acara_ska($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function process_ba_ska(){
		get_login();
		$arr = $this->input->post('detail');
		$id_personal = $this->input->post('id_personal');
		if(!empty($arr)){
			$upd = $this->Main_model->process_data('tb_personal',array('ba' => 1),array('id' => $id_personal));
			if($upd){
				foreach($arr as $row){
					$data = array(
						'cek_ba' => 1
					);
					$this->Main_model->process_data('detail_klasifikasi',$data,array('id' => $row['id']));
				}
				$status = true;
				$message="Pengecekan selesai dilakukan";
				notifikasi_pengurus();	
			}else{
				$status=false;
				$message="Pengecekan gagal dilakukan";
			}
		}else{
			$status = false;
			$message="Belum ada yang dipilih";
		}
		echo json_encode(array('status' => $status,'message' => $message));
	}

	function skt(){
		get_login();
		get_page();
		$header['title'] ="Berita Acara SKT";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/berita_acara.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('berita_acara/skt');
		$this->load->view('template/footer',$footer);
	}

	function data_berita_acara_skt(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Berita_acara_model->json_berita_acara_skt($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function process_ba_skt(){
		get_login();
		$arr = $this->input->post('detail');
		$id_personal = $this->input->post('id_personal');
		if(!empty($arr)){
			$upd = $this->Main_model->process_data('tb_personal',array('ba' => 1),array('id' => $id_personal));
			if($upd){
				foreach($arr as $row){
					$data = array(
						'cek_ba' => 1
					);
					$this->Main_model->process_data('detail_klasifikasi',$data,array('id' => $row['id']));
				}
				$status = true;
				$message="Pengecekan selesai dilakukan";
				notifikasi_pengurus();
			}else{
				$status=false;
				$message="Pengecekan gagal dilakukan";
			}
		}else{
			$status = false;
			$message="Belum ada yang dipilih";
		}
		echo json_encode(array('status' => $status,'message' => $message));
	}
}