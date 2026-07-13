<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Delivery_note extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('Delivery_note_model','deliverynote');
		$this->load->helper('sms_template_helper');
	}

	public function is_sms_enabled(){
		return is_sms_enabled();
	}

	public function index()
	{
		$this->permission_check('deliverynote_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('deliverynote_list');
		$this->load->view('delivery_note/delivery_note_list',$data);
	}
	public function add()
	{	
		$this->permission_check('deliverynote_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('deliverynote');
		$this->load->view('delivery_note/delivery_note',$data);
	}
	

	public function deliverynote_save_and_update(){
		$this->form_validation->set_rules('deliverynote_date', 'Delivery_note Date', 'trim|required');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->deliverynote->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	
	public function update($id){
		$this->belong_to('db_deliverynote',$id);
		$this->permission_check('deliverynote_edit');
		$data=$this->data;
		$data=array_merge($data,array('deliverynote_id'=>$id));
		$data['page_title']=$this->lang->line('deliverynote');
		$this->load->view('delivery_note/delivery_note', $data);
	}
	

	public function ajax_list()
	{
		$list = $this->deliverynote->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $deliverynote) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$deliverynote->id.' class="checkbox column_checkbox" >';
			
			$str='';
			        if($deliverynote->sales_status!='')
			          $str="<span title='Converted to Sales Invoice' class='label label-success' style='cursor:pointer'> Converted </span>";
			$row[] = show_date($deliverynote->deliverynote_date)."<br>".$str;
			$row[] = (!empty($deliverynote->expire_date)) ? show_date($deliverynote->expire_date) : '';

			$row[] = $deliverynote->deliverynote_code;
			
			$row[] = $deliverynote->reference_no;
			$row[] = $deliverynote->customer_name;
			
			$row[] = store_number_format($deliverynote->grand_total);
			$row[] = ucfirst($deliverynote->created_by);

					 $str1=base_url().'Delivery_note/update/';

					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('sales_add') && $deliverynote->sales_status=='')
											$str2.='<li>
												<a title="Convert to Invoice" href="'.base_url().'sales/deliverynote/'.$deliverynote->id.'" >
													<i class="fa fa-fw fa-exchange text-blue"></i>Convert to Invoice
												</a>
											</li>';

											if($deliverynote->sales_status=='Converted')
											$str2.='<li>
												<a title="View to Invoice" href="'.base_url().'sales/invoice/'.get_sales_id_of_deliverynote($deliverynote->id).'" >
													<i class="fa fa-fw fa-eye text-blue"></i>View Sales Invoice
												</a>
											</li>';

											if($this->permissions('deliverynote_view'))
											$str2.='<li>
												<a title="View Invoice" href="'.base_url().'Delivery_note/invoice/'.$deliverynote->id.'" >
													<i class="fa fa-fw fa-eye text-blue"></i>View Delivery_note
												</a>
											</li>';

											if($this->permissions('deliverynote_edit'))
											$str2.='<li>
												<a title="Update Record ?" href="'.$str1.$deliverynote->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('deliverynote_add') || $this->permissions('deliverynote_edit'))
											$str2.='<li>
												<a title="Take Print" target="_blank" href="'.base_url().'Delivery_note/print_invoice/'.$deliverynote->id.'">
													<i class="fa fa-fw fa-print text-blue"></i>Print
												</a>
											</li>

											<li>
												<a title="Download PDF" target="_blank" href="'.base_url().'Delivery_note/pdf/'.$deliverynote->id.'">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
												</a>
											</li>';

											if($this->permissions('deliverynote_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_deliverynote(\''.$deliverynote->id.'\')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			

			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->deliverynote->count_all(),
						"recordsFiltered" => $this->deliverynote->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check('deliverynote_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		
		$result=$this->deliverynote->update_status($id,$status);
		return $result;
	}
	public function delete_deliverynote(){
		$this->permission_check_with_msg('deliverynote_delete');
		$id=$this->input->post('q_id');
		echo $this->deliverynote->delete_deliverynote($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('deliverynote_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->deliverynote->delete_deliverynote($ids);
	}


	//Table ajax code
	public function search_item(){
		$q=$this->input->get('q');
		$result=$this->deliverynote->search_item($q);
		echo $result;
	}
	public function find_item_details(){
		$id=$this->input->post('id');
		
		$result=$this->deliverynote->find_item_details($id);
		echo $result;
	}

	//deliverynote invoice form
	public function invoice($id)
	{	
		$this->belong_to('db_deliverynote',$id);
		if(!$this->permissions('deliverynote_add') && !$this->permissions('deliverynote_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('deliverynote_id'=>$id));
		$data['page_title']=$this->lang->line('deliverynote_invoice');
		$this->load->view('delivery_note/delivery_note-invoice',$data);
	}
	
	//Print deliverynote invoice 
	public function print_invoice($deliverynote_id)
	{
		$this->belong_to('db_deliverynote',$deliverynote_id);
		if(!$this->permissions('deliverynote_add') && !$this->permissions('deliverynote_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('deliverynote_id'=>$deliverynote_id));
		$data['page_title']=$this->lang->line('deliverynote_invoice');
		
			$this->load->view('delivery_note/print-delivery_note-invoice-2',$data);
		
	}


	public function pdf($deliverynote_id){
		if(!$this->permissions('deliverynote_add') && !$this->permissions('deliverynote_edit')){
			$this->show_access_denied_page();
		}
		
		$data=$this->data;
		$data['page_title']=$this->lang->line('deliverynote_invoice');
        $data=array_merge($data,array('deliverynote_id'=>$deliverynote_id));
      
			$this->load->view('delivery_note/print-delivery_note-invoice-2',$data);
		
       

        // Get output html
        $html = $this->output->get_output();
        $options = new Options();
		$options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($html,'UTF-8');
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("Delivery_note_$deliverynote_id-".date('M')."_".date('d')."_".date('Y'), array("Attachment"=>0));
	}
	
	

	
	/*v1.1*/
	public function return_row_with_data($rowcount,$item_id){
		echo $this->deliverynote->get_items_info($rowcount,$item_id);
	}
	public function return_deliverynote_list($deliverynote_id){
		echo $this->deliverynote->return_deliverynote_list($deliverynote_id);
	}
	
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('deliverynote_view');
		$deliverynote_id=$this->input->post('deliverynote_id');
		echo $this->deliverynote->show_pay_now_modal($deliverynote_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('deliverynote_add');
		echo $this->deliverynote->save_payment();
	}
	public function view_payments_modal(){
		$this->permission_check_with_msg('deliverynote_view');
		$deliverynote_id=$this->input->post('deliverynote_id');
		echo $this->deliverynote->view_payments_modal($deliverynote_id);
	}
	public function get_customers_select_list(){
		echo get_customers_select_list(null,$_POST['store_id']);
	}
	public function get_items_select_list(){
		echo get_items_select_list(null,$_POST['store_id']);
	}
	public function get_tax_select_list(){
		echo get_tax_select_list(null,$_POST['store_id']);
	}
	/*Get warehouse select list*/
	public function get_warehouse_select_list(){
		echo get_warehouse_select_list(null,$_POST['store_id']);
	}
	//Print deliverynote Payment Receipt
	public function print_show_receipt($payment_id){
		if(!$this->permissions('deliverynote_add') && !$this->permissions('deliverynote_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('payment_receipt');
		$data=array_merge($data,array('payment_id'=>$payment_id));
		$this->load->view('print-cust-payment-receipt',$data);
	}
	
	public function get_users_select_list(){
		echo get_users_select_list($this->session->userdata("role_id"),$_POST['store_id']);
	}
}
