<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees_model extends CI_Model {

	var $table = 'db_employees as a';
	var $column_order = array('a.id','a.employee_id','a.employee_name','a.phone','a.email','a.joining_date','a.iqama_no','a.basic_salary','a.status','a.store_id');
	var $column_search = array('a.employee_id','a.employee_name','a.phone','a.email','a.iqama_no','a.basic_salary','a.status','a.store_id');
	var $order = array('a.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->where("a.store_id", get_current_store_id());
		$i = 0;
	
		foreach ($this->column_search as $item)
		{
			if($_POST['search']['value'])
			{
				if($i===0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->where("store_id", get_current_store_id());
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function verify_and_save() {
		extract($this->security->xss_clean(html_escape(array_merge($this->data, $_POST, $_GET))));

		$store_id = (store_module() && is_admin()) ? $store_id : get_current_store_id();

		// Validate Employee ID uniqueness within the store
		$query = $this->db->query("select * from db_employees where employee_id='$employee_id' and store_id=$store_id");
		if($query->num_rows() > 0){
			return "Sorry! This Employee ID already exists.";
		}

		// Save employee image if uploaded
		$employee_image = "";
		if (!empty($_FILES['employee_image']['name'])) {
			$config['upload_path']   = './uploads/employees/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']      = 2048; // 2MB
			$config['file_name']     = 'emp_' . time();
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('employee_image')) {
				$upload_data = $this->upload->data();
				$employee_image = 'uploads/employees/' . $upload_data['file_name'];
			} else {
				return $this->upload->display_errors();
			}
		}

		$this->db->query("ALTER TABLE db_employees AUTO_INCREMENT = 1");

		$info = array(
			'store_id'              => $store_id,
			'employee_id'           => $employee_id,
			'employee_name'         => $employee_name,
			'phone'                 => $phone,
			'email'                 => $email,
			'joining_date'          => system_fromatted_date($joining_date),
			'dob'                   => !empty($dob) ? system_fromatted_date($dob) : NULL,
			'marital_status'        => $marital_status,
			'blood_group'           => $blood_group,
			'gender'                => $gender,
			'country'               => $country,
			'basic_salary'          => $basic_salary,
			'gross_salary'          => !empty($gross_salary) ? $gross_salary : 0.0000,
			'employee_image'        => $employee_image,
			'iqama_no'              => $iqama_no,
			'iqama_expiry'          => !empty($iqama_expiry) ? system_fromatted_date($iqama_expiry) : NULL,
			'passport_no'           => $passport_no,
			'passport_expiry'       => !empty($passport_expiry) ? system_fromatted_date($passport_expiry) : NULL,
			'driving_license_no'    => $driving_license_no,
			'driving_license_expiry'=> !empty($driving_license_expiry) ? system_fromatted_date($driving_license_expiry) : NULL,
			'created_date'          => $CUR_DATE,
			'created_time'          => $CUR_TIME,
			'created_by'            => $CUR_USERNAME,
			'system_ip'             => $SYSTEM_IP,
			'system_name'           => $SYSTEM_NAME,
			'status'                => 1
		);

		$query1 = $this->db->insert('db_employees', $info);
		$emp_id = $this->db->insert_id();

		if ($query1) {
			// Handle multiple documents upload
			$this->save_documents($emp_id, $store_id);
			$this->session->set_flashdata('success', 'Success!! New Employee Added Successfully!');
			return "success";
		} else {
			return "failed";
		}
	}

	public function get_details($id, $data) {
		$query = $this->db->query("select * from db_employees where id='$id'");
		if ($query->num_rows() == 0) {
			show_404(); exit;
		} else {
			$query = $query->row();
			$data['q_id'] = $query->id;
			$data['store_id'] = $query->store_id;
			$data['employee_id'] = $query->employee_id;
			$data['employee_name'] = $query->employee_name;
			$data['phone'] = $query->phone;
			$data['email'] = $query->email;
			$data['joining_date'] = !empty($query->joining_date) ? show_date($query->joining_date) : '';
			$data['dob'] = !empty($query->dob) ? show_date($query->dob) : '';
			$data['marital_status'] = $query->marital_status;
			$data['blood_group'] = $query->blood_group;
			$data['gender'] = $query->gender;
			$data['country'] = $query->country;
			$data['basic_salary'] = $query->basic_salary;
			$data['gross_salary'] = $query->gross_salary;
			$data['employee_image'] = $query->employee_image;
			$data['iqama_no'] = $query->iqama_no;
			$data['iqama_expiry'] = !empty($query->iqama_expiry) ? show_date($query->iqama_expiry) : '';
			$data['passport_no'] = $query->passport_no;
			$data['passport_expiry'] = !empty($query->passport_expiry) ? show_date($query->passport_expiry) : '';
			$data['driving_license_no'] = $query->driving_license_no;
			$data['driving_license_expiry'] = !empty($query->driving_license_expiry) ? show_date($query->driving_license_expiry) : '';
			$data['status'] = $query->status;

			// Fetch documents
			$data['documents'] = $this->db->query("select * from db_employee_docs where emp_id='$id'")->result();

			return $data;
		}
	}

	public function update_employees() {
		extract($this->security->xss_clean(html_escape(array_merge($this->data, $_POST, $_GET))));

		$store_id = (store_module() && is_admin()) ? $store_id : get_current_store_id();

		// Validate Employee ID uniqueness
		$query = $this->db->query("select * from db_employees where employee_id='$employee_id' and id<>$q_id and store_id=$store_id");
		if ($query->num_rows() > 0) {
			return "Employee ID already exists.";
		}

		// Handle Employee Image Update
		$employee_image = "";
		if (!empty($_FILES['employee_image']['name'])) {
			$config['upload_path']   = './uploads/employees/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']      = 2048; // 2MB
			$config['file_name']     = 'emp_' . time();
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('employee_image')) {
				$upload_data = $this->upload->data();
				$employee_image = 'uploads/employees/' . $upload_data['file_name'];
				
				// Delete old image if exists
				$old_img = $this->db->select('employee_image')->where('id', $q_id)->get('db_employees')->row()->employee_image;
				if (!empty($old_img) && file_exists('./' . $old_img)) {
					unlink('./' . $old_img);
				}
			} else {
				return $this->upload->display_errors();
			}
		}

		$info = array(
			'employee_id'           => $employee_id,
			'employee_name'         => $employee_name,
			'phone'                 => $phone,
			'email'                 => $email,
			'joining_date'          => system_fromatted_date($joining_date),
			'dob'                   => !empty($dob) ? system_fromatted_date($dob) : NULL,
			'marital_status'        => $marital_status,
			'blood_group'           => $blood_group,
			'gender'                => $gender,
			'country'               => $country,
			'basic_salary'          => $basic_salary,
			'gross_salary'          => !empty($gross_salary) ? $gross_salary : 0.0000,
			'iqama_no'              => $iqama_no,
			'iqama_expiry'          => !empty($iqama_expiry) ? system_fromatted_date($iqama_expiry) : NULL,
			'passport_no'           => $passport_no,
			'passport_expiry'       => !empty($passport_expiry) ? system_fromatted_date($passport_expiry) : NULL,
			'driving_license_no'    => $driving_license_no,
			'driving_license_expiry'=> !empty($driving_license_expiry) ? system_fromatted_date($driving_license_expiry) : NULL,
			'store_id'              => $store_id
		);

		if (!empty($employee_image)) {
			$info['employee_image'] = $employee_image;
		}

		$query1 = $this->db->where('id', $q_id)->update('db_employees', $info);

		if ($query1) {
			// Handle documents update
			// Note: We can preserve existing documents and only insert new ones, or delete ones that are deleted from repeater.
			// Let's delete all existing and re-upload/re-save, or handle newly added/uploaded files.
			// To keep it simple and robust, we preserve existing docs and allow appending new documents from the repeater.
			$this->save_documents($q_id, $store_id);
			
			$this->session->set_flashdata('success', 'Success!! Employee Updated Successfully!');
			return "success";
		} else {
			return "failed";
		}
	}

	private function save_documents($emp_id, $store_id) {
		if (isset($_POST['doc_name']) && count($_POST['doc_name']) > 0) {
			$this->load->library('upload');
			$files = $_FILES;
			
			foreach ($_POST['doc_name'] as $key => $doc_name) {
				if (empty($doc_name)) continue;

				$doc_expiry = !empty($_POST['doc_expiry'][$key]) ? system_fromatted_date($_POST['doc_expiry'][$key]) : NULL;
				$file_path = "";

				// Check if file is uploaded for this index
				if (!empty($_FILES['doc_file']['name'][$key])) {
					$_FILES['userfile']['name']     = $files['doc_file']['name'][$key];
					$_FILES['userfile']['type']     = $files['doc_file']['type'][$key];
					$_FILES['userfile']['tmp_name'] = $files['doc_file']['tmp_name'][$key];
					$_FILES['userfile']['error']    = $files['doc_file']['error'][$key];
					$_FILES['userfile']['size']     = $files['doc_file']['size'][$key];

					$config['upload_path']   = './uploads/employees/docs/';
					$config['allowed_types'] = 'pdf|jpg|png|jpeg';
					$config['max_size']      = 2048; // 2MB
					$config['file_name']     = 'doc_' . time() . '_' . $key;

					if (!is_dir($config['upload_path'])) {
						mkdir($config['upload_path'], 0777, TRUE);
					}

					$this->upload->initialize($config);

					if ($this->upload->do_upload('userfile')) {
						$upload_data = $this->upload->data();
						$file_path = 'uploads/employees/docs/' . $upload_data['file_name'];
					}
				}

				if (!empty($file_path)) {
					$doc_info = array(
						'emp_id'        => $emp_id,
						'document_name' => $doc_name,
						'file_path'     => $file_path,
						'expiry_date'   => $doc_expiry,
						'store_id'      => $store_id
					);
					$this->db->insert('db_employee_docs', $doc_info);
				}
			}
		}
	}

	public function update_status($id, $status) {
		if (set_status_of_table($id, $status, 'db_employees')) {
			echo "success";
		} else {
			echo "failed";
		}
	}

	public function delete_employee_from_table($ids) {
		$this->db->trans_begin();

		// Fetch all documents to delete files from folder
		$docs = $this->db->select('file_path')->where_in('emp_id', explode(',', $ids))->get('db_employee_docs')->result();
		foreach ($docs as $doc) {
			if (file_exists('./' . $doc->file_path)) {
				unlink('./' . $doc->file_path);
			}
		}

		// Fetch all images to delete
		$imgs = $this->db->select('employee_image')->where_in('id', explode(',', $ids))->get('db_employees')->result();
		foreach ($imgs as $img) {
			if (!empty($img->employee_image) && file_exists('./' . $img->employee_image)) {
				unlink('./' . $img->employee_image);
			}
		}

		$this->db->where_in('emp_id', explode(',', $ids))->delete('db_employee_docs');
		$this->db->where_in('id', explode(',', $ids))->delete('db_employees');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return "failed";
		} else {
			$this->db->trans_commit();
			return "success";
		}
	}

	public function delete_document($doc_id) {
		$doc = $this->db->where('id', $doc_id)->get('db_employee_docs')->row();
		if ($doc) {
			if (file_exists('./' . $doc->file_path)) {
				unlink('./' . $doc->file_path);
			}
			$this->db->where('id', $doc_id)->delete('db_employee_docs');
			return "success";
		}
		return "failed";
	}
}
