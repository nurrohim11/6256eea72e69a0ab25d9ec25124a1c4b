<?php defined('BASEPATH') or exit('No direct script access allowed');

function print_json($status = 200, $message = '', $data = '')
{
    $ci =& get_instance();
    $response = response($status, $message, $data);

    return $ci->auth->print_json($response);
}

function get_params()
{
    return json_decode(file_get_contents('php://input'), true);
}


function run_key() {

    $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '?', '!'
    );

    shuffle($chars);

    $num_chars = count($chars) - 1;
    $token = '';

    for ($i = 0; $i < $num_chars; $i++){ // <-- $num_chars instead of $len
        $token .= $chars[mt_rand(0, $num_chars)];
    }

    return $token;
}

function TglID($tgl) {
    $date = strtotime($tgl);
    return date('Y-m-d', $date);  
}

function response($status = 200, $message = '', $data = [])
{
    return array(
        'response' => $data,
        'metadata' => array(
            'status' => $status, 
            'message' => $message
        )
    );
}

function log_api($request = '',$user='', $status = '', $message = '', $data = [])
{
    $ci =& get_instance();

    $ci->load->model('api/Log_model');

    $response = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );

    $response = json_encode($response);
    $request = json_encode($request);

    $user = ($user) ? $user : userid();

    $ci->Log_model->log($request, $response, $user);
}

# do enkrip id
function enkrip_id($id = '')
{
    
    $date_init = new DateTime(date('Y-m-d'));
    $time = $date_init->getTimestamp();
    $date = getdate();
    $baru = $id * $date['year'] * $date['mon'] * $date['mday'];

    return ($baru + $time)*$date['hours'];
}

# do dekrip id
function dekrip_id($id = '')
{
    $date_init = new DateTime(date('Y-m-d'));
    $time = $date_init->getTimestamp();
    $date = getdate();
    $div = $id / $date['hours'];
    $new_id = $div - $time;
        
    return (($new_id/$date['year'])/$date['mon'])/$date['mday'];
}
function path_image_user(){
    return base_url().'assets/uploads/user/';
}

function random_string($id=10){
    $pool = '1234567890';
    
    $word = '';
    for ($i = 0; $i < $id; $i++){ 
        $word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
    }
    return $word; 
}