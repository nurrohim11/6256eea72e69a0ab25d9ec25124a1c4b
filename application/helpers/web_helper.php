<?php
date_default_timezone_set("Asia/Jakarta");

function get_login()
{
	$ci =& get_instance();
	return $ci->Main_model->get_login();
}

function get_page()
{
	$ci =& get_instance();
	return $ci->Main_model->get_page();
}

function userId(){
	$ci =& get_instance();
	return $ci->session->userdata('id_user');	
}

function username(){
    $ci =& get_instance();
    return $ci->session->userdata('username');
}
function level(){
    $ci =& get_instance();
    return $ci->session->userdata('level');
}

function create_menu($parent=0){
	$ci =& get_instance();
	$ci->load->model('Menu_model');
	return $ci->Menu_model->create_menu($parent);
}

function app_setting($key=''){
	$ci =& get_instance();
	$query = $ci->db->get_where('app_setting',array('key'=>$key))->row();
	$setting = $query->deskripsi;
	return $setting;
}
function rupiah($angka){
    $hasil_rupiah = "Rp. " . number_format($angka,2,',','.');
    return $hasil_rupiah;
}

function money($angka){
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;
}

function path_image($type=''){
    return base_url().'assets/uploads/'.$type.'/';
}

function rname($bil){
    $bil=str_replace("'","-",$bil);
    $bil=str_replace('"','-',$bil);
    $bil=str_replace(' ','-',$bil);
    $bil=str_replace('*','-',$bil);
    $bil=str_replace('`','-',$bil);
    $bil=str_replace('!','-',$bil);
    $bil=str_replace('&','-',$bil);
    $bil=str_replace('=','-',$bil);
    $bil=str_replace(';','-',$bil);
    $bil=str_replace(':','-',$bil);
    $bil=str_replace('?','-',$bil);
    $bil=str_replace('%','-',$bil);
    $bil=str_replace('@','-',$bil);
    $bil=str_replace('~','-',$bil);
    $bil=str_replace('#','-',$bil);
    $bil=str_replace('$','-',$bil);
    $bil=str_replace('^','-',$bil);     
    $bil=str_replace('(','-',$bil);
    $bil=str_replace(')','-',$bil);
    $bil=str_replace('/','-',$bil);
    $bil=str_replace('\\','-',$bil);
    $bil=str_replace(',','-',$bil);
    $bil=str_replace('--','-',$bil);
    $bil=str_replace('--','-',$bil);            
    $bil=strtolower($bil);
    return $bil; 
}

function update_counter($kode=''){
    $ci =& get_instance();
    $current_month = date('n');
    $current_year = date('Y');

    $fn_current_month = $current_month;

    if (strlen($current_month) == 1) {
        $fn_current_month = '0'.$current_month;
    }


    $counter = $ci->db->where('kode', $kode)
                    ->get('counter')
                    ->row();
    $maks = isset($counter->counter) ? $counter->counter : 1;
    $maks = $maks;

    if ($counter) {
        $ci->db->where('kode', $kode)
            ->update('counter', [
                'counter' => $maks + 1, 
                'bulan' => $current_month,
                'tahun' => $current_year
            ]);

    } else {
        $ci->db->insert('counter', [
				'counter' => 1, 
				'kode'  => $kode,
                'bulan' => $current_month,
                'tahun' => $current_year
            ]);
    }

    $urutan = '';

    switch (strlen($maks)) {
        case 1:
            $fn_counter = '0000'.$maks;
            break;
        case 2:
            $fn_counter = '0000'.$maks;
            break;
        case 3:
            $fn_counter = '000'.$maks;
            break;

        case 4:
            $fn_counter = '00'.$maks;
            break;
        
        default:
            $fn_counter = $maks;
            break;
    }

    $result = $kode.'/'.$fn_counter.'/'.$fn_current_month.'/'.$current_year;

    return $result;
}

function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
 
// Format sbu : (no urut)/BAR-BU/LPJK/10/(bulan)/(tahun)
// Format ska dan skt : (no urut)/BAR-TK/LPJK/10/(bulan)/(tahun)
function update_nomor($kode=''){
    $ci =& get_instance();
    $current_month = date('n');
    $current_year = date('Y');

    $fn_current_month = $current_month;

    if (strlen($current_month) == 1) {
        $fn_current_month = '0'.$current_month;
    }

    $counter = $ci->db->where('kode', $kode)
                    ->get('counter')
                    ->row();
    $maks = isset($counter->counter) ? $counter->counter : 1;
    $maks = $maks;

    if ($counter) {
        $ci->db->where('kode', $kode)
            ->update('counter', [
                'counter' => $maks + 1, 
                'bulan' => $current_month,
                'tahun' => $current_year
            ]);

    } else {
        $ci->db->insert('counter', [
                'counter' => 1, 
                'kode'  => $kode,
                'bulan' => $current_month,
                'tahun' => $current_year
            ]);
    }

    $fn_counter = '';

    switch (strlen($maks)) {
        case 1:
            $fn_counter = '0000'.$maks;
            break;
        case 2:
            $fn_counter = '000'.$maks;
            break;
        case 3:
            $fn_counter = '00'.$maks;
            break;
        case 4:
            $fn_counter = '0'.$maks;
            break;
        default:
            $fn_counter = $maks;
            break;
    }

    $result = $fn_counter.'/'.$kode.'/LPJK/10/'.bulan_romawi($current_month).'/'.$current_year;

    return $result;
}

function tanggal($w){
    $hari  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
    return $hari[$w];
}

function bulan($b){
    $bulan = array("January","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $month = $b-1;
    return $bulan[$month];
}

function bulan_romawi($bln){
    switch ($bln){
        case 1: 
            return "I";
            break;
        case 2:
            return "II";
            break;
        case 3:
            return "III";
            break;
        case 4:
            return "IV";
            break;
        case 5:
            return "V";
            break;
        case 6:
            return "VI";
            break;
        case 7:
            return "VII";
            break;
        case 8:
            return "VIII";
            break;
        case 9:
            return "IX";
            break;
        case 10:
            return "X";
            break;
        case 11:
            return "XI";
            break;
        case 12:
            return "XII";
            break;
    }
}

function selamat(){
    $b = time();
    $hour = date("G",$b);
    $s ='';
    if ($hour>=0 && $hour<=11)
    {
        $s = "Selamat Pagi :)";
    }
    elseif ($hour >=12 && $hour<=14)
    {
        $s = "Selamat Siang :) ";
    }
    elseif ($hour >=15 && $hour<=17)
    {
        $s = "Selamat Sore :) ";
    }
    elseif ($hour >=17 && $hour<=18)
    {
        $s = "Selamat Petang :) ";
    }
    elseif ($hour >=19 && $hour<=23)
    {
        $s = "Selamat Malam :) ";
    }
    return $s;
}
function notifikasi_pengurus(){
    $ci =& get_instance();
    $p = $ci->db->query("SELECT* from tb_user a where a.`level` =12 and a.status =1")->result();
    foreach($p as $row){
        $arr=array(
            'to'=>$row->fcm_id,
            'notification' => array(
                'title' =>  selamat().' '.$row->nama,
                'body' => 'Lpjk jabar telah melakukan sertifikasi, mohon untuk tanda tangan RPL, trims'
            ),
            'data'=>array(
                'jenis' => 'notifikasi_pengurus'
            )
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($arr),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: key=AAAA3AX2BCw:APA91bFY1ZifNQnmt3mjkz6xcNoc1PDRmkBe3f7ho0jAEKXeMLeYIBE3tkdOW-u2ay6Ea_iYPjRZYbMs2ixTkZ54DsPuNaLWB9_qT5t_7-zRoIY0i8kkwuFxZaTXi6Me64hqEZB725FS",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        //     return 0;
        // } else {
        //   // echo $response;
        //     return 1;
        // }   
    }
    
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }           
    return $hasil;
}

function nomor($id=2){
    $pool = '1234567890';
    
    $word = '';
    for ($i = 0; $i < $id; $i++){ 
        $word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
    }
    return $word; 
}


function session_user($no){
    $pool = '1234567890abcdefghijklmnopqrstuvwxuyz';
    
    $word = '';
    for ($i = 0; $i < $no; $i++){ 
        $word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
    }
    return $word; 
}

function css_morris(){
	return '<link href="'.base_url().'assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />';
}
function js_morris(){
	return '<script src="'.base_url().'assets/global/plugins/morris/morris.min.js" type="text/javascript"></script><script src="'.base_url().'assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>';
}

function js_amchart(){
	return '<script src="'.base_url().'assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>';
}

function css_tree(){
    return '<link href="'.base_url().'assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />';
}

function js_tree(){
	return ' <script src="'.base_url().'assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/pages/scripts/ui-tree.js" type="text/javascript"></script>';
}

function css_datepicker(){
	return '<link href="'.base_url().'assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />';
}

function js_datepicker(){
	return '<script src="'.base_url().'assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>';
}

function css_select2(){
	return '<link href="'.base_url().'assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />';
}

function js_select2(){
	return '<script src="'.base_url().'assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>';
}

function css_datatable(){
	return '<link href="'.base_url().'assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="'.base_url().'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />';
}

function js_datatable(){
	return '<script src="'.base_url().'assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="'.base_url().'assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>';
}
