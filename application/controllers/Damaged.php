<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Damaged extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('damaged_model','damaged');
	}

	public function index()
	{
		$this->permission_check('damaged_view');
		$data=$this->data;
		$data['page_title']='Damaged List';
		$this->load->view('damaged/damaged_list',$data);
	}
	
	public function add()
	{
		$this->permission_check('damaged_add');
		$data=$this->data;
		$data['page_title']='New Damaged Stock';
		$this->load->view('damaged/damaged',$data);
	}

	public function damaged_save_and_update(){
		$this->form_validation->set_rules('damaged_date', 'Damaged Date', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->damaged->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	public function update($id){
		$this->belong_to('db_damaged',$id);
		$this->permission_check('damaged_edit');
		$data=$this->data;
		$data=array_merge($data,array('damaged_id'=>$id));
		$data['page_title']='Update Damaged Stock';
		$this->load->view('damaged/damaged', $data);
	}
	
	public function ajax_list()
	{
		$list = $this->damaged->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $damaged) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$damaged->id.' class="checkbox column_checkbox" >';
			$row[] = show_date($damaged->damaged_date);
			$row[] = $damaged->reference_no;
			$row[] = ucfirst($damaged->created_by);
			$str2 = '<div class="btn-group" title="Action">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';
											if($this->permissions('damaged_view'))
											$str2.='<li>
												<a title="View Invoice" href="'.base_url().'damaged/details/'.$damaged->id.'" ><i class="fa fa-fw fa-eye text-blue"></i>View Details
												</a>
											</li>';

											if($this->permissions('damaged_edit'))
											$str2.='<li>
												<a title="Update Record ?" href="'.base_url().'damaged/update/'.$damaged->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('damaged_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_damaged(\''.$damaged->id.'\')">
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
						"recordsTotal" => $this->damaged->count_all(),
						"recordsFiltered" => $this->damaged->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}
	
	public function delete_damaged(){
		$this->permission_check_with_msg('damaged_delete');
		$id=$this->input->post('q_id');
		echo $this->damaged->delete_damaged($id);
	}
	
	public function multi_delete(){
		$this->permission_check_with_msg('damaged_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->damaged->delete_damaged($ids);
	}

	public function details($id)
	{
		$this->belong_to('db_damaged',$id);
		if(!$this->permissions('damaged_add') && !$this->permissions('damaged_edit') && !$this->permissions('damaged_view')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('damaged_id'=>$id));
		$data['page_title']='Damaged Stock Details';
		$this->load->view('damaged/damaged-invoice',$data);
	}

	public function return_row_with_data($rowcount,$item_id){
		echo $this->damaged->get_items_info($rowcount,$item_id);
	}
	
	public function return_damaged_list($damaged_id){
		echo $this->damaged->return_damaged_list($damaged_id);
	}
}
