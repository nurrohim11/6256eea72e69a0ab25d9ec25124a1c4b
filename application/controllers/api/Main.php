<?php

class Main extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('api/Dashboard_model');
	}

	function dashboard(){
		$auth = $this->auth->check_authentication('GET',false);
		if($auth){
			$response=[];
			// $user_id = isset($params['user_id']) ? $params['user_id'] : '';
			$sbu = $this->Dashboard_model->total_sbu();
			$ska = $this->Dashboard_model->total_ska();
			$skt = $this->Dashboard_model->total_skt();
			$response = array(
				'jml_sbu' => $sbu->jml,
				'jml_ska' => $ska->jml,
				'jml_skt' => $skt->jml,
			);
			$status = 200;
			$message="Berhasil";
			print_json($status,$message,$response);
		}
	}
}