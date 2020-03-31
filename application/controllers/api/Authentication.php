<?php
date_default_timezone_set('Asia/Jakarta');
class Authentication extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('api/Authentication_model');
	}
	function login(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$params = get_params();
			$response=[];
			$username = isset($params['username']) ? $params['username'] : '';
			$password = isset($params['password']) ? $params['password'] : '';

			if($username <> '' && $password <> ''){
    			$password = hash('sha256',$password);
				$user = $this->Authentication_model->login($username,$password);
				if($user){
					if($user->level == 12){
						$id = isset($user->id) ? $user->id : '';
						$nik = isset($user->nik) ? $user->nik : '';
						$nama = isset($user->nama) ? $user->nama : '';
						$username = isset($user->username) ? $user->username : '';
						$no_telp = isset($user->kontak) ? $user->kontak : '';
						$email = isset($user->email) ? $user->email : '';
						$image ='';
						if($user->foto_profil != '' and $user->foto_profil != null){
							$image = path_image_user().$image;
						}else{
							$image ='';
						}

	 					$response = array(
	 						'id' => $id,
	 						'nik' => $nik,
	 						'nama' => $nama,
	 						'username' => $username,
	 						'no_telp' => $no_telp,
	 						'email' => $email,
	 						'foto_profil' => $image
						);
						$status =200;
						$message='Berhasil';	
					}else{
						$status =400;
						$message="Maaf anda tidak mempunyai akses untuk masuk ke aplikasi";
					}
				}else{
					$status = 404;
					$message ='User tidak ditemukan di database';
				}
			}else{
				if($username == '' || $password == ''){
					$status=400;
					$message ='';
					if($username == ''){
						$message .='Username ';
					}
					if($password == ''){
						$message .='Password ';
					}
					$message .= 'tidak boleh kosong';
				}
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function get_profile(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id = isset($params['id']) ? $params['id'] : '';
			$user = $this->db->query("
					SELECT * FROM tb_user a where a.id = '$id'
				")->row();
			if($user){
			    $profil ='';
			    if($user->foto_profil != '' && $user->foto_profil != null){
			        $profil = base_url()."assets/uploads/user/".$user->foto_profil;
			    }else{
			        $profil ='';
			    }
				$response =array(
					'id' => $user->id,
					'nik' => $user->nik,
					'nama' => $user->nama,
					'alamat' => $user->alamat,
					'kontak' => $user->kontak,
					'email' => $user->email,
					'foto' => $profil
				);
    			$status = 200;
    			$message ='Berhasil';
    		}else{
    			$status =404;
    			$message ='User tidak ditemukan';
    		}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function process_user(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id = isset($params['id']) ? $params['id'] : '';
			$nama = isset($params['nama']) ? $params['nama'] : '';
			$no_telp = isset($params['no_telp']) ? $params['no_telp'] : '';
			$alamat = isset($params['alamat']) ? $params['alamat'] : '';
			$email = isset($params['email']) ? $params['email'] : '';

    		$data = array(
    			'nama' => $nama,
    			'kontak' => $no_telp,
    			'alamat' => $alamat,
    			'email' => $email,
    		);
    		$prosess = $this->Main_model->process_data('tb_user',$data,array('id' => $id));
    		if($prosess){
	    		$user= $this->Authentication_model->get_user($id);
    			$response = array(
					'id' => $user->id,
					'nama' => $user->nama,
					'kontak' => $user->kontak,
					'alamat' => $user->alamat,
					'email' => $user->email
				);
    			$status = 200;
    			$message ='Profil berhasil diupdate';
    		}else{
    			$status =500;
    			$message ='Internal server error';
    		}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function update_foto_profil(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id = isset($params['id']) ? $params['id'] : '';
			$foto_profil = isset($params['foto_profil']) ? $params['foto_profil'] : '';

		 	$random = random_string(10);
			$path = "assets/uploads/user/".$random.".png";
    		$actual = $random.".png";
    		$data = array(
    			'foto_profil' => $actual
    		);
    		$prosess = $this->Main_model->process_data('tb_user',$data,array('id' => $id));
    		if($prosess){
	    		file_put_contents($path,base64_decode($foto_profil));
    			$status = 200;
    			$message ='Berhasil berhasil berhasil';
    		}else{
    			$status =500;
    			$message ='Internal server error';
    		}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function update_password(){
		$response=[];
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$params = get_params();
			$id = isset($params['id']) ? $params['id'] : '';
			$password_lama = isset($params['password_lama']) ? $params['password_lama'] : '';
			$password_baru = isset($params['password_baru']) ? $params['password_baru'] : '';

			$du = $this->db->get_where('tb_user',array('id' =>$id));
			$dur = $du->row();
			if(count($du) > 0){
				$vp = hash('sha256',$password_lama);
				if($vp != $dur->password){
					$status = 400;
					$message='Password lama tidak sesuai dengan database';
				}else{
    				$password = hash('sha256',$password_baru);
		    		$data = array(
		    			'password' => $password,
		    		);
		    		$prosess = $this->Main_model->process_data('tb_user',$data,array('id' => $id));
		    		if($prosess){
		    			$status = 200;
		    			$message ='Password berhasil diganti';
		    		}else{
		    			$status =500;
		    			$message ='Internal server error';
		    		}
				}
			}else{
				$status=404;
				$message='User tidak ditemukan';
			}

			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}

	function update_fcm(){
		$auth = $this->auth->check_authentication('POST',false);
		if($auth == true){
			$response=[];
			$params = get_params();
			$id = isset($params['id']) ? $params['id'] : '';
			$fcm = isset($params['fcm_id']) ? $params['fcm_id'] : '';
			$data= array(
				'fcm_id' => $fcm
			);
			$process = $this->Main_model->process_data('tb_user',$data,array('id' => $id));
			if($process){
				$status=200;
				$message ='Berhasil';
			}else{
				$status=404;
				$message ='Internal server error';
			}
			print_json($status,$message,$response);
            log_api($params, '', $status, $message, $response);
		}
	}
}