<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// die('PDF CONTROLLER FILE LOADED');


class Pdf extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if ($this->router->fetch_method() !== 'sales_public') {
			$this->load_global();
		} else {
			$this->load_info();
		}
	}

	/**
	 * Sales invoices
	 * 3. Default Format
	 * 4. GST invoice Format
	 * Public access using a unique token
	*/
	public function sales_public($sales_id=null, $token=null){
		$salt = $this->config->item('encryption_key');
		if (empty($salt)) {
			$salt = 'retail_app_secret_salt';
		}
		if (empty($sales_id) || empty($token) || $token !== md5($sales_id . $salt)) {
			show_404();
			return;
		}

		$CI =& get_instance();
		$sale = $CI->db->select('store_id')->where('id', $sales_id)->get('db_sales')->row();
		if (empty($sale)) {
			show_404();
			return;
		}

		// Set store_id temporarily in session so that any helper functions like get_current_store_id() or formatters work correctly
		$this->session->set_userdata('store_id', $sale->store_id);
		if (empty($this->session->userdata('language'))) {
			$this->session->set_userdata('language', 'English');
		}

		$params = array();
		$params['sales_id'] = $sales_id;

		// Select Store Invoice Format
		$invoice_format_id = $CI->db->select('sales_invoice_format_id')->where('id', $sale->store_id)->get('db_store')->row()->sales_invoice_format_id;

		if($invoice_format_id==4){
			//GST invoice
			$this->load->library('tcpdf/invoice/GstInvoice',$params);
			$this->gstinvoice->show_pdf();
		}
		else{
			//Default invoice
			$this->load->library('tcpdf/invoice/Sales',$params);
			$this->sales->show_pdf();
		}
	}

	/**
	 * Sales invoices
	 * 3. Default Format
	 * 4. GST invoice Format
	*/
	public function sales($sales_id=null){

		$params = array();

		//Validate Record Authenttication
		$this->belong_to('db_sales',$sales_id);
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}

		//Select Store Invoice Format
		$invoice_format_id = get_invoice_format_id();

		$params['sales_id'] = $sales_id;

		if($invoice_format_id==4){
			//GST invoice
			$this->load->library('tcpdf/invoice/GstInvoice',$params);
			$this->gstinvoice->IncludeJS("print();");
			$this->gstinvoice->show_pdf();
		}
		else{
			//Default invoice
			$this->load->library('tcpdf/invoice/Sales',$params);

			$this->sales->show_pdf();
		}

	}

}