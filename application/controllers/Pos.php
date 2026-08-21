<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

//use chillerlan\QRCode\{QRCode, QROptions};


class Pos extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('pos_model','pos_model');
		$this->load->helper('sms_template_helper');
	}

	public function is_sms_enabled(){
		return is_sms_enabled();
	}
	
	public function index()
	{
		$this->permission_check('sales_add');
		$data=$this->data;

		//Sales Code
		$init_code=get_only_init_code('sales');
      	$count_id=get_last_count_id('db_sales');

		$data['page_title']='POS';
		$data['init_code']=$init_code;
		$data['count_id']=$count_id;
		

		$data['warehouse_id'] = '';
		$data['salesman_id'] = '';
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$this->load->view('pos',$data);
	}

	//adding new item from Modal
	public function newcustomer(){
	
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('customers_model');
			$result=$this->customers_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->query("select id,customer_name from db_customers order by id desc limit 1");
			$res['id']=$query->row()->id;
			$res['customer_name']=$query->row()->customer_name;
			$res['result']=$result;
			
			echo json_encode($res);

		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function get_details(){
		echo $this->pos_model->get_details();
	}
	public function receive_order(){
	    echo $this->pos_model->receive_order();
	}
	public function pos_save_update(){
		$response = $this->pos_model->pos_save_update();

		$explode = explode("<<<###>>>",$response);
		if($explode['0']=='success'){
			$init_code=get_only_init_code('sales');
			$count_id=get_last_count_id('db_sales');
			$customer_remaining_advance=get_customer_details($_REQUEST['customer_id'])->tot_advance;
			$email_result=array('status'=>'skipped','message'=>'');
			if($this->input->post('send_invoice_email')=='1'){
				$email_result=$this->send_pos_invoice_email((int)$explode[1]);
			}
			$response .="<<<###>>>".$init_code."<<<###>>>".$count_id."<<<###>>>".$customer_remaining_advance
				."<<<###>>>".$email_result['status']."<<<###>>>".$email_result['message'];
		}
		echo $response;
	}
	public function edit($sales_id){
		$this->belong_to('db_sales',$sales_id);
		$this->permission_check('sales_edit');
	    $data=$this->data;
	    $data['sales_id']=$sales_id;
	    $data['page_title']='POS Update';

	    //Get sales details
	    $sales_details = get_sales_details($sales_id);
	    $customer_id = $sales_details->customer_id;
	    $init_code = $sales_details->init_code;
	    $count_id = $sales_details->count_id;

	    $data['customer_id']=$customer_id;
	    $data['salesman_id']=$sales_details->salesman_id;
	    $data['init_code']=$init_code;
	    $data['count_id']=$count_id;
	    $data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$this->load->view('pos',$data);
	}
	public function fetch_sales($sales_id){
	    $result=$this->pos_model->edit_pos($sales_id);
	}
	/* ######################################## HOLD INVOICE ############################# */
	public function hold_invoice(){
	    echo $this->pos_model->hold_list_save_update();
	}
	public function hold_invoice_list(){
		$data =array();
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		echo json_encode($data);
	}

	public function get_hold_invoice_list(){
		$data =array();
		$result= $this->pos_model->hold_invoice_list();
		return $result;
	}
	public function get_hold_invoice_count(){
		$q1=$this->db->query("SELECT * FROM db_hold WHERE store_id=".get_current_store_id());
		return $q1->num_rows();
	}
	public function hold_invoice_delete($invoice_id){
		$result=$this->pos_model->hold_invoice_delete($invoice_id);
		echo trim($result);
	}
	public function hold_invoice_edit(){
		echo $this->pos_model->hold_invoice_edit();
	}
	public function add_payment_row(){
		return $this->load->view('modals_pos_payment/modal_payments_multi_sub');
	}

	public function print_qr($data='')
	{
		$this->load->model('Qrcode_model','qr');

		return $this->qr->qr_image($data);

		exit;

		$data  = trim($data);	

		//if the parameter value has slash
		$data = base64_decode(str_replace('-', '=', str_replace('_', '/', $data)));

		// quick and simple:
		//return '<img src="'.(new QRCode)->render($data).'" alt="QR Code" />';
		$options = new QROptions([
			
		]);

		return (!empty($data)) ? '<img src="'.(new QRCode($options))->render($data).'" alt="QR Code" />' : '';		
	}

	//Print sales POS invoice 
	public function print_invoice_pos($sales_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		$data=array_merge($data,array('sales_id'=>$sales_id));
		
		$this->load->view('sal-invoice-pos',$data);
		
	}
	public function get_item_details(){
		echo $this->pos_model->get_item_details($this->input->post('item_id'));
	}

	public function email_invoice(){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			return $this->output->set_content_type('application/json')->set_status_header(403)
				->set_output(json_encode(array('status'=>'error','message'=>'Access denied.')));
		}

		$sales_id=(int)$this->input->post('sales_id');
		if($sales_id<=0){
			return $this->output->set_content_type('application/json')->set_status_header(422)
				->set_output(json_encode(array('status'=>'error','message'=>'Invalid invoice.')));
		}

		$this->belong_to('db_sales',$sales_id);
		$result=$this->send_pos_invoice_email($sales_id);
		$status=$result['status']==='success' ? 200 : 422;
		return $this->output->set_content_type('application/json')->set_status_header($status)
			->set_output(json_encode($result));
	}

	private function send_pos_invoice_email($sales_id){
		$sale=$this->db->select('count_id,store_id')->where('id',(int)$sales_id)->get('db_sales')->row();
		if(empty($sale)){
			return array('status'=>'error','message'=>'Invoice not found.');
		}
		$store=get_store_details($sale->store_id);
		$email=!empty($store) ? trim((string)$store->email) : '';
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			return array('status'=>'error','message'=>'Please set a valid Email in Branch Settings.');
		}

		try{
			$data=$this->data;
			$data['sales_id']=$sales_id;
			$html=$this->load->view('sal-invoice-pos',$data,true);
			$options=new Options();
			$options->set('isRemoteEnabled',true);
			$dompdf=new Dompdf($options);
			$dompdf->loadHtml($html,'UTF-8');
			$dompdf->setPaper('A4','portrait');
			$dompdf->render();

			$this->load->model('email_model');
			$invoice_number=!empty($sale->count_id) ? $sale->count_id : $sales_id;
			$response=$this->email_model->send_email(array(
				'to'=>$email,
				'subject'=>'Al Kasir Invoice #'.$invoice_number,
				'message'=>"Thank you for your purchase. Your POS invoice summary is attached as a PDF.",
				'store_id'=>$sale->store_id,
				'attachments'=>array(array(
					'content'=>$dompdf->output(),
					'name'=>'Al-Kasir-Invoice-'.$invoice_number.'.pdf',
					'mime'=>'application/pdf',
				)),
			));
			if($response===true){
				return array('status'=>'success','message'=>'Invoice PDF emailed to '.$email.'.');
			}
			return array('status'=>'error','message'=>$response);
		}catch(Throwable $exception){
			log_message('error','POS invoice email failed for sale '.$sales_id.': '.$exception->getMessage());
			return array('status'=>'error','message'=>'Invoice email failed: '.$exception->getMessage());
		}
	}

	public function save_void_log(){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			return $this->output->set_status_header(403)->set_output(json_encode(array('status'=>'error','message'=>'Access denied.')));
		}
		$response = $this->pos_model->save_void_log();
		return $this->output->set_content_type('application/json')
			->set_status_header($response['status']==='success' ? 200 : 422)
			->set_output(json_encode($response));
	}

}
