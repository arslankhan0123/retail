<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('employees_model','employees');
	}
	
	public function index()
	{
		$this->permission_check('employees_view');
		$data=$this->data;
		$data['page_title']="Employee List";
		$this->load->view('employees-list',$data);
	}

	public function add()
	{
		$this->permission_check('employees_add');
		$data=$this->data;
		$data['page_title']="New Employee";
		$this->load->view('employees',$data);
	}

	public function newemployees(){
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
		$this->form_validation->set_rules('joining_date', 'Joining Date', 'trim|required');
		$this->form_validation->set_rules('basic_salary', 'Basic Salary', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'Iqama No', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->employees->verify_and_save();
			echo $result;
		} else {
			echo validation_errors() ? validation_errors() : "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function view($id){
		$this->belong_to('db_employees',$id);
		$this->permission_check('employees_view');
		$data=$this->data;
		$result=$this->employees->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']="View Employee Details";
		$this->load->view('employee-view', $data);
	}

	public function print_employee($id){
		$this->belong_to('db_employees',$id);
		$this->permission_check('employees_view');
		$data=$this->data;
		$result=$this->employees->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']="Print Employee Details";
		$this->load->view('print-employee', $data);
	}

	public function update($id){
		$this->belong_to('db_employees',$id);
		$this->permission_check('employees_edit');
		$data=$this->data;
		$result=$this->employees->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']="Edit Employee";
		$this->load->view('employees', $data);
	}

	public function update_employees(){
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
		$this->form_validation->set_rules('joining_date', 'Joining Date', 'trim|required');
		$this->form_validation->set_rules('basic_salary', 'Basic Salary', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'Iqama No', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->employees->update_employees();
			echo $result;
		} else {
			echo validation_errors() ? validation_errors() : "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->employees->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $employee) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$employee->id.' class="checkbox column_checkbox" >';
			
			$row[] = $employee->employee_id;
			$row[] = $employee->employee_name;
			$row[] = $employee->phone;
			$row[] = $employee->email;
			$row[] = show_date($employee->joining_date);
			$row[] = $employee->iqama_no;
			$row[] = store_number_format($employee->basic_salary);

			if($employee->status==1){ 
				$str= "<span onclick='update_status(".$employee->id.",0)' id='span_".$employee->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
			else{ 
				$str = "<span onclick='update_status(".$employee->id.",1)' id='span_".$employee->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
			}
			$row[] = $str;			
			
			$str2 = '<div class="btn-group" title="Action">
						<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
							Action <span class="caret"></span>
						</a>
						<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

							if($this->permissions('employees_view')) {
								$str2.='<li>
									<a title="View Profile" href="'.base_url().'employees/view/'.$employee->id.'">
										<i class="fa fa-fw fa-eye text-blue"></i>View Profile
									</a>
								</li>';
								$str2.='<li>
									<a title="Download PDF" target="_blank" href="'.base_url().'employees/print_employee/'.$employee->id.'">
										<i class="fa fa-fw fa-file-pdf-o text-red"></i>Download PDF
									</a>
								</li>';
							}

							if($this->permissions('employees_edit'))
							$str2.='<li>
								<a title="Edit Record" href="'.base_url().'employees/update/'.$employee->id.'">
									<i class="fa fa-fw fa-edit text-blue"></i>Edit
								</a>
							</li>';
							
							if($this->permissions('employees_delete'))
							$str2.='<li>
								<a style="cursor:pointer" title="Delete Record" onclick="delete_employees('.$employee->id.')">
									<i class="fa fa-fw fa-trash text-red"></i>Delete
								</a>
							</li>';
							
						$str2.='</ul>
					</div>';			

			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->employees->count_all(),
			"recordsFiltered" => $this->employees->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('employees_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->employees->update_status($id,$status);
		return $result;
	}
	
	public function delete_employees(){
		$this->permission_check_with_msg('employees_delete');
		$id=$this->input->post('q_id');
		echo $this->employees->delete_employee_from_table($id);
	}

	public function multi_delete(){
		$this->permission_check_with_msg('employees_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->employees->delete_employee_from_table($ids);
	}

	public function delete_doc(){
		$this->permission_check_with_msg('employees_edit');
		$doc_id=$this->input->post('doc_id');
		echo $this->employees->delete_document($doc_id);
	}
}
?>
