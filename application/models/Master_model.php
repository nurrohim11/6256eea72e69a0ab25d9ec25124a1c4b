<?php

class Master_model extends CI_Model{

    function json_jabatan($draw = 1, $start = 0, $length = 0, $search = '', $column = '', $dir = ''){
        $start = $this->db->escape_str($start);
        $length = $this->db->escape_str($length);
        $column = $this->db->escape_str($column);
        $dir = $this->db->escape_str($dir);
        $search = $this->db->escape_str($search);

        $total_filtered = $this->jumlah_jabatan($search);
        $total_filtered = isset($total_filtered->jumlah) ? $total_filtered->jumlah : 0;
        $total = $this->jumlah_jabatan($search);
        $total = isset($total->jumlah) ? $total->jumlah : 0;
        $data = array();
        $cdon = $this->view_jabatan($start, $length, $search, $column, $dir);
        if (!empty($cdon)) {
            $no = $start + 1;
            foreach ($cdon as $row => $val) {
                $level =level();

                $data[$row] = array(
                    $no++,
                    $val->jabatan,
                    '<button type="button" class="btn btn-warning btn-xs btn-sm" onclick="edit_jabatan('.$val->id.')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-danger btn-xs btn-sm" onclick="delete_jabatan('.$val->id.')"><i class="fa fa-trash"></i></button>'
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
    function view_jabatan($start = 0, $length = 0, $search = '', $column = '', $dir = ''){

        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.jabatan LIKE '%$search%'";
            $condition .= ')';
        }

        $arr_order[0] = 'a.insert_at';
        $arr_order[1] = 'a.jabatan';

        $order = '';
        if ($column != '' && $dir != '') {
            $col = isset($arr_order[$column]) ? $arr_order[$column] : '';

            if ($col != '') {
                $order .= " ORDER BY $col $dir ";
            }
        }


        if ($length == -1) {
            $length = $this->jumlah_jabatan($search);
            $length = isset($length->jumlah) ? $length->jumlah : 0;
        }
        // print_r($condition);
        return $this->db->query("
          SELECT a.*
          from ms_jabatan a
            where a.status=1 
            $condition
            $order
            LIMIT $start, $length
        ")->result();

    }

    function jumlah_jabatan($search=''){
        $condition = '';
        $condition = '';
        if ($search != '') {
            $condition .= 'AND (';
            $condition .= " a.jabatan LIKE '%$search%'";
            $condition .= ')';
        }

        return $this->db->query("
          SELECT COUNT(*) as jumlah
            FROM ms_jabatan a
            where a.status=1 $condition")->row();
    }
}