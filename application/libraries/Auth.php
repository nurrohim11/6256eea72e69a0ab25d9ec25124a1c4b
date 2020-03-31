<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Auth
{
    private $client_service = 'lpjk'; 
    private $auth_key = 'rohim'; 

    function check_authentication($method = 'GET', $flag = true) 
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        if ($method == $request_method) {
            $ci =& get_instance();
            $client_service = $ci->input->get_request_header('Client-Service', true);
            $auth_key = $ci->input->get_request_header('Auth-Key', true);
            $user_id = $ci->input->get_request_header('User-Id', true); // user id untuk akses
            $timestamp = $ci->input->get_request_header('Timestamp', true); // random timestamp.
            // format java  user_timestamp SSSHHyyyyssMMddmm
            $signature = $ci->input->get_request_header('Signature', true); // signature

            $header = [$client_service, $auth_key, $user_id, $timestamp, $signature];

            if ($flag == true) {
                if ($auth_key == $this->auth_key && $client_service == $this->client_service) {
                    // create encoded signature
                    $encoded_signature = $this->generate_signature($user_id, $timestamp);
                    // jika cocok maka true
                    // cocokkan encoded signature dgn signature dari request
                    if ($signature == $encoded_signature) {
                        $time = substr($timestamp, 3, 17); // convert random timestamp to timestamp normal

                        $check_expired = $this->check_expired($time); // check expiration time of token
                        $flag_expired = isset($check_expired->flag_expired) ? $check_expired->flag_expired : 0;
                        if ($flag_expired == 0) {
                            $check_auth = $this->check_auth($user_id, $timestamp, $signature);
                            if (empty($check_auth)) {
                                $data = array(
                                    'user_id' => $user_id,
                                    'timestamp' => $timestamp,
                                    'signature' => $signature
                                );
                                $this->simpan_authentication($data);
                                return true;
                            } else {
                                // $response = array(
                                //     'response' => [],
                                //     'metadata' => array(
                                //         'status' => 401,
                                //         'message' => 'You dont have permission to access this app'
                                //     )
                                // );

                                // return $this->print_json($response);
                                return true;
                            }
                        } else {
                            $response = array(
                                'response' => [],
                                'metadata' => array(
                                    'status' => 401,
                                    'message' => 'Token has been expired or revoked'
                                )
                            );

                            return $this->print_json($response);
                        }
                    } else {
                        $response = array(
                            'response' => [],
                            'metadata' => array(
                                'status' => 401,
                                'message' => 'Unauthorized Signature'
                            )
                        );

                        return $this->print_json($response);
                    }
                } else {
                    $response = array(
                        'response' => [],
                        'metadata' => array(
                            'status' => 401,
                            'message' => 'Unauthorized Auth gag cocok'
                        )
                    );

                    return $this->print_json($response);
                }
            } else {
                if ($auth_key == $this->auth_key && $client_service == $this->client_service) {
                    return true;
                } else {
                    $response = array(
                        'response' => [],
                        'metadata' => array(
                            'status' => 401,
                            'message' => 'Unauthorized auth gag cocok'
                        )
                    );

                    return $this->print_json($response);
                }
            }
        } else {
            $response = array(
                'response' => [],
                'metadata' => array(
                    'status' => 400,
                    'message' => 'Bad Request'
                )
            );

            return $this->print_json($response);
        }
    }

    function generate_timestamp()
    {

        $now = date('Y-m-d H:i:s');
        $seconds = (strtotime($now) / 1000);
        $seconds = round($seconds - ($seconds >> 0), 3) * 1000;

        $random = date('HYsmdi');
        $timestamp = $seconds.$random;

        return $timestamp;
    }

    function generate_signature($user_id = '', $timestamp = '')
    {
        $signature = hash_hmac('sha256', $user_id.'&'.$timestamp, $user_id.'die', true);

        return base64_encode($signature);
    }

    function check_expired($time = 0)
    {
        $ci =& get_instance();
        return $ci->db->query("
                SELECT 
                  (
                    STR_TO_DATE('$time', '%H%Y%S%m%d%i') < TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE)) 
                    OR STR_TO_DATE('$time', '%H%Y%S%m%d%i') > TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE))
                  ) AS flag_expired ")->row();
    }

    function simpan_authentication($data = [])
    {
        $ci =& get_instance();
        $ci->db->insert('log_auth', $data);
    }

    function check_auth($user_id = '', $timestamp = '', $signature = '')
    {
        $ci =& get_instance();
        return $ci->db->where('user_id', $user_id)
                ->where('timestamp', $timestamp)
                ->where('signature', $signature)
                ->get('log_auth')
                ->row();
    }

    function print_json($response = '', $status_header = 200)
    {
        $ci =& get_instance();
        $ci->output->set_content_type('application/json');
        $ci->output->set_status_header($status_header);
        $ci->output->set_output(json_encode($response));
    }
}