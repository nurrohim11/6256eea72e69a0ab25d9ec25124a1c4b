<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_Model extends CI_Model {
    
    function login($username='', $password='')
    {
    	$pass = hash('sha256',$password);
        $query = $this->db->where('username', $username)
                    ->where('password', $pass)
                    ->where('status',1)
                    ->get('tb_user')
                    ->row();
        // print_r($query);
        return $query;
    }

    function is_valid_page()
    {
        $class = $this->router->fetch_class();

        $method = $this->router->fetch_method();
        
        // $token = $this->input->get('sess');
        
        $query = $this->db->query("
            SELECT *
            FROM tb_menu a
            WHERE a.`fungsi` = '$class'
            AND a.`method` = '$method'")->row();

        $result = ($query) ? TRUE : FALSE;

        return $result;
    }

    function get_page(){
        $is_valid_page = $this->is_valid_page();
        if ($is_valid_page == FALSE) {
            show_404();
        }
    }

    function is_login() 
    {
        $username = $this->session->userdata('username');
        $id_user = $this->session->userdata('id_user');
        $nik = $this->session->userdata('nik');
        $nama = $this->session->userdata('nama');
        $level = $this->session->userdata('level');

        $query = $this->db->where('username', $username)
                    ->where('id', $id_user)
                    ->where('nik',$nik)
                    ->where('nama',$nama)
                    ->where('level',$level)
                    ->where('status',1)
                    ->get('tb_user')
                    ->row();

        if (! empty($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_login()
    {
        $is_login = $this->is_login();
        if ($is_login == FALSE) {
            redirect('main/logout');
        }
    }

    function process_data($table='', $data='', $condition='') 
    {
        if($condition) {
            return $this->db->where($condition)->update($table, $data);
        } else {
            return $this->db->insert($table, $data);
        }
    }

    function view_by_id($table='',$condition='',$row='row')
    {
        if($row == 'row') {
            if($condition) {
                return $this->db->where($condition)->get($table)->row();
            } else {
                return $this->db->get($table)->row();
            }
        } else {
            if($condition) {
                return $this->db->where($condition)->get($table)->result();
            } else {
                return $this->db->get($table)->result();
            }
        }
    }

    function ms_user($level){
        return $this->db->query("
                SELECT a.*,b.nama as assosiasi FROM tb_user a 
                join ms_assosiasi b
                    on b.kode =a.kode
                where a.level=2
                and a.status=1
            ")->result();
    }

    function ms_assosiasi(){
        return $this->db->query("
                SELECT * from ms_assosiasi
            ")->result();
    }

    function json_user($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_user($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_user($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_user($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $level =level();
                $menu='';
                if($level==1){
                    $menu='<button type="button" class="btn btn-info btn-xs btn-sm" onclick="edit_menu('.$val->id.')"><i class="fa fa-list"></i></button>';
                }else{
                    $menu='';
                }
                $kode='';
                if($val->kode != 0){
                    $kode = ' | '.$val->nama_assosiasi;
                }else{
                    $kode ='';
                }
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    $val->username,
                    $val->alamat,
                    $val->kontak,
                    // $val->email,
                    '<span style="background:#'.$val->label.'; color:#fff; padding:1px 5px; font-size:10px; border-radius:3px !important">'.$val->level_user.$kode.'</span>',
                    '<button type="button" class="btn btn-warning btn-xs btn-sm" onclick="edit_user('.$val->id.')"><i class="fa fa-edit"></i></button>'.$menu.'<button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_user('.$val->id.')"><i class="fa fa-trash"></i></button>'
                );
            }
        }

        $arr = array(
            'draw' => $draw,
            'recordsFiltered' => $total_filtered,
            'recordsTotal' => $total,
            'data' => $data
        );

        return $arr;
    }
    function view_user($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'a.username';
        $arr_order[4] = 'a.alamat';
        $arr_order[5] = 'a.kontak';
        $arr_order[6] = 'a.email';
        $arr_order[7] = 'b.level';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_user($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,b.level as level_user,b.label, c.nama as nama_assosiasi, c.nama_lengkap
            FROM tb_user a
            join ms_level b
                on a.level = b.id
            left join ms_assosiasi c
                on c.kode = a.kode
            where a.status=1 
            $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_user($search=''){
        $condition = '';
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            FROM tb_user a
            where a.status=1 $condition")->row();
    }

    function ms_level(){
        return $this->db->query("
                SELECT * FROM ms_level
            ")->result();
    }

    function ms_jabatan(){
        return $this->db->query("
                SELECT * FROM ms_jabatan a where a.status=1
            ")->result();
    }

    function menu($parent=0,$user_name=''){
        return $this->db->query("
                SELECT a.*, COALESCE(Deriv1.`Count`,0) hitung,
                CASE WHEN (c.id_menu <> '') 
                    THEN TRUE 
                    ELSE FALSE 
                END AS checked 
                FROM `tb_menu` a  
                LEFT OUTER JOIN (
                    SELECT parent, COUNT(*) AS COUNT 
                    FROM `tb_menu` 
                    GROUP BY parent
                ) Deriv1 ON a.`id` = Deriv1.`parent` 
                LEFT JOIN (
                    SELECT id_menu 
                    FROM tb_user_menu
                    WHERE tb_user_menu.`usr_name` = '$user_name'
                ) AS c ON c.id_menu = a.`id`
                WHERE a.`level` = 0
                AND a.`status` = 1 
                AND a.`parent` = '$parent' 
                ORDER BY a.`urutan` ASC
            ")->result();
    }

    function json_menu($user_name='', $parent='0', $level='0')
    {
        $result = $this->menu($parent, $user_name);
        $arr = array();
        if (!empty($result)) {
            foreach ($result as $row => $val) {
                $arr[$row] = array(
                    'text' => $val->label,
                    'id' => $val->id,
                    'icon' => $val->icon
                );

                if($val->checked == 1 && $val->hitung == 0) {
                    $arr[$row]['state'] = array(
                        'selected' => true,
                        'opened' => true
                    );
                }

                if ($val->hitung > 0) {
                    $arr[$row]['children'] = $this->json_menu($user_name, $val->id, $level + 1);
                }
            }

            $select = $this->db->query("
                SELECT * 
                FROM tb_user_menu 
                WHERE usr_name = '$user_name'")->result();

        }

        return $arr;
    }

    function edit_menu($id = '', $menu = '')
    {
        $this->db->trans_begin();
        $ms_user = $this->db->where('id', $id)
                    ->get('tb_user')
                    ->row();
        $username = isset($ms_user->username) ? $ms_user->username : '';

        # parsing menu
        $parse_menu = explode(',', $menu);
        $arr_menu = [];
        if ($parse_menu) {
            foreach ($parse_menu as $key => $val) {
                if ($val != '') {
                    $arr_menu[] = $val;
                }
            }
        }

        $this->db->where('usr_name', $username)->delete('tb_user_menu');
        if ($arr_menu) {
            for ($i = 0; $i < count($arr_menu); $i++) {
                $val = isset($arr_menu[$i]) ? $arr_menu[$i] : '';
                if ($val != '') {
                    $this->db->insert('tb_user_menu', [
                        'usr_name' => $username, 
                        'id_menu' => $val, 
                        'user_insert' => username()
                    ]);
                }
            }
        }

        if ($this->db->trans_status() == true) {
            $this->db->trans_commit();

            return true;
        } else {
            $this->db->trans_rollback();

            return false;
        }
    }
    function json_assesor($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_assesor($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_assesor($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_assesor($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $level =level();

                $data[$row] = array(
                    $no++,
                    $val->nama,
                    $val->alamat,
                    $val->tgl_lahir,
                    $val->jenis,
                    '<button type="button" class="btn btn-warning btn-xs btn-sm" onclick="edit_assesor('.$val->id.')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_assesor('.$val->id.')"><i class="fa fa-trash"></i></button>'
                );
            }
        }

        $arr = array(
            'draw' => $draw,
            'recordsFiltered' => $total_filtered,
            'recordsTotal' => $total,
            'data' => $data
        );

        return $arr;
    }
    function view_assesor($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[1] = 'a.nama';
        $arr_order[2] = 'a.alamat';
        $arr_order[3] = 'a.tgl_lahir';
        $arr_order[4] = 'a.jenis';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_assesor($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,
          (CASE 
            when a.ket = 1 then 'Tenaga Kerja'
            else 'Badan Usaha'
            end
            ) as jenis
          from ms_assesor a
            where a.status=1 
            $condition
            $order
            LIMIT $start, $length
        ")->result();

    }

    function jumlah_assesor($search=''){
        $condition = '';
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            FROM ms_assesor a
            where a.status=1 $condition")->row();
    }

}