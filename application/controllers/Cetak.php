<?php

class Cetak extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Cetak_model');
	}

	function sbu(){
		get_login();
		get_page();
		$header['title'] ="Cetak Dokumen SBU";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/cetak.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('cetak/sbu');
		$this->load->view('template/footer',$footer);
	}

	function data_cetak_sbu(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Cetak_model->json_dokumen_sbu($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	public function cetak_dokumen_sbu(){
		$id = $this->input->get('id');
		$dt = $this->db->query("
				SELECT a.*,b.kota as ket_kota, c.kbli as ket_kbli, ass.nama from tb_bidang_usaha a
				join tb_permohonan g
					on g.token_permohonan = a.token_permohonan
				join ms_kota b
					on b.id = a.kota
				join ms_kbli c
					on c.id = a.id_kbli
				left join (
					SELECT d.id, f.nama from tb_user d
					join ms_assosiasi f
						on f.kode = d.kode
				) as ass
					on ass.id = g.id_assosiasi
				where a.id = '$id'
			")->row();
	    $data = array(
	    	'p' =>$dt,
	    );
		ob_start();
		$this->load->view('cetak/cetak_sbu',$data);
		$html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
		$pdf = new HTML2PDF('P','A4','en',true, 'UTF-8', array(15, 15, 15, 15));
		$pdf->WriteHTML($html);
		// $pdf->Output('wkwkwkwk.pdf', false);
		$pdf->Output(''.$dt->nama_bu.date('Y-m-d').'.pdf', 'D');
	}

	function ska(){
		get_login();
		get_page();
		$header['title'] ="Cetak Dokumen SKA";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/cetak.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('cetak/ska');
		$this->load->view('template/footer',$footer);
	}

	function data_cetak_ska(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Cetak_model->json_dokumen_ska($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	function skt(){
		get_login();
		get_page();
		$header['title'] ="Cetak Dokumen SKT";
		$header['css'] = css_datepicker().css_select2().css_datatable();
		$footer['js'] = js_datepicker().js_select2().js_datatable().'<script src="'.base_url().'assets/apps/js/cetak.js" type="text/javascript"></script>';

		$this->load->view('template/header',$header);
		$this->load->view('cetak/skt');
		$this->load->view('template/footer',$footer);
	}

	function data_cetak_skt(){
        get_login();
        $is_ajax = $this->input->is_ajax_request();
        if($is_ajax){
            $draw = $this->input->get('draw');
            $start = $this->input->get('start');
            $length = $this->input->get('length');
            $search = $this->input->get('search');
            $order = $this->input->get('order');

            $json = $this->Cetak_model->json_dokumen_skt($draw, $start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);

            echo json_encode($json);
        }else{
            show_404();
        }
	}

	public function cetak_dokumen_skt(){
		$id = $this->input->get('id');
		$dt = $this->db->query("
				SELECT a.*, b.kota as ket_kota,ass.nama as assosiasi from tb_personal a
				join tb_permohonan g
					on g.token_permohonan = a.token_permohonan
				left join ms_kota b
					on b.id = a.kota
				left join (
					SELECT d.id, f.nama from tb_user d
					join ms_assosiasi f
						on f.kode = d.kode
				) as ass
					on ass.id = g.id_assosiasi
				where a.id = '$id'
			")->row();
	    $data = array(
	    	'p' =>$dt,
	    );
		ob_start();
		$this->load->view('cetak/cetak_skt',$data);
		$html = ob_get_contents();
        ob_end_clean();
        
        require_once('./assets/html2pdf/html2pdf.class.php');
		$pdf = new HTML2PDF('P','A4','en',true, 'UTF-8', array(15, 15, 15, 15));
		$pdf->WriteHTML($html);
		$pdf->Output('wkwkwkwk.pdf', false);
		// $pdf->Output(''.$dt->nama_bu.date('Y-m-d').'.pdf', 'D');
	}

}