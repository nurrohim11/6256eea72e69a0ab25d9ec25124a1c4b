<?php

class Cetak_model extends CI_Model{

    function json_dokumen_sbu($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_dokumen_sbu($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_dokumen_sbu($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_dokumen_sbu($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $btn ='';
                if($val->jml >= 3){
                    $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="download_dokumen_sbu('.$val->id.')"><i class="fa fa-download"></i></button>';
                }else{
                    $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="no_download()"><i class="fa fa-download"></i></button>';
                }
                $data[$row] = array(
                    $no++,
                    $val->npwp,
                    $val->nama_bu,
                    $val->nama,
                    $val->tgl_berkas_masuk,
                    $val->tgl_pembayaran,
                    $val->jml.'x',
                    // rupiah($val->total_biaya),
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
    function view_dokumen_sbu($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.npwp';
        $arr_order[1] = 'a.npwp';
        $arr_order[2] = 'a.nama_bu';
        $arr_order[3] = 'assosiasi.nama';
        $arr_order[4] = 'd.tgl_berkas_masuk';
        $arr_order[5] = 'd.tgl_pembayaran';
        $arr_order[6] = 'jml';
        $arr_order[7] = 'total_biaya';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_dokumen_sbu($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id,a.npwp,a.nama_bu, a.alamat, assosiasi.nama, d.tgl_berkas_masuk, d.tgl_pembayaran,
            ifnull(approval.jml,0) as jml,ifnull(approval.jml,0) as jml, ifnull(total.total,0)+ifnull(p.total,0) as total_biaya
            from tb_bidang_usaha a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
                on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_bu
                from history_approval_sbu e
                group by e.id_bu
            ) as approval
                on approval.id_bu = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
            left join(
                select sum(f.lpjkp+f.lpjkn) as total, f.token_klasifikasi
                from tb_biaya_pengembangan f
                group by f.token_klasifikasi
            ) as p
                on p.token_klasifikasi = a.token_klasifikasi
            where a.ba =1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_dokumen_sbu($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.npwp LIKE '%$search%' OR a.nama_bu LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_bidang_usaha a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_bu
                from history_approval_sbu e
                group by e.id_bu
            ) as approval
            on approval.id_bu = a.id
                where a.ba =1 $condition ")->row();
    }


    function json_dokumen_ska($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_dokumen_ska($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_dokumen_ska($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_dokumen_ska($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $btn ='';
                if($val->jml >= 3){
                    $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="download_dokumen_skt('.$val->id.')"><i class="fa fa-download"></i></button>';
                }else{
                    $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="no_download()"><i class="fa fa-download"></i></button>';
                }
                $data[$row] = array(
                    $no++,
                    $val->nik,
                    $val->nama,
                    $val->alamat,
                    $val->assosiasi,
                    $val->tgl_berkas_masuk,
                    $val->tgl_pembayaran,
                    $val->jml.'x',
                    // rupiah($val->total_biaya),
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
    function view_dokumen_ska($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.nama';
        $arr_order[1] = 'a.nik';
        $arr_order[2] = 'a.nama';
        $arr_order[3] = 'a.alamat';
        $arr_order[4] = 'assosiasi.nama';
        $arr_order[5] = 'd.tgl_berkas_masuk';
        $arr_order[6] = 'd.tgl_pembayaran';
        $arr_order[7] = 'jml';
        $arr_order[8] = 'total_biaya';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_dokumen_ska($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id, a.nik,a.nama,alamat, assosiasi.nama as assosiasi, d.tgl_berkas_masuk, d.tgl_pembayaran,
            ifnull(approval.jml,0) as jml, ifnull(total.total,0) as total_biaya
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_skt e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 1 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_dokumen_ska($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_skt e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 1 $condition ")->row();
    }


    function json_dokumen_skt($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_dokumen_skt($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_dokumen_skt($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_dokumen_skt($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $btn ='';
                // if($val->jml >= 3){
                    $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="download_dokumen_skt('.$val->id.')"><i class="fa fa-download"></i></button>';
                // }else{
                //     $btn ='<button type="button" title="Download dokumen" class="btn btn-success btn-xs btn-sm" onclick="no_download()"><i class="fa fa-download"></i></button>';
                // }
                $data[$row] = array(
                    $no++,
                    // $val->nik,
                    $val->nama,
                    $val->alamat,
                    $val->assosiasi,
                    $val->tgl_berkas_masuk,
                    $val->tgl_pembayaran,
                    $val->jml.'x',
                    // rupiah($val->total_biaya),
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
    function view_dokumen_skt($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.nama';
        $arr_order[1] = 'a.nama';
        $arr_order[2] = 'a.alamat';
        $arr_order[3] = 'assosiasi.nama';
        $arr_order[4] = 'd.tgl_berkas_masuk';
        $arr_order[5] = 'd.tgl_pembayaran';
        $arr_order[6] = 'jml';
        $arr_order[7] = 'total_biaya';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_dokumen_skt($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.id, a.nik,a.nama,alamat, assosiasi.nama as assosiasi, d.tgl_berkas_masuk, d.tgl_pembayaran,
            ifnull(approval.jml,0) as jml, ifnull(total.total,0) as total_biaya
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_skt e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 2 $condition
            $order
            LIMIT $start, $length")->result();

    }

    function jumlah_dokumen_skt($search=''){
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.nik LIKE '%$search%' OR a.nama LIKE '%$search%' OR a.alamat LIKE '%$search%' OR assosiasi.nama LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            from tb_personal a
            join tb_permohonan d
                on a.token_permohonan = d.token_permohonan
            join (
                SELECT b.id, c.nama from tb_user b
                join ms_assosiasi c
                    on b.kode = c.kode
                where b.status=1
            ) as assosiasi
            on assosiasi.id = d.id_assosiasi
            left join(
                SELECT count(*) as jml, e.id_personal
                from history_approval_skt e
                group by e.id_personal
            ) as approval
            on approval.id_personal = a.id
            left join(
                select sum(f.biaya+f.biaya_lpjkn+f.biaya_lpjkp) as total, f.token_klasifikasi
                from detail_klasifikasi f
                group by f.token_klasifikasi
            ) as total
                on total.token_klasifikasi = a.token_klasifikasi
                where d.type = 2 $condition ")->row();
    }


}