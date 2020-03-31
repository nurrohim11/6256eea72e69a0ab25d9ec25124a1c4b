<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
date_default_timezone_set('Asia/Jakarta');

class Log_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function log($request = '', $response = '', $user = '')
    {
        $class = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        $data = array(
            'api' => $class.'/'.$method,
            'request' => $request,
            'response' => $response,
            'user' => $user,
            'insert_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('log_trx_api', $data);
    }
}

/* End of file Log_Model.php */
/* Location: ./application/models/Log_Model.php */
