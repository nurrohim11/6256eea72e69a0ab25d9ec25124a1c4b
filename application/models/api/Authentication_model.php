<?php
class Authentication_model extends CI_Model{
	
    function login($username='', $password='')
    {
        $query = $this->db->where('username', $username)
                    ->where('password', $password)
                    ->where('status',1)
                    ->get('tb_user')
                    ->row();
        return $query;
    }

    function get_user($id){
        $query = $this->db->where('id', $id)
                    ->where('status',1)
                    ->get('tb_user')
                    ->row();
        return $query;
    }

}