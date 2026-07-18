<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Orders extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('orders_model','orders');
	}

	public function index()
	{
		$this->permission_check('order_view');
		$data=$this->data;
		$data['page_title']="Order List";
		$this->load->view('orders-list',$data);
	}
	
	public function add()
	{
		$this->permission_check('order_add');
		$data=$this->data;
		$data['page_title']="New Order";
		$this->load->view('orders',$data);
	}

	public function purchase_save_and_update(){
		$this->form_validation->set_rules('pur_date', 'Order Date', 'trim|required');
		$this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->orders->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	public function update($id){
		$this->belong_to('db_orders',$id);
		$this->permission_check('order_edit');
		$data=$this->data;
		$data=array_merge($data,array('order_id'=>$id));
		$data['page_title']="Order";
		$this->load->view('orders', $data);
	}
	
	//adding new supplier from Modal
	public function newsupplier(){
		$this->form_validation->set_rules('supplier_name', 'supplier Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('suppliers_model');
			$result=$this->suppliers_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->query("select id,supplier_name from db_suppliers order by id desc limit 1");
			$res['id']=$query->row()->id;
			$res['supplier_name']=$query->row()->supplier_name;
			$res['result']=$result;
			
			echo json_encode($res);
		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->orders->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $order) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$order->id.' class="checkbox column_checkbox" >';
			
			$row[] = show_date($order->order_date);

			$info = (!empty($order->return_bit)) ? "<br><span class='label label-danger' style='cursor:pointer'><i class='fa fa-fw fa-undo'></i>Return Raised</span>" : '';

			$row[] = $order->order_code.$info;
			$row[] = $order->order_status;
			$row[] = $order->reference_no;
			$row[] = $order->supplier_name;
			
			$row[] = store_number_format($order->grand_total);
			$row[] = store_number_format($order->paid_amount);
					$str='';
					if($order->payment_status=='Unpaid')
			          $str= "<span class='label label-danger' style='cursor:pointer'>Unpaid </span>";
					if($order->payment_status=='Partial')
			          $str="<span class='label label-warning' style='cursor:pointer'> Partial </span>";
					if($order->payment_status=='Paid')
			          $str="<span class='label label-success' style='cursor:pointer'> Paid </span>";

			$row[] = $str;
			$row[] = ucfirst($order->created_by);
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';
											if($this->permissions('order_view'))
											$str2.='<li>
												<a title="View Invoice" href="'.base_url().'orders/invoice/'.$order->id.'" ><i class="fa fa-fw fa-eye text-blue"></i>View Order
												</a>
											</li>';

											if($this->permissions('order_edit'))
											$str2.='<li>
												<a title="Update Record ?" href="'.base_url().'orders/update/'.$order->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('order_payment_view'))
											$str2.='
											<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$order->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>View Payments
												</a>
											</li>';

											if($this->permissions('order_payment_add'))
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="pay_now('.$order->id.')" >
													<i class="fa fa-fw  fa-hourglass-half text-blue"></i>Pay Now
												</a>
											</li>';

											if($this->permissions('order_add') || $this->permissions('order_edit'))
											$str2.='<li>
												<a title="Take Print" target="_blank" href="orders/print_invoice/'.$order->id.'">
													<i class="fa fa-fw fa-print text-blue"></i>Print
												</a>
											</li>
											<li>
												<a title="Download PDF" target="_blank" href="'.base_url().'orders/pdf/'.$order->id.'">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
												</a>
											</li>';

											if($this->permissions('order_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_purchase(\''.$order->id.'\')">
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
						"recordsTotal" => $this->orders->count_all(),
						"recordsFiltered" => $this->orders->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	public function delete_purchase(){
		$this->permission_check_with_msg('order_delete');
		$id=$this->input->post('q_id');
		echo $this->orders->delete_purchase($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('order_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->orders->delete_purchase($ids);
	}

	public function search_item(){
		$q=$this->input->get('q');
		$result=$this->orders->search_item($q);
		echo $result;
	}
	public function find_item_details(){
		$id=$this->input->post('id');
		
		$result=$this->orders->find_item_details($id);
		echo $result;
	}

	public function invoice($id)
	{
		$this->belong_to('db_orders',$id);
		if(!$this->permissions('order_add') && !$this->permissions('order_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('order_id'=>$id));
		$data['page_title']="Order Invoice";
		$this->load->view('order-invoice',$data);
	}
	
	public function print_invoice($order_id)
	{
		$this->belong_to('db_orders',$order_id);
		if(!$this->permissions('order_add') && !$this->permissions('order_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('order_id'=>$order_id));
		$data['page_title']="Order Invoice";
		$this->load->view('print-order-invoice-2',$data);
	}
	public function pdf($order_id)
	{
		$this->belong_to('db_orders',$order_id);
		if(!$this->permissions('order_add') && !$this->permissions('order_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('order_id'=>$order_id));
		$data['page_title']="Order Invoice";
		$this->load->view('print-order-invoice-2',$data);

		mb_internal_encoding('UTF-8');

        $html = $this->output->get_output();
        
        $options = new Options();
		$options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html,'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Order-invoice-$order_id-".date('M')."_".date('d')."_".date('Y'), array("Attachment"=>0));
	}

	public function barcode_image($item_code)
	{
		$this->load->library('zend');
	    $this->zend->load('Zend/Barcode');
	    Zend_Barcode::render('code39', 'image', array('text' => $item_code), array());
	}

	public function return_row_with_data($rowcount,$item_id){
		echo $this->orders->get_items_info($rowcount,$item_id);
	}
	public function return_purchase_list($order_id){
		echo $this->orders->return_purchase_list($order_id);
	}
	public function delete_payment(){
		$this->permission_check_with_msg('order_payment_delete');
		$payment_id = $this->input->post('payment_id');
		echo $this->orders->delete_payment($payment_id);
	}

	public function show_pay_now_modal(){
		$this->permission_check_with_msg('order_view');
		$order_id=$this->input->post('purchase_id');
		echo $this->orders->show_pay_now_modal($order_id);
	}

	public function save_payment(){
		$this->permission_check_with_msg('order_add');
		echo $this->orders->save_payment();
	}
	
	public function view_payments_modal(){
		$this->permission_check_with_msg('order_view');
		$order_id=$this->input->post('purchase_id');
		echo $this->orders->view_payments_modal($order_id);
	}
	public function get_suppliers_select_list(){
		echo get_suppliers_select_list(null,$_POST['store_id']);
	}
}
?>
