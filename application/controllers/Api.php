<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		// Set CORS headers
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
		header('Content-Type: application/json');
	}

	public function login()
	{
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		// Check if data is coming as JSON payload
		if (empty($email) || empty($password)) {
			$json = file_get_contents('php://input');
			$data = json_decode($json, true);
			if (!empty($data)) {
				$email = isset($data['email']) ? $data['email'] : '';
				$password = isset($data['password']) ? $data['password'] : '';
			}
		}

		if (empty($email) || empty($password)) {
			echo json_encode([
				'status' => false, 
				'message' => 'Email and Password are required'
			]);
			return;
		}

		// Filtering XSS and html escape from user inputs 
		$email = $this->security->xss_clean(html_escape($email));
		$password = $this->security->xss_clean(html_escape($password));

		$this->db->select("a.email,a.store_id,a.id,a.username,a.role_id,b.role_name,a.status,a.last_name,a.password");
		$this->db->from("db_users a");
		$this->db->from("db_roles b");
		$this->db->where("b.id=a.role_id");
		$this->db->where("a.email", $email);
		$this->db->where("a.password", md5($password));
		$query = $this->db->get();

		if ($query->num_rows() == 1) {

			// Verify is SaaS module Active ?
			if ($query->row()->id == 1) {
				if (!store_module()) {
					echo json_encode([
						'status' => false, 
						'message' => 'Access Denied!! SaaS module is not Active!!'
					]);
					return;
				}
			}

			$store_rec = get_store_details($query->row()->store_id);
			
			// STORE ACTIVE OR NOT
			if (!$store_rec->status) {
				echo json_encode([
					'status' => false, 
					'message' => 'Your Store Temporarily Inactive!'
				]);
				return;
			}
			
			// USER ACTIVE OR NOT
			if (!$query->row()->status) {
				echo json_encode([
					'status' => false, 
					'message' => 'Your account is temporarily inactive!'
				]);
				return;
			}

			// Generate a simple stateless token
			$token = base64_encode($query->row()->id . ':' . $query->row()->email . ':' . $query->row()->password);

			// Login successful
			$user_data = array(
				'id' => $query->row()->id,
				'username' => $query->row()->username,
				'last_name' => $query->row()->last_name,
				'role_id' => $query->row()->role_id,
				'role_name' => trim($query->row()->role_name),
				'store_id' => trim($query->row()->store_id),
				'email' => trim($query->row()->email),
				'token' => $token
			);

			echo json_encode([
				'status' => true,
				'message' => 'Login successful',
				'data' => $user_data
			]);

		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Invalid Email or Password!'
			]);
		}
	}

	private function _verify_token()
	{
		$headers = $this->input->request_headers();
		$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
		
		if (empty($auth_header)) {
			$auth_header = $this->input->post('token');
		}

		$auth_header = str_replace('Bearer ', '', $auth_header);

		if (empty($auth_header)) {
			return false;
		}

		$decoded = base64_decode($auth_header);
		$parts = explode(':', $decoded);
		
		if (count($parts) != 3) {
			return false;
		}

		$user_id = $parts[0];
		$email = $parts[1];
		$password_hash = $parts[2];

		$this->db->where('id', $user_id);
		$this->db->where('email', $email);
		$this->db->where('password', $password_hash);
		$user_check = $this->db->get('db_users');

		if ($user_check->num_rows() == 0) {
			return false;
		}

		$user = $user_check->row();

		// Populate session so that existing models/helpers work (e.g. get_current_store_id())
		$role_name = $this->db->select('role_name')->where('id', $user->role_id)->get('db_roles')->row()->role_name;
		$logdata = array(
			'inv_username'  => $user->username,
			'user_lname'  => $user->last_name,
			'inv_userid'  => $user->id,
			'logged_in' => TRUE,
			'role_id' => $user->role_id,
			'role_name' => trim($role_name),
			'store_id' => trim($user->store_id),
			'email' => trim($user->email),
		);
		$this->session->set_userdata($logdata);

		return $user; // Return user data if valid
	}

	public function sales()
	{
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

		// Verify Authentication
		$user = $this->_verify_token();
		if (!$user) {
			echo json_encode([
				'status' => false,
				'message' => 'Unauthorized. Please login to get a valid token.'
			]);
			return;
		}
        
        $this->db->select("a.id, a.sales_date, a.sales_code, a.reference_no, b.customer_name, a.grand_total, a.paid_amount, a.payment_status, a.created_by, a.sales_status");
		$this->db->from("db_sales a");
		$this->db->join('db_customers b','b.id=a.customer_id','left');
		$this->db->order_by('a.id', 'desc');
		
		// Optional limit and offset for pagination
		$limit = $this->input->post('limit') ? $this->input->post('limit') : 100;
		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$this->db->limit($limit, $offset);

		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		    echo json_encode([
		        'status' => true, 
		        'message' => 'Sales list fetched successfully',
		        'data' => $query->result()
		    ]);
		} else {
		    echo json_encode([
		        'status' => false, 
		        'message' => 'No sales found',
		        'data' => []
		    ]);
		}
	}

	public function sales_return()
	{
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

		// Verify Authentication
		$user = $this->_verify_token();
		if (!$user) {
			echo json_encode([
				'status' => false,
				'message' => 'Unauthorized. Please login to get a valid token.'
			]);
			return;
		}
        
        $this->db->select("a.id, a.return_date, c.sales_code, a.return_code, a.return_status, a.reference_no, b.customer_name, a.grand_total, a.paid_amount, a.payment_status, a.created_by");
		$this->db->from("db_salesreturn a");
		$this->db->join('db_customers b','b.id=a.customer_id','left');
		$this->db->join('db_sales c','c.id=a.sales_id','left');
		$this->db->order_by('a.id', 'desc');
		
		// Optional limit and offset for pagination
		$limit = $this->input->post('limit') ? $this->input->post('limit') : 100;
		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$this->db->limit($limit, $offset);

		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		    echo json_encode([
		        'status' => true, 
		        'message' => 'Sales return list fetched successfully',
		        'data' => $query->result()
		    ]);
		} else {
		    echo json_encode([
		        'status' => false, 
		        'message' => 'No sales return found',
		        'data' => []
		    ]);
		}
	}

	public function items()
	{
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

		// Verify Authentication
		$user = $this->_verify_token();
		if (!$user) {
			echo json_encode([
				'status' => false,
				'message' => 'Unauthorized. Please login to get a valid token.'
			]);
			return;
		}
        
        $this->db->select("a.id, a.item_code, a.item_name, a.description, b.category_name, c.unit_name, a.price, a.sales_price, a.purchase_price, d.tax_name, d.tax, a.status, a.alert_qty, a.item_image, e.brand_name, a.sku, a.hsn, a.custom_barcode, a.service_bit, a.item_group, a.opening_stock");
		$this->db->from("db_items as a");
		$this->db->join("db_category as b","b.id=a.category_id","left");
		$this->db->join("db_units as c","c.id=a.unit_id","left");
		$this->db->join("db_tax as d","d.id=a.tax_id","left");
		$this->db->join("db_brands as e","e.id=a.brand_id","left");
		$this->db->order_by('a.id', 'desc');
		
		// Optional limit and offset for pagination
		$limit = $this->input->post('limit') ? $this->input->post('limit') : 100;
		$offset = $this->input->post('offset') ? $this->input->post('offset') : 0;
		$this->db->limit($limit, $offset);

		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$items_data = $query->result();

			// Add stock information
			$this->load->helper('custom'); // Make sure custom_helper is loaded if needed for total_available_qty_items_of_warehouse
			foreach($items_data as &$item) {
				// Get image full URL if exists
				if(!empty($item->item_image)) {
					$item->item_image = base_url($item->item_image);
				}
				
				// Optional: get current stock
				if(function_exists('total_available_qty_items_of_warehouse')){
					$item->current_stock = total_available_qty_items_of_warehouse(null, null, $item->id);
				} else {
					$item->current_stock = 0;
				}
			}

		    echo json_encode([
		        'status' => true, 
		        'message' => 'Items list fetched successfully',
		        'data' => $items_data
		    ]);
		} else {
		    echo json_encode([
		        'status' => false, 
		        'message' => 'No items found',
		        'data' => []
		    ]);
		}
	}

	public function profit_loss()
	{
		// Handle preflight request
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

		// Verify Authentication
		$user = $this->_verify_token();
		if (!$user) {
			echo json_encode([
				'status' => false,
				'message' => 'Unauthorized. Please login to get a valid token.'
			]);
			return;
		}
        
		$this->load->model('reports_model','reports');

		// The get_profit_loss_report method reads from $_POST. We need to support GET params as well.
		if ($this->input->get('from_date')) $_POST['from_date'] = $this->input->get('from_date');
		if ($this->input->get('to_date')) $_POST['to_date'] = $this->input->get('to_date');
		if ($this->input->get('store_id')) $_POST['store_id'] = $this->input->get('store_id');

		// In case they send JSON body instead of form-data, we need to populate $_POST for the model
		$json = file_get_contents('php://input');
		$data = json_decode($json, true);
		if (!empty($data)) {
			if(isset($data['from_date'])) $_POST['from_date'] = $data['from_date'];
			if(isset($data['to_date'])) $_POST['to_date'] = $data['to_date'];
			if(isset($data['store_id'])) $_POST['store_id'] = $data['store_id'];
		}

		// Default to current user's store_id if not provided
		if(empty($_POST['store_id'])){
			$_POST['store_id'] = $user->store_id; 
		}

		// The get_profit_loss_report method reads from $_POST
		$report_data = $this->reports->get_profit_loss_report();
		
		echo json_encode([
			'status' => true, 
			'message' => 'Profit loss report fetched successfully',
			'data' => $report_data
		]);
	}
}
