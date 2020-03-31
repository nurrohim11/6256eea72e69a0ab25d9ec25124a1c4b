<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Berita_acara_model extends CI_Model {

    function json_berita_acara_sbu($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_berita_acara_sbu($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_berita_acara_sbu($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_berita_acara_sbu($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
            	$status_ba ='';
            	$btn='';
            	if($val->ba == 0){
            		$status_ba ='<label class="badge badge-warning" style="color:#fff">Belum di cek</label>';
    				$btn ='<button type="button" class="btn btn-info btn-xs btn-sm" onclick="cek_bu('.$val->id.','.$val->token_klasifikasi.')">CEK</button>';
            	}else{
            		$status_ba='<label class="badge badge-success" style="color:#fff">Sudah di cek</label>';
            		$btn='';
            	}
                $data[$row] = array(
                    $no++,
                    $val->tgl_berkas_masuk,
                    $val->nama_assosiasi,
                    $val->npwp,
                    $val->nama_bu,
                    // rupiah($val->jml),
                    '<button type="button" class="btn btn-info btn-xs btn-sm" onclick="cek_bu('.$val->id.','.$val->token_klasifikasi.')">CEK</button>'
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
    function view_berita_acara_sbu($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'b.tgl_berkas_masuk';
        $arr_order[3] = 'a.npwp';
        $arr_order[4] = 'a.nama_bu';
        $arr_order[2] = 'nama_assosiasi';
        $arr_order[1] = 'b.tgl_berkas_masuk';
        // $arr_order[5] = 'c.jml';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_berita_acara_sbu($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,c.jml,b.tgl_berkas_masuk, CONCAT(e.assosiasi,' | ',e.nama) as nama_assosiasi
			from tb_bidang_usaha a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_berita_acara_sbu($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_bidang_usaha a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 $condition ")->row();
    }

    function json_klasifikasi($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_klasifikasi($search,$token);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_klasifikasi($search,$token);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_klasifikasi($start, $length, $search, $column, $dir,$token);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
            	$no++;
                $data[$row] = array(
                    '<label class="mt-checkbox">
                    	<input type="checkbox" value="'.$val->id.'" name="cek'.$no.'" id="pilih">
                    	<span></span>
                    </label>',
                    $val->kode_klasifikasi,
                    $val->kode_sub_klasifikasi,
                    $val->kode_kualifikasi,
                    $val->permohonan,
                    rupiah($val->t_biaya),
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
    function view_klasifikasi($start = 0, $length = 0, $search = '', $column = '', $dir = '',$token=''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " kode_klasifikasi LIKE '%$search%' OR kode_klasifikasi LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= 'AND ';
            $condition .= " a.token_klasifikasi ='$token'";
        }

        $arr_order[1] = 'kode_klasifikasi';
        $arr_order[2] = 'kode_klasifikasi';
        $arr_order[3] = 'kode_kualifikasi';
        $arr_order[4] = 'e.permohonan,';
        $arr_order[5] = 't_biaya';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_klasifikasi($search,$token);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,b.kode as kode_klasifikasi,c.kode as kode_sub_klasifikasi, d.kode as kode_kualifikasi, e.permohonan,
          	(a.biaya+a.biaya_lpjkp+a.biaya_lpjkn) as t_biaya
			from detail_klasifikasi a
			join ms_klasifikasi b
				on a.klasifikasi = b.id
			join ms_sub_klasifikasi c
				on c.id = a.sub_klasifikasi
			join ms_kualifikasi d
				on d.id = a.kualifikasi
			join ms_permohonan e
				on e.id = a.id_permohonan
			where a.hasil =1 and a.cek_ba =0 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_klasifikasi($search='',$token=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " kode_klasifikasi LIKE '%$search%' OR kode_klasifikasi LIKE '%$search%'";
            $condition .= ')';
        }

        if($token != ''){
            $condition .= 'AND ';
            $condition .= " a.token_klasifikasi ='$token'";
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from detail_klasifikasi a
			join ms_klasifikasi b
				on a.klasifikasi = b.id
			join ms_sub_klasifikasi c
				on c.id = a.sub_klasifikasi
			join ms_kualifikasi d
				on d.id = a.kualifikasi
			join ms_permohonan e
				on e.id = a.id_permohonan
			where a.hasil =1 and a.cek_ba =0 $condition ")->row();
    }

    function json_berita_acara_ska($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_berita_acara_ska($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_berita_acara_ska($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_berita_acara_ska($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    $val->alamat,
                    $val->nama_assosiasi,
                    $val->tgl_berkas_masuk,
                    rupiah($val->jml),
                    '<button type="button" class="btn btn-info btn-xs btn-sm" onclick="cek_personal_ska('.$val->id.','.$val->token_klasifikasi.')">CEK</button>'
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
    function view_berita_acara_ska($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'b.tgl_berkas_masuk';
        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'alamat';
        $arr_order[4] = 'nama_assosiasi';
        $arr_order[5] = 'b.tgl_berkas_masuk';
        $arr_order[6] = 'c.jml';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_berita_acara_ska($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,c.jml,b.tgl_berkas_masuk, CONCAT(e.assosiasi,' | ',e.nama) as nama_assosiasi
			from tb_personal a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 and b.type=1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_berita_acara_ska($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 and b.type=1 $condition ")->row();
    }


    function json_berita_acara_skt($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_berita_acara_skt($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_berita_acara_skt($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_berita_acara_skt($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    $val->alamat,
                    $val->nama_assosiasi,
                    $val->tgl_berkas_masuk,
                    rupiah($val->jml),
                    '<button type="button" class="btn btn-info btn-xs btn-sm" onclick="cek_personal_skt('.$val->id.','.$val->token_klasifikasi.')">CEK</button>'
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
    function view_berita_acara_skt($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'b.tgl_berkas_masuk';
        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'alamat';
        $arr_order[4] = 'nama_assosiasi';
        $arr_order[5] = 'b.tgl_berkas_masuk';
        $arr_order[6] = 'c.jml';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_berita_acara_skt($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*,c.jml,b.tgl_berkas_masuk, CONCAT(e.assosiasi,' | ',e.nama) as nama_assosiasi
			from tb_personal a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 and b.type=2 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_berita_acara_skt($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
			join tb_permohonan b
				on a.token_permohonan = b.token_permohonan
			left join(
				select sum(d.biaya+d.biaya_lpjkn+d.biaya_lpjkp) as jml, d.token_klasifikasi
				from detail_klasifikasi d
				where d.hasil =1
				group by d.token_klasifikasi
			)as c
				on c.token_klasifikasi = a.token_klasifikasi
			left join(
				SELECT f.*, g.nama as assosiasi from tb_user f
				join ms_assosiasi g
					on f.kode = g.kode
				where f.status=1
			) as e
			on b.id_assosiasi = e.id
			where a.penilaian =1 and b.type=2 $condition ")->row();
    }


}