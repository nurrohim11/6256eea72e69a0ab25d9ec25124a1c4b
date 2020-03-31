<?php
date_default_timezone_set('Asia/Jakarta');

class Master extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Master_model');
	}

	function jabatan(){
		get_login();
		get_page();
		$header['title'] ="Data Jabatan";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/master.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('master/jabatan');
		$this->load->view('template/footer',$footer);
	}

	function data_jabatan(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Master_model->json_jabatan($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function process_jabatan(){
		$id = $this->input->post('id');
		$jabatan = $this->input->post('jabatan');
		if(empty($id)){
			$data = array(
				'jabatan' => $jabatan,
				'user_insert' => $this->session->userdata('username'),
				'insert_at' => date('Y-m-d H:i:s')
			);
			$save = $this->Main_model->process_data('ms_jabatan',$data);
			if($save){
				$status =true;
				$message ="Data berhasil ditambah";
			}else{
				$status =false;
				$message ="Data gagal ditambah";
			}
		}else{
			$data = array(
				'jabatan' => $jabatan,
				'user_update' => $this->session->userdata('username'),
				'update_at' => date('Y-m-d H:i:s')
			);
			$save = $this->Main_model->process_data('ms_jabatan',$data,array('id' => $id));
			if($save){
				$status =true;
				$message ="Data berhasil ditambah";
			}else{
				$status =false;
				$message ="Data gagal ditambah";
			}
		}
		echo json_encode(array('status' => $status,'message' => $message));
	}

	function edit_jabatan(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
			$id = $this->input->get('id');
			$response=[];
			$dt = $this->db->get_where('ms_jabatan',array('id' => $id))->row();
			if($dt){
				$response = $dt;
				$status = true;
				$message="Berhasil";
			}else{
				$status = false;
				$message="Ooops....";
			}
			echo json_encode(array('status' => $status,'message' => $message,'response' => $response));
        }
	}

	function delete_jabatan(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
			$id = $this->input->get('id');
			$upd= $this->Main_model->process_data('ms_jabatan',array('status' => 0),array('id' => $id));
			if($upd){
				$status = true;
				$message="Data berhasil dihapus";
			}else{
				$status=false;
				$message ="Data gagal dihapus";
			}
			echo json_encode(array('status' => $status,'message' => $message));
        }
	}
}	