<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemModel extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_global();
		$this->load->model('item_model_model', 'item_model_model');
	}

	public function add() {
// 		$this->permission_check('brand_add');
		$data = $this->data;
		$data['page_title'] = "Model";
		$this->load->view('item-model', $data);
	}
	public function new_model() {
		$this->form_validation->set_rules('model', 'Model', 'trim|required');
		if ($this->form_validation->run() == TRUE) {

			$this->load->model('item_model_model');
			$result = $this->item_model_model->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Brand name.";
		}
	}
	public function update($id) {
		$this->belong_to('db_item_models', $id);
// 		$this->permission_check('brand_edit');
		$data = $this->data;

		$this->load->model('item_model_model');
		$result = $this->item_model_model->get_details($id, $data);
		$data = array_merge($data, $result);
		$data['page_title'] = "Item Model";
		$this->load->view('brand', $data);
	}
	public function update_brand() {
		$this->form_validation->set_rules('item_model', 'Model', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('item_model_model');
			$result = $this->item_model_model->update_brand();
			echo $result;
		} else {
			echo "Please Enter Model name.";
		}
	}
	public function view() {
// 		$this->permission_check('brand_view');
		$data = $this->data;
		$data['page_title'] = "Model List";
		$this->load->view('item-model-view', $data);
	}

	public function ajax_list() {
		$list = $this->item_model_model->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $item_model) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value=' . $item_model->id . ' class="checkbox column_checkbox" >';
			$row[] = $item_model->model_name;
			$row[] = $item_model->description;

			if ($item_model->status == 1) {
				$str = "<span onclick='update_status(" . $item_model->id . ",0)' id='span_" . $item_model->id . "'  class='label label-success' style='cursor:pointer'>Active </span>";} else {
				$str = "<span onclick='update_status(" . $item_model->id . ",1)' id='span_" . $item_model->id . "'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
			}
			$row[] = $str;
			$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

			if ($this->permissions('brand_edit')) {
				$str2 .= '<li>
												<a title="Edit Record ?" href="' . base_url() . 'brands/update/' . $item_model->id . '">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';
			}

			if ($this->permissions('brand_delete')) {
				$str2 .= '<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_brand(' . $item_model->id . ')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>

										</ul>
									</div>';
			}

			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->item_model_model->count_all(),
			"recordsFiltered" => $this->item_model_model->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function update_status() {
// 		$this->permission_check_with_msg('brand_edit');
		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$this->load->model('item_model_model');
		$result = $this->item_model_model->update_status($id, $status);
		return $result;
	}

	public function delete_model() {
// 		$this->permission_check_with_msg('brand_delete');
		$id = $this->input->post('q_id');
		return $this->item_model_model->delete_brands_from_table($id);
	}
	public function multi_delete() {
// 		$this->permission_check_with_msg('brand_delete');
		$ids = implode(",", $_POST['checkbox']);
		return $this->item_model_model->delete_brands_from_table($ids);
	}

	//ITS FROM POP UP MODAL
	public function add_item_model_modal(){
		$this->form_validation->set_rules('item_model', 'Model Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->item_model_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->select("id,model_name")
						->where('store_id',get_current_store_id())
						->from('db_item_models')
						->order_by('id','desc')
						->limit(1)->get();
						
			$res['id']=$query->row()->id;
			$res['model_name']=$query->row()->model_name;
			$res['result']=$result;
			
			echo json_encode($res);

		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	//END

}
