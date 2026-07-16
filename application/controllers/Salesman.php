<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesman extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('salesman_model','salesman');
	}

	public function index()
	{
		$this->permission_check('salesman_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('salesman_list');
		$this->load->view('salesman-view',$data);
	}
	public function add()
	{
		$this->permission_check('salesman_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('salesman');
		$this->load->view('salesman',$data);
	}

	public function newsalesman(){
		$this->form_validation->set_rules('salesman_name', 'Salesman Name', 'trim|required');
		
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->salesman->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->belong_to('db_salesman',$id);
		$this->permission_check('salesman_edit');
		$data=$this->data;
		$result=$this->salesman->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('salesman');
		$this->load->view('salesman', $data);
	}
	public function update_salesman(){
		$this->form_validation->set_rules('salesman_name', 'Salesman Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {			
			$result=$this->salesman->update_salesman();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}


	public function ajax_list()
	{
		$list = $this->salesman->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $salesman) {

			$opening_balance =(!empty($salesman->opening_balance)) ? $salesman->opening_balance : 0;
			$opening_balance -=get_paid_cob($salesman->id);
			$sales_due =(!empty($salesman->sales_due)) ? $salesman->sales_due : 0;
			$sales_return_due =(!empty($salesman->sales_return_due)) ? $salesman->sales_return_due : 0;
			$total = ($opening_balance)+$sales_due-$sales_return_due;
			
			$no++;
			$row = array();
			$disable = ($salesman->delete_bit==1) ? 'disabled' : '';
			
			$row[] = ($salesman->delete_bit==1) ? '<span data-toggle="tooltip" title="Resticted" class="text-danger fa fa-fw fa-ban"></span>' : '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$salesman->id.' class="checkbox column_checkbox" >';
			
			$row[] = $salesman->id;
			$row[] = $salesman->salesman_name;
			$row[] = $salesman->mobile;
			$row[] = $salesman->email;
			$row[] = (!empty($salesman->location_link)) ? '<a target="_blank" title="Click to View Location!" href="'.$salesman->location_link.'"><i class="fa fa-fw fa-map-marker"></i> Link</a>' : '';
			$row[] = ($salesman->credit_limit==-1) ? "<span class='badge'>No Limit</span>" :store_number_format($salesman->credit_limit);
			$row[] = store_number_format($opening_balance+$sales_due);
			
			$row[] = store_number_format($sales_return_due);
			$row[] = store_number_format($salesman->tot_advance);
			

			 		if($salesman->status==1){ 
			 			$str= "<span onclick='update_status(".$salesman->id.",0)' id='span_".$salesman->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$salesman->id.",1)' id='span_".$salesman->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											/*if(is_store_admin())
											$str2.='<li>
												<a title="Discount Coupon" href="'.base_url().'salesman_coupon/generate/'.$salesman->id.'">
													<i class="fa fa-fw fa-tags text-blue"></i>Generate Discount Coupon
												</a>
											</li>';*/

											if($this->permissions('salesman_edit')&& $salesman->delete_bit!=1)
											$str2.='<li>
												<a title="Edit Record ?" href="'.base_url().'salesman/update/'.$salesman->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											/*if($this->permissions('cust_adv_payments_view'))
											$str2.='<li>
												<a title="Advance Payments View" href="'.base_url().'salesman_advance">
													<i class="fa fa-fw fa-edit text-blue"></i>Advance Payments
												</a>
											</li>';

											if($this->permissions('sales_payment_view'))
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$salesman->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>View Payments
												</a>
											</li>';

											if($this->permissions('sales_payment_add'))
											$str2.='<li>
												<a title="Receive Previous Balance & Sales Due Payments" class="pointer" onclick="pay_now('.$salesman->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Receive Due Payments
												</a>
											</li>';
											if($this->permissions('sales_return_payment_add'))
											$str2.='<li>
												<a title="Pay Return Due" class="pointer" onclick="pay_return_due('.$salesman->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Pay Return Due
												</a>
											</li>';*/
											if($this->permissions('salesman_delete') && $salesman->delete_bit!=1)
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_salesman('.$salesman->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] =  $str2;
			

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->salesman->count_all(),
						"recordsFiltered" => $this->salesman->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('salesman_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->salesman->update_status($id,$status);
		return $result;
	}
	
	public function delete_salesman(){
		$this->permission_check_with_msg('salesman_delete');
		$id=$this->input->post('q_id');
		return $this->salesman->delete_salesman_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('salesman_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->salesman->delete_salesman_from_table($ids);
	}
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$salesman_id=$this->input->post('salesman_id');
		echo $this->salesman->show_pay_now_modal($salesman_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->salesman->save_payment();
	}
	public function show_pay_return_due_modal(){
		$this->permission_check_with_msg('sales_return_payment_add');
		$salesman_id=$this->input->post('salesman_id');
		echo $this->salesman->show_pay_return_due_modal($salesman_id);
	}
	public function save_return_due_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->salesman->save_return_due_payment();
	}
	public function delete_opening_balance_entry(){
		$this->permission_check_with_msg('sales_payment_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->salesman->delete_opening_balance_entry($entry_id);
	}
	/*27-06-2020*/
	public function view_payment_list_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$salesman_id=$this->input->post('salesman_id');
		echo $this->salesman->view_payment_list_modal($salesman_id);
	}
	/*28-06-2020*/
	//Print Salesman Bulk Payment Receipt
	public function print_show_receipt($payment_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('payment_receipt');
		$data=array_merge($data,array('payment_id'=>$payment_id));
		$this->load->view('print-cust-payment-receipt',$data);
	}

	public function restore_salesman_list(){
		echo get_salesman_select_list($this->input->post('salesman_id'),get_current_store_id());
	}
}
