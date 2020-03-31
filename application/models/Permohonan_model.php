<?php
class Permohonan_model extends CI_Model{

	function ms_kota(){
		return $this->db->query("SELECT * FROM ms_kota a where a.status=1")->result();
	}

	function ms_kbli(){
		return $this->db->query("SELECT * FROM ms_kbli")->result();
	}

    function json_permohonan_sbu($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $token = $this->db->escape_str($token);

        $total_filtered = $this->jumlah_permohonan_sbu($search,$token);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan_sbu($search,$token);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_permohonan_sbu($start, $length, $search, $column, $dir,$token);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $data[$row] = array(
                    $no++,
                    $val->npwp,
                    $val->nama_bu,
                    rupiah($val->total_biaya),
                    '<button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_bu('.$val->id.')"><i class="fa fa-trash"></i></button>'
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
    function view_permohonan_sbu($start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
        	$condition .= ' AND';
        	$condition .= " a.token_permohonan ='$token'";
        }

        $arr_order[1] = 'a.npwp';
        $arr_order[2] = 'a.nama_bu';
        $arr_order[3] = 'total_biaya';
        $arr_order[4] = 'a.insert_at';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan_sbu($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id,a.npwp,a.nama_bu, ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya ,a.insert_at
			from tb_bidang_usaha a
			left join (
				SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_kontruksi,b.token_klasifikasi
				from detail_klasifikasi b
				GROUP by b.token_klasifikasi
			) as detail
			on a.token_klasifikasi = detail.token_klasifikasi
            left join (
                SELECT SUM(b.lpjkp+b.lpjkn) as total_pengembangan,b.token_klasifikasi
                from tb_biaya_pengembangan b
                GROUP by b.token_klasifikasi
            ) as p
            on a.token_klasifikasi = p.token_klasifikasi
            where a.status=1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_permohonan_sbu($search='',$token=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
        	$condition .= ' AND';
        	$condition .= " a.token_klasifikasi ='$token'";
        }


        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_bidang_usaha a
			left join (
				SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_biaya,b.token_klasifikasi
				from detail_klasifikasi b
				GROUP by b.token_klasifikasi
			) as detail
			on a.token_klasifikasi = detail.token_klasifikasi
            where a.status=1 $condition ")->row();
    }


    function json_permohonan_ska($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $token = $this->db->escape_str($token);

        $total_filtered = $this->jumlah_permohonan_ska($search,$token);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan_ska($search,$token);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_permohonan_ska($start, $length, $search, $column, $dir,$token);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    rupiah($val->total_biaya),
                    '<button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_personal_ska('.$val->id.')"><i class="fa fa-trash"></i></button>'
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
    function view_permohonan_ska($start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= ' AND';
            $condition .= " a.token_permohonan ='$token'";
        }

        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'total_biaya';
        $arr_order[4] = 'a.insert_at';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan_ska($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id,a.nik,a.nama, ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.insert_at
            from tb_personal a
            left join (
                SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_kontruksi,b.token_klasifikasi
                from detail_klasifikasi b
                GROUP by b.token_klasifikasi
            ) as detail
            on a.token_klasifikasi = detail.token_klasifikasi
            left join (
                SELECT SUM(b.lpjkp+b.lpjkn) as total_pengembangan,b.token_klasifikasi
                from tb_biaya_pengembangan b
                GROUP by b.token_klasifikasi
            ) as p
            on a.token_klasifikasi = p.token_klasifikasi
            where a.status=1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_permohonan_ska($search='',$token=''){
        $condition = '';
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= ' AND';
            $condition .= " a.token_permohonan ='$token'";
        }


        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
            left join (
                SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_biaya,b.token_klasifikasi
                from detail_klasifikasi b
                GROUP by b.token_klasifikasi
            ) as detail
            on a.token_klasifikasi = detail.token_klasifikasi
            where a.status=1 $condition")->row();
    }


    function json_permohonan_skt($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $token = $this->db->escape_str($token);

        $total_filtered = $this->jumlah_permohonan_skt($search,$token);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan_skt($search,$token);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_permohonan_skt($start, $length, $search, $column, $dir,$token);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    rupiah($val->total_biaya),
                    '<button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_personal_skt('.$val->id.')"><i class="fa fa-trash"></i></button>'
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
    function view_permohonan_skt($start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= ' AND';
            $condition .= " a.token_permohonan ='$token'";
        }

        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'total_biaya';
        $arr_order[4] = 'a.insert_at';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan_skt($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id,a.nik,a.nama, ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.insert_at
            from tb_personal a
            left join (
                SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_kontruksi,b.token_klasifikasi
                from detail_klasifikasi b
                GROUP by b.token_klasifikasi
            ) as detail
            on a.token_klasifikasi = detail.token_klasifikasi
            left join (
                SELECT SUM(b.lpjkp+b.lpjkn) as total_pengembangan,b.token_klasifikasi
                from tb_biaya_pengembangan b
                GROUP by b.token_klasifikasi
            ) as p
            on a.token_klasifikasi = p.token_klasifikasi
            where a.status=1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_permohonan_skt($search='',$token=''){
        $condition = '';
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= ' AND';
            $condition .= " a.token_permohonan ='$token'";
        }


        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
            left join (
                SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_biaya,b.token_klasifikasi
                from detail_klasifikasi b
                GROUP by b.token_klasifikasi
            ) as detail
            on a.token_klasifikasi = detail.token_klasifikasi
            where a.status=1 $condition")->row();
    }

    function json_permohonan($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_permohonan($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_permohonan($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $delete ='';
                $level = level();
                if($level == 1){
                    $delete ='<button type="button" class="btn btn-danger btn-xs btn-sm btn-no-margin" onclick="delete_permohonan('.$val->id.')"><i class="fa fa-trash-o"></i></button>';
                }else if($level == 2){
                    if($val->keuangan == 0){
                        $delete ='<button type="button" class="btn btn-danger btn-xs btn-sm btn-no-margin" onclick="delete_permohonan('.$val->id.')"><i class="fa fa-trash-o"></i></button>';
                    }else{
                        $delete='';
                    }    
                }else if($level == 3){
                    if($val->rekomendasi == 0){
                        $delete ='<button type="button" class="btn btn-danger btn-xs btn-sm btn-no-margin" onclick="delete_permohonan('.$val->id.')"><i class="fa fa-trash-o"></i></button>';
                    }else{
                        $delete='';
                    }
                }else{
                    $delete='';
                }
                

                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                    $download = '<button type="button" target="_blank" class="btn btn-info btn-xs btn-sm btn-no-margin" onclick="download_file('.$val->id.',0)"><i class="fa fa-download"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                    $download = '<button type="button" target="_blank" class="btn btn-info btn-xs btn-sm btn-no-margin" onclick="download_file('.$val->id.',1)"><i class="fa fa-download"></i></button>';
                }

                $btn =$view.$download.$delete;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tipe_permohonan,
                    rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_permohonan($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.insert_at';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[6] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();
        if($level ==2){
            $query =$this->db->query("
                SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
                c.assosiasi
                from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.id_assosiasi ='$id' $condition
                $order
                LIMIT $start, $length");
        }else{
            $query =$this->db->query("
                SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
                c.assosiasi
                from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 $condition
                $order
                LIMIT $start, $length");
        }
        return $query->result();

    }

    function jumlah_permohonan($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $level = level();
        $id = userId();
        if($level ==2){
            $query =$this->db->query("
                SELECT  COUNT(*) as jumlah
                from tb_permohonan a
                    join ms_tipe_permohonan b
                        on b.kode = a.type
                    join (
                        select d.id,d.nama, e.kode, e.nama as assosiasi 
                        from tb_user d
                        join ms_assosiasi e
                            on d.kode = e.kode
                    ) c
                        on c.id = a.id_assosiasi
                    where a.status =1 and a.id_assosiasi ='$id' $condition");
        }else{
            $query =$this->db->query("
                SELECT COUNT(*) as jumlah
                from tb_permohonan a
                    join ms_tipe_permohonan b
                        on b.kode = a.type
                    join (
                        select d.id,d.nama, e.kode, e.nama as assosiasi 
                        from tb_user d
                        join ms_assosiasi e
                            on d.kode = e.kode
                    ) c
                        on c.id = a.id_assosiasi
                    where a.status =1 $condition");
        }
        return $query->row();
    }

    function total_biaya($token_permohonan='',$type=''){
    	if($type == 0){
    		$query = $this->db->query("
    			SELECT m.total_biaya as jml from(
	    			SELECT ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.token_permohonan
						from tb_bidang_usaha a
						left join (
							SELECT ifnull(SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn),0) as total_kontruksi,b.token_klasifikasi
							from detail_klasifikasi b
							GROUP by b.token_klasifikasi
						) as detail
                        on a.token_klasifikasi = detail.token_klasifikasi
                        left join (
                            SELECT ifnull(SUM(b.lpjkp+b.lpjkn),0) as total_pengembangan,b.token_klasifikasi
                            from tb_biaya_pengembangan b
                            GROUP by b.token_klasifikasi
                        ) as p
                        on a.token_klasifikasi = p.token_klasifikasi
			            where a.status=1
			        ) as m
			        where m.token_permohonan = '$token_permohonan'
    			")->row();
    		$jumlah = ($query->jml) ? $query->jml : 0;
    	}else if($type == 1){
    		$query = $this->db->query("
    			SELECT SUM(m.total_biaya) as jml from(
	    			SELECT ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.token_permohonan
						from tb_personal a
						left join (
							SELECT ifnull(SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn),0) as total_kontruksi,b.token_klasifikasi
							from detail_klasifikasi b
							GROUP by b.token_klasifikasi
						) as detail
						on a.token_klasifikasi = detail.token_klasifikasi
                        left join (
                            SELECT ifnull(SUM(b.lpjkp+b.lpjkn),0) as total_pengembangan,b.token_klasifikasi
                            from tb_biaya_pengembangan b
                            GROUP by b.token_klasifikasi
                        ) as p
                        on a.token_klasifikasi = p.token_klasifikasi
			            where a.status=1
			        ) as m 
			        where m.token_permohonan = '$token_permohonan'
    			")->row();
    		$jumlah = $query->jml;
    	}else if($type == 2){
    		$query = $this->db->query("
    			SELECT SUM(m.total_biaya) as jml from(
	    			SELECT ifnull(detail.total_kontruksi,0) + ifnull(p.total_pengembangan,0) as total_biaya,a.token_permohonan
						from tb_personal a
						left join (
							SELECT SUM(b.biaya+b.biaya_lpjkp+b.biaya_lpjkn) as total_kontruksi,b.token_klasifikasi
							from detail_klasifikasi b
							GROUP by b.token_klasifikasi
						) as detail
						on a.token_klasifikasi = detail.token_klasifikasi
                        left join (
                            SELECT SUM(b.lpjkp+b.lpjkn) as total_pengembangan,b.token_klasifikasi
                            from tb_biaya_pengembangan b
                            GROUP by b.token_klasifikasi
                        ) as p
                        on a.token_klasifikasi = p.token_klasifikasi
			            where a.status=1
			        ) as m 
			        where m.token_permohonan = $token_permohonan
    			")->row();
    		$jumlah = $query->jml;
    	}
    	return $jumlah;
    }

    function view_permohonan_bu($id){
        $query = $this->db->query("
                SELECT a.*,d.tipe_permohonan,c.assosiasi,c.nama,
                (
                    CASE 
                        WHEN a.keuangan = 0 then 'Belum di Approval'
                        when a.keuangan = 1 then 'Approved'
                        when a.keuangan = 2 then 'Rejected'
                        else ''
                        end
                ) as status_keuangan, e.nama as nama_approval, a.tgl_approval_keuangan,
                (
                    CASE 
                        WHEN a.rekomendasi = 0 then 'Belum di Rekomedasikan'
                        when a.rekomendasi = 1 then 'Recomended'
                        when a.rekomendasi = 2 then 'Not Recommended'
                        else ''
                        end
                ) as status_rekomendasi, f.nama as nama_rekomendasi, a.tgl_rekomendasi
                from tb_permohonan a
                join (
                    SELECT b.id,b.kode, b.nama,c.nama as assosiasi 
                    from tb_user b
                    join ms_assosiasi c
                        on c.kode = b.kode
                ) c
                    on a.id_assosiasi = c.id
                join ms_tipe_permohonan d
                    on d.kode = a.type
                left join tb_user e
                    on a.user_approval = e.id
                left join tb_user f
                    on a.user_rekomendasi = f.id
                where a.id = '$id'
            ")->row();
        return $query;
    }

    function bidang_usaha($token){
        $res=[];
        $bu = $this->db->query("
                SELECT a.*,b.kota as ket_kota, c.kbli as ket_kbli 
                from tb_bidang_usaha a
                join ms_kota b
                    on b.id = a.kota
                join ms_kbli c
                    on c.id = a.id_kbli
                where a.token_permohonan = $token
            ")->result();
        if($bu){
            foreach($bu as $row){
                $detail=[];
                $pengembangan=[];
                $token_klasifikasi = $row->token_klasifikasi;
                $query = $this->db->query("
                        SELECT a.*,b.deskripsi as deskripsi_klasifikasi, b.deskripsi_lengkap as deskripsi_lengkap_klasifikasi, b.kode as kode_klasifikasi,
                            c.deskripsi as deskripsi_sub_klasifikasi, c.lingkup_pekerjaan as lingkup_perkerjaan_sub_klasifikasi, c.kode as kode_sub_klasifikasi, 
                            d.kode as kode_kualifikasi, e.permohonan
                        from  detail_klasifikasi a
                        left join ms_klasifikasi b
                            on b.id = a.klasifikasi
                        left join ms_sub_klasifikasi c
                            on c.id = a.sub_klasifikasi
                        left join ms_kualifikasi d
                            on d.id = a.kualifikasi
                        left join ms_permohonan e
                            on e.id = a.id_permohonan
                        where a.token_klasifikasi = $token_klasifikasi
                    ")->result();
                foreach($query as $r){
                    $detail[]= array(
                        'klasifikasi' => $r->kode_klasifikasi,
                        'deskripsi_klasifikasi' => $r->deskripsi_klasifikasi,
                        'deskripsi_lengkap_klasifikasi' => $r->deskripsi_lengkap_klasifikasi,
                        'sub_klasifikasi' => $r->kode_sub_klasifikasi,
                        'deskripsi_sub_klasifikasi' => $r->deskripsi_sub_klasifikasi,
                        'lingkup_perkerjaan' => $r->lingkup_perkerjaan_sub_klasifikasi,
                        'kualifikasi' => $r->kode_kualifikasi,
                        'permohonan' => $r->permohonan,
                        'total_biaya' => $r->biaya+$r->biaya_lpjkp+$r->biaya_lpjkn,
                    );
                }
                $query_p = $this->db->query("
                        SELECT a.*,d.kode from tb_biaya_pengembangan a
                            join ms_klasifikasi d 
                                on d.id = a.id_klasifikasi
                            join tb_bidang_usaha b
                                on b.token_klasifikasi = a.token_klasifikasi
                            where a.token_klasifikasi = '$token_klasifikasi'
                    ")->result();

                foreach($query_p as $p){
                    $pengembangan[]= array(
                        'kode' => $p->kode,
                        'biaya_lpjkp' => $p->lpjkp,
                        'biaya_lpjkn' => $p->lpjkn
                    );
                }
                $res[]= array(
                    'id' => $row->id,
                    'token' => $row->token_permohonan,
                    'npwp' => $row->npwp,
                    'nama' => $row->nama_bu,
                    'kota' => ucfirst(strtolower($row->ket_kota)),
                    'alamat' => $row->alamat,
                    'kbli' => $row->ket_kbli,
                    'status_penilaian' => $row->penilaian,
                    'detail' =>$detail,
                    'pengembangan' => $pengembangan
                );
            }
        }else{
            $res=[];
        }
        return $res;
    }

    function detail_bidang_usaha($idp){
        $res=[];
        $query = $this->db->query("
                SELECT a.*,c.kota as ket_kota, d.kbli,e.nama as asosiasi FROM tb_bidang_usaha a
                join tb_permohonan b
                    on b.token_permohonan = a.token_permohonan
                left join ms_kota c
                    on c.id = a.kota
                left join ms_kbli d
                    on d.id = a.id_kbli
                left join (
                    select f.id,g.nama from tb_user f
                    join ms_assosiasi g
                        on f.kode = g.kode
                    where f.status =1
                ) e
                    on e.id = b.id_assosiasi
                where b.id = '$idp'
            ")->result();
        if($query){
            foreach($query as $row){
                $res[]= array(
                    'id' => $row->id,
                    'npwp' => $row->npwp,
                    'nama' => $row->nama_bu,
                    'kota'=> $row->ket_kota,
                    'alamat' => $row->alamat,
                    'penanggung_jawab' => $row->penanggung_jawab,
                    'kbli' => $row->kbli,
                    'asosiasi' => $row->asosiasi,
                    'token_klasifikasi' => $row->token_klasifikasi
                );
            }   
        }
        return $res;
    }

    function detail_personal($idp=''){
        $res=[];
        $query = $this->db->query("
                SELECT a.*,c.kota as ket_kota,e.nama as asosiasi 
                FROM tb_personal a
                join tb_permohonan b
                    on b.token_permohonan = a.token_permohonan
                left join ms_kota c
                    on c.id = a.kota
                left join (
                    select f.id,g.nama from tb_user f
                    join ms_assosiasi g
                        on f.kode = g.kode
                    where f.status =1
                ) e
                    on e.id = b.id_assosiasi
                where b.id = '$idp'
            ")->result();
        if($query){
            foreach($query as $row){
                $res[]= array(
                    'id' => $row->id,
                    'nik' => $row->nik,
                    'nama' => $row->nama,
                    'kota'=> $row->ket_kota,
                    'alamat' => $row->alamat,
                    'gender' => $row->jenis_kelamin,
                    'asosiasi' => $row->asosiasi,
                    'token_klasifikasi' => $row->token_klasifikasi
                );
            }   
        }
        return $res;
    }

    function view_permohonan_personal($id){
        $query = $this->db->query("
                SELECT a.*,d.tipe_permohonan,c.assosiasi,c.nama,
                (
                    CASE 
                        WHEN a.keuangan = 0 then 'Belum di Approval'
                        when a.keuangan = 1 then 'Approved'
                        when a.keuangan = 2 then 'Rejected'
                        else ''
                        end
                ) as status_keuangan, e.nama as nama_approval, a.tgl_approval_keuangan,
                (
                    CASE 
                        WHEN a.rekomendasi = 0 then 'Belum di Rekomedasikan'
                        when a.rekomendasi = 1 then 'Recomended'
                        when a.rekomendasi = 2 then 'Not Recommended'
                        else ''
                        end
                ) as status_rekomendasi, f.nama as nama_rekomendasi, a.tgl_rekomendasi
                from tb_permohonan a
                join (
                    SELECT b.id,b.kode, b.nama,c.nama as assosiasi 
                    from tb_user b
                    join ms_assosiasi c
                        on c.kode = b.kode
                ) c
                    on a.id_assosiasi = c.id
                join ms_tipe_permohonan d
                    on d.kode = a.type
                left join tb_user e
                    on a.user_approval = e.id
                left join tb_user f
                    on a.user_rekomendasi = f.id
                where a.id = '$id'
            ")->row();
        return $query;
    }

    function personal($token){
        $res=[];
        $personal = $this->db->query("
                SELECT a.* from tb_personal a
                where a.token_permohonan = $token
            ")->result();
        if($personal){
            foreach($personal as $row){
                $detail=[];
                $pengembangan=[];
                $token_klasifikasi = $row->token_klasifikasi;
                $query = $this->db->query("
                        SELECT a.*,b.deskripsi as deskripsi_klasifikasi, b.deskripsi_lengkap as deskripsi_lengkap_klasifikasi, b.kode as kode_klasifikasi,
                            c.deskripsi as deskripsi_sub_klasifikasi, c.lingkup_pekerjaan as lingkup_perkerjaan_sub_klasifikasi, c.kode as kode_sub_klasifikasi, 
                            d.kode as kode_kualifikasi, e.permohonan
                        from  detail_klasifikasi a
                        left join ms_klasifikasi b
                            on b.id = a.klasifikasi
                        left join ms_sub_klasifikasi c
                            on c.id = a.sub_klasifikasi
                        left join ms_kualifikasi d
                            on d.id = a.kualifikasi
                        left join ms_permohonan e
                            on e.id = a.id_permohonan
                        where a.token_klasifikasi = $token_klasifikasi
                    ")->result();
                foreach($query as $r){
                    $detail[]= array(
                        'klasifikasi' => $r->kode_klasifikasi,
                        'deskripsi_klasifikasi' => $r->deskripsi_klasifikasi,
                        'deskripsi_lengkap_klasifikasi' => $r->deskripsi_lengkap_klasifikasi,
                        'sub_klasifikasi' => $r->kode_sub_klasifikasi,
                        'deskripsi_sub_klasifikasi' => $r->deskripsi_sub_klasifikasi,
                        'lingkup_perkerjaan' => $r->lingkup_perkerjaan_sub_klasifikasi,
                        'kualifikasi' => $r->kode_kualifikasi,
                        'permohonan' => $r->permohonan,
                        'total_biaya' => $r->biaya+$r->biaya_lpjkp+$r->biaya_lpjkn,
                    );
                }
                $query_p = $this->db->query("
                        SELECT a.*,d.kode from tb_biaya_pengembangan a
                            join ms_klasifikasi d 
                                on d.id = a.id_klasifikasi
                            join tb_personal b
                                on b.token_klasifikasi = a.token_klasifikasi
                            where a.token_klasifikasi = '$token_klasifikasi'
                    ")->result();

                foreach($query_p as $p){
                    $pengembangan[]= array(
                        'kode' => $p->kode,
                        'biaya_lpjkp' => $p->lpjkp,
                        'biaya_lpjkn' => $p->lpjkn
                    );
                }
                $res[]= array(
                    'id' => $row->id,
                    'token' => $row->token_permohonan,
                    'token_klasifikasi' =>$row->token_klasifikasi,
                    'nik' => $row->nik,
                    'nama' => $row->nama,
                    'alamat' => $row->alamat,
                    'tgl_lahir' => $row->tgl_lahir,
                    'jenis_kelamin' => $row->jenis_kelamin,
                    'status_penilaian' => $row->penilaian,
                    'detail' =>$detail,
                    'pengembangan' => $pengembangan
                );
            }
        }else{
            $res=[];
        }
        return $res;
    }

    function json_permohonan_approval($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_permohonan_approval($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan_approval($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_permohonan_approval($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {

                $approval ='<button type="button" class="btn btn-success btn-xs btn-sm btn-no-margin" title="Approval permohonan" onclick="approval_permohonan('.$val->id.')"><i class="fa fa-check"></i></button>';

                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }

                $btn =$view.$approval;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tipe_permohonan,
                    rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_permohonan_approval($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.insert_at';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[6] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan_approval($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();

        $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
                c.assosiasi
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 0 $condition
                $order
                LIMIT $start, $length");
    
        return $query->result();

    }

    function jumlah_permohonan_approval($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 0 $condition");
    
        return $query->row();
    }

    function json_history_approval($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$start_date ='',$end_date =''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $start_date = $this->db->escape_str($start_date);
        $end_date = $this->db->escape_str($end_date);

        $total_filtered = $this->jumlah_history_approval($search,$start_date,$end_date);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_history_approval($search,$start_date,$end_date);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_history_approval($start, $length, $search, $column, $dir, $start_date, $end_date);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {

                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }

                $btn =$view;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tgl_approval_keuangan,
                    $val->approved_by,
                    $val->tipe_permohonan,
                    rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_history_approval($start = 0, $length = 0, $search = '', $column = '', $dir = '',$start_date='',$end_date=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' ";
            $condition .= ')';
        }

        if($start_date != '' && $end_date != ''){
            $condition .= 'AND (';
            $condition .= " date(a.tgl_approval_keuangan) between '$start_date' AND '$end_date'";
            $condition .= ')';
        }

        // print_r($condition);

        $arr_order[0] = 'a.tgl_approval_keuangan';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[5] = 'a.tgl_approval_keuangan';
        $arr_order[6] = 'approved_by';
        $arr_order[7] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_history_approval($search,$start_date,$end_date);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();

        $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
                c.assosiasi, d.nama as approved_by
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                join tb_user d
                    on d.id = a.user_approval
                where a.status =1 and a.keuangan = 1 $condition
                $order
                LIMIT $start, $length");
    
        return $query->result();

    }

    function jumlah_history_approval($search='',$start_date='',$end_date=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' ";
            $condition .= ')';
        }
        if($start_date != '' && $end_date != ''){
            $condition .= 'AND (';
            $condition .= " date(a.tgl_approval_keuangan) between '$start_date' AND '$end_date'";
            $condition .= ')';
        }


        $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                join tb_user d
                    on d.id = a.user_approval
                where a.status =1 and a.keuangan = 1 $condition");
    
        return $query->row();
    }

    function json_permohonan_rekomendasi($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$assosiasi=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $assosiasi = $this->db->escape_str($assosiasi);

        $total_filtered = $this->jumlah_permohonan_rekomendasi($search,$assosiasi);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_permohonan_rekomendasi($search,$assosiasi);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_rekomendasi_permohonan($start, $length, $search, $column, $dir,$assosiasi);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {

                // $approval ='<a onclick="return confirm("yakin akan menghapus data ini")" href="'.base_url().'Permohonan/proses_rekomendasi_permohonan?id='.$val->id.'" class="btn btn-success btn-xs btn-sm btn-no-margin" title="Rekomendasi permohonan" ><i class="fa fa-check"></i></a>';
                $approval ='<button type="button" class="btn btn-success btn-xs btn-sm btn-no-margin" title="Rekomendasi permohonan" onclick="rekomendasi_permohonan('.$val->id.')"><i class="fa fa-check"></i></button>';

                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }

                $btn =$view.$approval;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tipe_permohonan,
                    rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_rekomendasi_permohonan($start = 0, $length = 0, $search = '', $column = '', $dir = '',$assosiasi=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        if($assosiasi != ''){
            $condition .= " AND a.id_assosiasi='$assosiasi'";
        }

        $arr_order[0] = 'a.insert_at';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[6] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_permohonan_rekomendasi($search,$assosiasi);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();

        $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
            c.assosiasi
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=0 $condition
                $order
                LIMIT $start, $length");
    
        return $query->result();

    }

    function jumlah_permohonan_rekomendasi($search='',$assosiasi=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        if($assosiasi != ''){
            $condition .= " AND a.id_assosiasi='$assosiasi'";
        }


        $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=0 $condition");
    
        return $query->row();
    }

    function json_penilaian_permohonan($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_penilaian_permohonan($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_penilaian_permohonan($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_penilaian_permohonan($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }

                $btn =$view;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tipe_permohonan,
                    // rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_penilaian_permohonan($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.insert_at';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[6] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_penilaian_permohonan($search,$assosiasi);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();
        if($level == 5){
            $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
            c.assosiasi
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 and a.type=0 $condition
                $order
                LIMIT $start, $length");
        }else if($level == 6){
            $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
            c.assosiasi
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1  and a.type<>0 $condition
                $order
                LIMIT $start, $length");
        }else{
            $query =$this->db->query("
                SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
                c.assosiasi
                from tb_permohonan a
                    join ms_tipe_permohonan b
                        on b.kode = a.type
                    join (
                        select d.id,d.nama, e.kode, e.nama as assosiasi 
                        from tb_user d
                        join ms_assosiasi e
                            on d.kode = e.kode
                    ) c
                        on c.id = a.id_assosiasi
                    where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 $condition
                    $order
                    LIMIT $start, $length");
        }

    
        return $query->result();

    }

    function jumlah_penilaian_permohonan($search='',$assosiasi=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $level = level();
        $id = userId();
        if($level == 5){
            $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 and a.type=0 $condition
                ");
        }else if($level == 6){
            $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1  and a.type<>0 $condition
                ");
        }else{
            $query =$this->db->query("
                SELECT COUNT(*) as jumlah
                from tb_permohonan a
                    join ms_tipe_permohonan b
                        on b.kode = a.type
                    join (
                        select d.id,d.nama, e.kode, e.nama as assosiasi 
                        from tb_user d
                        join ms_assosiasi e
                            on d.kode = e.kode
                    ) c
                        on c.id = a.id_assosiasi
                    where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 $condition
                    ");
        }
        return $query->row();
    }

    function json_history_rekomendasi($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$start_date='', $end_date=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);
        $start_date = $this->db->escape_str($start_date);
        $end_date = $this->db->escape_str($end_date);

        $total_filtered = $this->jumlah_history_rekomendasi($search,$start_date,$end_date);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_history_rekomendasi($search,$start_date,$end_date);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_history_rekomendasi($start, $length, $search, $column, $dir,$start_date,$end_date);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                if($val->type == 0){                
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_bu('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }else{
                    $view = '<button type="button" class="btn btn-warning btn-xs btn-sm btn-no-margin" title="View permohonan" onclick="view_permohonan_personal('.$val->id.')"><i class="fa fa-reorder"></i></button>';
                }

                $btn =$view;
                $data[$row] = array(
                    $no++,
                    $val->no_invoice,
                    // $val->assosiasi.' | '.$val->nama,
                    $val->assosiasi,
                    $val->tgl_masuk,
                    $val->tgl_bayar,
                    $val->tgl_rekomendasi,
                    $val->rekomendasi_by,
                    $val->tipe_permohonan,
                    rupiah($this->total_biaya($val->token_permohonan,$val->type)),
                    $btn
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
    function view_history_rekomendasi($start = 0, $length = 0, $search = '', $column = '', $dir = '',$start_date='',$end_date=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.tgl_rekomendasi';
        $arr_order[1] = 'a.no_invoice';
        $arr_order[2] = 'c.nama';
        $arr_order[3] = 'a.tgl_berkas_masuk';
        $arr_order[4] = 'a.tgl_pembayaran';
        $arr_order[5] = 'a.tgl_rekomendasi';
        $arr_order[6] = 'rekomendasi_by';
        $arr_order[7] = 'b.tipe_permohonan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_history_rekomendasi($search,$assosiasi);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        $level = level();
        $id = userId();

        $query =$this->db->query("
            SELECT a.*,b.tipe_permohonan,c.nama,a.tgl_berkas_masuk as tgl_masuk, a.tgl_pembayaran as tgl_bayar,
            c.assosiasi, d.nama as rekomendasi_by
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                join tb_user d
                    on d.id = a.user_rekomendasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 $condition
                $order
                LIMIT $start, $length");
    
        return $query->result();

    }

    function jumlah_history_rekomendasi($search='',$start_date='',$end_date=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " c.nama LIKE '%$search%' OR b.tipe_permohonan LIKE '%$search%' OR a.no_invoice LIKE '%$search%'";
            $condition .= ')';
        }

        $query =$this->db->query("
            SELECT COUNT(*) as jumlah
            from tb_permohonan a
                join ms_tipe_permohonan b
                    on b.kode = a.type
                join (
                    select d.id,d.nama, e.kode, e.nama as assosiasi 
                    from tb_user d
                    join ms_assosiasi e
                        on d.kode = e.kode
                ) c
                    on c.id = a.id_assosiasi
                join tb_user d
                    on d.id = a.user_rekomendasi
                where a.status =1 and a.keuangan = 1 and a.rekomendasi=1 $condition");
    
        return $query->row();
    }


}