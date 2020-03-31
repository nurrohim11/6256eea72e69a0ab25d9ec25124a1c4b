<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function index()
    {
        $is_login = $this->Main_model->is_login();
        if ($is_login == FALSE) {
            $this->load->view('main/login');
        } else {
            redirect('main/dashboard');
        }
    }

	public function dashboard()
	{
        get_login();
        get_page();
		$header['title'] ="Dashboard";
		$footer['js'] = '<script src="'.base_url().'assets/pages/scripts/dashboard.js" type="text/javascript"></script>';
		$this->load->view('template/header',$header);
		$this->load->view('main/dashboard');
		$this->load->view('template/footer',$footer);
	}

	function login(){
		$this->load->view('main/login');
	}

	function proses_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $username = $this->db->escape_str($username);
        $password = $this->db->escape_str($password);
        $url = '';
        if ($username == '' || $password == '') {
            $message = 'Masukkan';
            if ($username == '') $message .= ' Username, ';
            if ($password == '') $message .= ' Password';

            $message = $message;
            $status = 404;
        } else {
            $data = $this->Main_model->login($username, $password);
            if (!empty($data)) {
                $sess = session_user(20);
                $url = base_url().'main/dashboard'.'?sess='.$sess;
                $session = array(
                    'id_user' => isset($data->id) ? $data->id : '',
                    'username' => isset($data->username) ? $data->username : '',
                    'nama' => isset($data->nama) ? $data->nama : '',
                    'nik' =>isset($data->nik) ? $data->nik : '',
                    'level' => isset($data->level) ? $data->level : '',
                );
                $upd = $this->Main_model->process_data('tb_user',array('sess' => $sess),array('id' => $data->id));
                $this->session->set_userdata($session);
                $status=200;
                $message="Login success, please wait..!!";
            } else {
                $status = 404;
                $message = 'Username / Password anda salah';
            }
        }

        $result = array(
            'status' => $status,
            'message' => $message,
            'url' => $url
        );

        echo json_encode($result);
	}
	function logout(){
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('nik');
        $this->session->unset_userdata('level');
        redirect(base_url());
	}

    function user(){
        get_login();
        get_page();
        $header['title'] ="User";
        $header['css'] = css_datepicker().css_select2().css_datatable().css_tree();
        $footer['js'] = js_datepicker().js_select2().js_datatable().js_tree().'<script src="'.base_url().'assets/apps/js/user.js" type="text/javascript"></script>';
        $data['level'] = $this->Main_model->ms_level();
        $data['jabatan'] = $this->Main_model->ms_jabatan();
        $data['assosiasi'] = $this->Main_model->ms_assosiasi();
        $this->load->view('template/header',$header);
        $this->load->view('main/user',$data);
        $this->load->view('template/footer',$footer);
    }
    function data_user(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Main_model->json_user($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
    }

    function delete_user(){
        get_login();
        $is_ajax= $this->input->is_ajax_request();
        if($is_ajax){
            $id = $this->input->get('id');
            $userid = userId();
            if($userid == $id){
                $status=false;
                $message="Maaf, anda tidak bisa menghapus data sendiri";
            }else{
                $upd = $this->Main_model->process_data('tb_user',array('status' =>0),array('id' => $id));
                if($upd){
                    $status=true;
                    $message="Data user berhasil dihapus";
                }else{
                    $status=false;
                    $message="Data user gagal dihapus";
                }
            }

            echo json_encode(array('status' => $status,'message' => $message));
        }else{
            show_404();
        }
    }

    function prosess_user(){
        $id = $this->input->post('id');
        $nik = $this->input->post('nik');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $kontak = $this->input->post('kontak');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = hash('sha256',$password);
        $level = $this->input->post('level');
        $jabatan = ($this->input->post('jabatan')) ? $this->input->post('jabatan') : 0;
        $assosiasi = ($this->input->post('assosiasi')) ? $this->input->post('assosiasi') : 0;
        $cek=$this->db->get_where('tb_user',array('username' =>$username))->result();
        if(!empty($id)){
            $data= array();
            if(!empty($password)){
                $data= array(
                    'nik' => $nik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'kontak' => $kontak,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    'level' => $level,
                    'kode' => $assosiasi,
                    'id_jabatan' => $jabatan,
                    'user_update' =>username(),
                    'update_at' => date('Y-m-d H:i:s'),
                );   
            }else{
                $data= array(
                    'nik' => $nik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'kontak' => $kontak,
                    'email' => $email,
                    'username' => $username,
                    'level' => $level,
                    'kode' => $assosiasi,
                    'id_jabatan' => $jabatan,
                    'user_update' =>username(),
                    'update_at' => date('Y-m-d H:i:s'),
                );
            }
            $upd = $this->Main_model->process_data('tb_user',$data,array('id' => $id));
            if($upd){
                $status=true;
                $message="Data user berhasil diupdate";
            }else{
                $status=false;
                $message ="Data user gagal diupdate";
            }
        }else{

            if(count($cek) > 0){
                $status = false;
                $message="Username '".$username."' sudah ada yang memakai";
            }else{
                $data= array(
                    'nik' => $nik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'kontak' => $kontak,
                    'email' => $email,
                    'username' => $username,
                    'password' => $password,
                    'level' => $level,
                    'kode' => $assosiasi,
                    'id_jabatan' => $jabatan,
                    'user_insert' =>username(),
                    'insert_at' => date('Y-m-d H:i:s'),
                );
                $ins = $this->Main_model->process_data('tb_user',$data);
                if($ins){
                    $status=true;
                    $message="Data user berhasil ditambah";
                }else{
                    $status=false;
                    $message ="Data user gagal ditambahkan";
                }
            }
        }
        echo json_encode(array('status' => $status,'message' => $message));
    }

    function edit_user(){
        $id = $this->input->get('id');
        $dt  = $this->db->get_where('tb_user',array('id' => $id))->row();
        $response=[];
        if($dt){
            $response = $dt;
            $status = true;
            $message="Berhasil";
        }else{
            $status = false;
            $message="User tidak ditemukan";
        }
        echo json_encode(array('status' =>$status,'message' => $message,'response' => $response));
    }

    function id_user_menu(){
        get_login();
        $id = $this->input->get('id');
        $ms_user = $this->Main_model->view_by_id('tb_user', ['id' => $id], 'row');
        $username = isset($ms_user->username) ? $ms_user->username : '';
        $nama = isset($ms_user->nama) ? $ms_user->nama : '';
        $id_user = isset($ms_user->id) ? $ms_user->id : '';

        $ms_menu = $this->Main_model->json_menu($username);

        echo json_encode([
            'menu' => $ms_menu, 
            'id' => $id_user,
            'nama' => $nama
        ]);
    }

    function update_menu(){
        get_login();
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id_user');
            $checked = $this->input->post('checked');

            if ($id == '' || $checked == '') {
                $status = 0;
                $message = '';

                $message .= ($id == '') ? 'User tidak ditemukan <br/>' : '';
                $message .= ($checked == '') ? 'Menu harus dipilih <br />' : '';
            } else {
                $update = $this->Main_model->edit_menu($id, $checked);
                if ($update) {
                    $status = true;
                    $message = 'Data berhasil diupdate';
                } else {
                    $status = false;
                    $message = 'Gagal mengupdate data';
                }
            }

            $result = array(
                'status' => $status,
                'message' => $message
            );
            // return json result
            echo json_encode($result);
        }
    }

    function assesor(){
        get_login();
        get_page();
        $header['title'] ="Assesor";
        $header['css'] = css_datepicker().css_select2().css_datatable().css_tree();
        $footer['js'] = js_datepicker().js_select2().js_datatable().js_tree().'<script src="'.base_url().'assets/apps/js/user.js" type="text/javascript"></script>';

        $this->load->view('template/header',$header);
        $this->load->view('main/assesor');
        $this->load->view('template/footer',$footer);
    }

    function data_assesor(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Main_model->json_assesor($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
    }

    function process_assesor(){
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $ket = $this->input->post('ket');

        $data= array(
            'nama' => $nama,
            'alamat' => $alamat,
            'tgl_lahir' => $tgl_lahir,
            'ket' => $ket
        );
        if(!empty($id)){
            $upd = $this->Main_model->process_data('ms_assesor',$data,array('id' => $id));
            if($upd){
                $status=true;
                $message="Assesor berhasil di update";
            }else{
                $status=false;
                $message="Assesor gagal diupdate";
            }
        }else{
            $ins = $this->Main_model->process_data('ms_assesor',$data);
            if($ins){
                $status=true;
                $message="Assesor berhasil di masukkan";
            }else{
                $status=false;
                $message="Assesor gagal di masukkan";
            }
        }
        echo json_encode(array('status' => $status,'message'=>$message));
    }

    function delete_assesor(){
        $id = $this->input->get('id');
        if($this->input->is_ajax_request()){
            $del = $this->Main_model->process_data('ms_assesor',array('status' => 0),array('id' => $id));
            if($del){
                $status =true;
                $message="Assesor berhasil dihapus";
            }else{
                $status=false;
                $message="Assesor gagal di hapus";
            }
            echo json_encode(array('status' =>$status,'message' => $message));
        }else{
            show_404();
        }
    }

    function edit_assesor(){
        get_login();
        if($this->input->is_ajax_request()){
            $id = $this->input->get('id');
            $ass = $this->db->get_where('ms_assesor',array('id' => $id))->row();
            if($ass){
                echo json_encode(array('status' => true,'message' =>'Berhasil','response'=>$ass));
            }else{
                echo json_encode(array('status' => false,'message' =>'Gagal','response'=>[]));
            }
        }else{
            show_404();
        }
    }
}
