<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_model extends CI_Model {

	private function ensure_void_log_tables(){
		$this->db->query("CREATE TABLE IF NOT EXISTS db_voidlogs (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, store_id INT NULL, warehouse_id INT NULL,
			user_id INT NOT NULL, salesman_id INT NOT NULL, invoice_date DATE NOT NULL, invoice_time TIME NOT NULL,
			invoice_no VARCHAR(100) NOT NULL, invoice_type ENUM('POS','Sale') NOT NULL DEFAULT 'POS',
			delete_type ENUM('Single','Bulk') NOT NULL, created_at DATETIME NOT NULL,
			PRIMARY KEY (id), KEY idx_void_invoice (invoice_no), KEY idx_void_salesman (salesman_id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		$this->db->query("CREATE TABLE IF NOT EXISTS db_voidlogitems (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, void_log_id BIGINT UNSIGNED NOT NULL,
			item_id INT NULL, barcode VARCHAR(100) NULL, item_code VARCHAR(100) NULL,
			item_name VARCHAR(255) NOT NULL, qty DECIMAL(20,4) NOT NULL DEFAULT 0,
			price DECIMAL(20,4) NOT NULL DEFAULT 0, disc DECIMAL(20,4) NOT NULL DEFAULT 0,
			tax DECIMAL(20,4) NOT NULL DEFAULT 0, subtotal DECIMAL(20,4) NOT NULL DEFAULT 0,
			PRIMARY KEY (id), KEY idx_voidlog_parent (void_log_id),
			CONSTRAINT fk_voidlogitems_parent FOREIGN KEY (void_log_id) REFERENCES db_voidlogs (id) ON DELETE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
	}

	public function save_void_log(){
		$items = json_decode($this->input->post('items'), true);
		$delete_type = $this->input->post('delete_type') === 'Bulk' ? 'Bulk' : 'Single';
		$salesman_id = (int)$this->input->post('salesman_id');
		if(!$salesman_id) return array('status'=>'error','message'=>'Please Select Salesman!!');
		if(!is_array($items) || count($items)<1) return array('status'=>'error','message'=>'No item was supplied for void logging.');

		$this->ensure_void_log_tables();
		$this->db->trans_begin();
		$this->db->insert('db_voidlogs', array(
			'store_id'=>(int)$this->input->post('store_id'), 'warehouse_id'=>(int)$this->input->post('warehouse_id') ?: null,
			'user_id'=>(int)$this->session->userdata('inv_userid'), 'salesman_id'=>$salesman_id,
			'invoice_date'=>date('Y-m-d'), 'invoice_time'=>date('H:i:s'),
			'invoice_no'=>$this->xss_html_filter($this->input->post('invoice_no')),
			'invoice_type'=>'POS', 'delete_type'=>$delete_type, 'created_at'=>date('Y-m-d H:i:s')
		));
		$void_log_id = $this->db->insert_id();
		foreach($items as $item){
			$item_id = isset($item['item_id']) ? (int)$item['item_id'] : 0;
			$master = $item_id ? $this->db->select('item_code,item_name,custom_barcode')->where('id',$item_id)->get('db_items')->row() : null;
			$this->db->insert('db_voidlogitems', array(
				'void_log_id'=>$void_log_id, 'item_id'=>$item_id ?: null,
				'barcode'=>$master ? $master->custom_barcode : '', 'item_code'=>$master ? $master->item_code : '',
				'item_name'=>$master ? $master->item_name : 'Unknown item',
				'qty'=>(float)($item['qty'] ?? 0), 'price'=>(float)($item['price'] ?? 0),
				'disc'=>(float)($item['disc'] ?? 0), 'tax'=>(float)($item['tax'] ?? 0),
				'subtotal'=>(float)($item['subtotal'] ?? 0)
			));
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return array('status'=>'error','message'=>'Void log could not be saved. Item(s) were not removed.');
		}
		$this->db->trans_commit();
		return array('status'=>'success','message'=>'Void log saved.','void_log_id'=>$void_log_id);
	}

	public function inclusive($price='',$tax_per){
		return ($tax_per!=0) ? $price/(($tax_per/100)+1)/10 : $tax_per;
	}

	public function get_item_details($item_id)
	{
		  $this->db->select("b.id as tax_id, a.*,b.tax,b.tax_name");
	      $this->db->from("db_items a");
	      $this->db->join("db_tax b","b.id=a.tax_id","left");
	      $this->db->where("a.status=1");
	      $this->db->where("a.id",$item_id);
		  //echo $this->db->get_compiled_select();exit();
		  $res1=$this->db->get()->row();

	      $item_tax_amt = ($res1->tax_type=='Inclusive') ? calculate_inclusive($res1->sales_price,$res1->tax) :calculate_exclusive($res1->sales_price,$res1->tax);
	      
	      $warehouse_stock = total_available_qty_items_of_warehouse($this->input->post('warehouse_id'),null,$item_id);
	      $item_array = array(
	      				'id' 					=> $res1->id,
	      				'item_name' 			=> $res1->item_name,
	      				'stock' 				=> $warehouse_stock,
	      				'sales_price' 			=> $res1->sales_price,
	      				'purchase_price' 		=> $res1->purchase_price,
	      				'tax_id' 				=> $res1->tax_id,
	      				'tax_type' 				=> $res1->tax_type,
	      				'tax' 					=> $res1->tax,
	      				'tax_name' 				=> $res1->tax_name,
	      				'item_tax_amt' 			=> $item_tax_amt,
	      				'discount_type' 		=> $res1->discount_type,
	      				'discount' 				=> $res1->discount,
	      				'service_bit' 			=> $res1->service_bit,
	      				'custom_barcode' 		=> $res1->custom_barcode,
	      );

	      return json_encode($item_array);

	}

	public function get_details(){

		//echo "<pre>";print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();

		$data=$this->data;
		extract($data);
		extract($_POST);
		$CI =& get_instance();
		$category_id = $this->input->post('id', true);
		$department_id = $this->input->post('dptid', true);
		$subcategory_id = $this->input->post('scatid', true);
		$selected_brand_id = $this->input->post('brand_id', true);
		
		
		  $i=0;
		 
		if($category_id !== null && $category_id !== ''){
			$this->db->where("a.category_id", (int)$category_id);
		}
		if($department_id !== null && $department_id !== ''){
			$this->db->where("a.dptid", (int)$department_id);
		}
		if($subcategory_id !== null && $subcategory_id !== ''){
			$this->db->where("a.scatid", (int)$subcategory_id);
		}
		if($selected_brand_id !== null && $selected_brand_id !== ''){
			$this->db->where("a.brand_id", (int)$selected_brand_id);
		}
		  $this->db->select("a.*,b.tax,b.tax_name");

		  $this->db->join(" db_tax b ","b.id=a.tax_id",'left');
		  
		  $this->db->from("db_items as a");
		  $this->db->where("a.store_id",$store_id);
		  $this->db->where("a.status",1);
		if(!empty($search_it)){
			$this->db->group_start()
				->like('a.item_name', $search_it)
				->or_like('a.item_code', $search_it)
				->or_like('a.custom_barcode', $search_it)
			->group_end();
		}
		  if(isset($last_id) && !empty($last_id)){
		  	$this->db->where("a.id>".$last_id);
		  }
		  $this->db->limit(30);

		  //echo $this->db->get_compiled_select();exit();

	      $q2=$this->db->get();
	      $table='';
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	        	if($res2->item_group=='Variants'){continue;}
	        	$w_stock = total_available_qty_items_of_warehouse($warehouse_id,$store_id,$res2->id);
	        	$item_code = $res2->item_code;
	        	$item_tax_type = $res2->tax_type;
	        	$item_tax_id = $res2->tax_id;


	        	$discount_type = $res2->discount_type;
	        	$discount = $res2->discount;
	        	

	        	$item_mrp = get_price_level_price($customer_id,$res2->mrp);
				$item_mrp = number_format($item_mrp,decimals(),'.','');

	        	$item_sales_price = get_price_level_price($customer_id,$res2->sales_price);
				$item_sales_price = number_format($item_sales_price,decimals(),'.','');

	        	$item_cost = $res2->purchase_price;
	        	$item_tax = $res2->tax;
	        	$item_tax_name = $res2->tax_name;
	        	$service_bit = $res2->service_bit;
	        	$item_sales_qty = 1;

				$item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

				
	        	// Negative stock sales are allowed in POS.
	        	$str="addrow($res2->id)";
	        	$disabled='';
	        	$bg_color="background-color:#82d6a3";

	        	$label_title = (!$service_bit) ? $w_stock.' Quantity in Stock' : 'Service Item';
	        	$label = (!$service_bit) ? "Qty: ".$w_stock : 'Service';

	        	$item_image = $res2->item_image;
	        	if(!empty($res2->parent_id)){
	        		$item_image = get_item_details($res2->parent_id)->item_image;
	        	}

	        	$img_src = (!empty($item_image) && file_exists($item_image)) ? base_url(return_item_image_thumb($item_image)) : base_url('theme/images/no_image.png');

	        	$table .= '<div class="col-md-3 col-xs-6 " id="item_parent_'.$i.'" '.$disabled.' style="padding-left:5px;padding-right:5px;">
	          <div class="box box-default item_box" id="div_'.$res2->id.'" onclick="'.$str.'"
	          				data-item-id="'.$res2->id.'"
	          				data-item-name="'.$res2->item_name.'"
	          				data-item-available-qty="'.$w_stock.'"
	          				data-item-sales-price="'.$item_sales_price.'"
	          				data-item-cost="'.$item_cost.'"
	          				data-item-tax-id="'.$item_tax_id.'"
	          				data-item-tax-type="'.$item_tax_type.'"
	          				data-item-tax-value="'.$item_tax.'"
	          				data-item-tax-name="'.$item_tax_name.'"
	          				data-item-tax-amt="'.$item_tax_amt.'"
	          				data-service_bit="'.$service_bit.'"
	          				data-discount_type="'.$discount_type.'"
	          		data-mrp="'.$item_sales_price.'"
	          				data-discount="'.$discount.'"
	          				data-custom-barcode="'.$res2->custom_barcode.'"
	           				style="max-height: 150px;min-height: 150px;cursor: pointer;'.$bg_color.'">';

	           	if ($service_bit) {
	           		$table .= '<!-- <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$label_title.'">'.$label.'</span> -->';
	           	} else {
	           		$table .= '<!-- <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$label_title.'">'.$label.'</span> -->';
	           	}


	           	$table .= '<div class="box-body box-profile">
	            	<center>
	            	<img class=" img-responsive item_image" style="border: 1px solid gray;"  src="'.$img_src.'" alt="Item picture">
	              </center>
	              <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif;" id="item_'.$i.'">'.substr($res2->item_name,0,25).'</label><br>
	              <span class="item_price" style="font-family: sans-serif;" >'.store_number_format($item_sales_price).'
	              </span>
	            </div>


	          </div>
	        </div>';
	          $i++;
	          }//for end
	          return $table;
	      }//if num_rows() end
	     
	}
	//CROSS SITE FILTER
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	
	//Save Sales
	public function pos_save_update(){//Save or update sales
		$this->db->trans_begin();
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();

		if(empty($salesman_id)){
			$this->db->trans_rollback();
			return "Please Select Salesman!!";
		}

		//varify max sales usage of the package subscription
		validate_package_offers('max_invoices','db_sales');
		//END

		//check payment method
		if(isset($by_cash) && $by_cash==true){ //by cash payment
			$by_cash=true;
			$payment_row_count=1;
		}else{ //by multiple payments
			$by_cash=false;
		}
		//end 

		$store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();
		$rowcount 			=$hidden_rowcount;
		$sales_date 		=date("Y-m-d",strtotime($CUR_DATE));
		//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
		$discount_input 	= (empty($discount_input)) ? 'NULL' : $discount_input;
		$tot_disc 		= (empty($tot_disc) || $tot_disc==0) ? 'NULL' : $tot_disc;
		$raw_total = (float) string_to_number($tot_amt)
			- (float) string_to_number($tot_disc)
			- (float) string_to_number($coupon_discount_amt);
		if(is_enabled_round_off()){
			$tot_grand = number_format(round($raw_total), decimals(), '.', '');
			$round_off = number_format((float)$tot_grand - $raw_total, decimals(), '.', '');
		}
		else{
			$tot_grand = number_format($raw_total, decimals(), '.', '');
			$round_off = null;
		}
		

		//FIND CUSTOMER INFORMATION BY ITS ID
		$q1=$this->db->query("select customer_name,mobile,delete_bit from db_customers where id=$customer_id");
		$customer_name 	= $q1->row()->customer_name;
		$mobile 		= $q1->row()->mobile;

		// Walk-in customers cannot have credit payments. Enforce this on the
		// server as well as in the POS UI so the rule cannot be bypassed.
		if((int)$q1->row()->delete_bit === 1){
			$has_credit_payment = isset($direct_payment_type) && strtoupper(trim($direct_payment_type)) === 'CREDIT';
			for($payment_index=1; !$has_credit_payment && $payment_index<=(int)$payment_row_count; $payment_index++){
				$payment_type_key = 'payment_type_'.$payment_index;
				if(isset($_REQUEST[$payment_type_key]) && strtoupper(trim($_REQUEST[$payment_type_key])) === 'CREDIT'){
					$has_credit_payment = true;
				}
			}
			if($has_credit_payment){
				return "Credit sale is not allowed for Walk-in Customer. Please select another customer.";
			}
		}


		//Get coupon details
	    $customer_coupon_id = null;
	    if(!empty($coupon_code)){
	    	$coupon_details = get_customer_coupon_details_by_coupon_code($coupon_code);
	    	
		    if($coupon_details->num_rows()>0){
		    	if($coupon_details->row()->customer_id==$customer_id){
		    		$customer_coupon_id = $coupon_details->row()->id;		
		    	}
		    }
	    }

		$sales_entry_init = array(
	    							'init_code' 				=> $init_code,
				    				'count_id' 					=> $count_id,
				    				'sales_code' 				=> $init_code.$count_id,
				    				/*Coupon disocunt amt*/
				    				'coupon_id' 				=> $customer_coupon_id,
				    				'coupon_amt' 				=> $coupon_discount_amt,
				    				'invoice_terms' 			=> $invoice_terms,
	    						);


		$prev_item_ids = array();
		$previous_sales_qty = array();

		if($command=='update'){
				$previous_rows = $this->db->select('item_id, SUM(sales_qty) AS sales_qty', false)
					->where('sales_id',$sales_id)->group_by('item_id')->get('db_salesitems')->result();
				foreach($previous_rows as $previous_row){
					$previous_sales_qty[(int)$previous_row->item_id] = (float)$previous_row->sales_qty;
				}
				$sales_entry = array(
		    				'store_id' 				=> $store_id,
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> 'Final',
		    				'customer_id' 				=> $customer_id,
		    				'salesman_id' 				=> empty($salesman_id) ? null : $salesman_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Discount*/
		    				'discount_to_all_input' 	=> $discount_input,
		    				'discount_to_all_type' 		=> $discount_type,
		    				'tot_discount_to_all_amt' 	=> $tot_disc,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $tot_amt,
		    				'round_off' 				=> $round_off,
		    				'grand_total' 				=> $tot_grand,
		    				'sales_note' 				=> $sales_note,
		    			);
				$sales_entry['warehouse_id']=(warehouse_module() && warehouse_count()>1) ? $warehouse_id : get_store_warehouse_id();
				$q3 = $this->db->where('id',$sales_id)->update('db_sales', array_merge($sales_entry,$sales_entry_init));

				##############################################START
				//FIND THE PREVIOUSE ITEM LIST ID'S
				$prev_item_ids = $this->db->select("item_id")->from("db_salesitems")->where("sales_id",$sales_id)->get()->result_array();
				##############################################END
				
				$q11=$this->db->query("delete from db_salesitems where sales_id='$sales_id'");
				$q12=$this->db->query("delete from db_salespayments where sales_id='$sales_id'");
				if(!$q11 || !$q12){
					return "failed";
				}
		}
		else{
			$this->db->query("ALTER TABLE db_sales AUTO_INCREMENT = 1");

			$sales_entry = array(
							//'count_id' 					=> get_count_id('db_sales'),  
		    				//'sales_code' 				=> get_init_code('sales'), 
		    				'store_id' 				=> $store_id,
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> 'Final',
		    				'customer_id' 				=> $customer_id,
		    				'salesman_id' 				=> empty($salesman_id) ? null : $salesman_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Discount*/
		    				'discount_to_all_input' 	=> $discount_input,
		    				'discount_to_all_type' 		=> $discount_type,
		    				'tot_discount_to_all_amt' 	=> $tot_disc,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $tot_amt,
		    				'round_off' 				=> $round_off,
		    				'grand_total' 				=> $tot_grand,
		    				/*System Info*/
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $CUR_USERNAME,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'pos' 						=> 1,
		    				'status' 					=> 1,
		    				'sales_note' 				=> $sales_note,
		    				'sales_type'                => 'wholesale'
		    			);
			$sales_entry['warehouse_id']=(warehouse_module() && warehouse_count()>1) ? $warehouse_id : get_store_warehouse_id();

			
			$q3 = $this->db->insert('db_sales', array_merge($sales_entry,$sales_entry_init));
			$sales_id = $this->db->insert_id();
		}

		//Verify Sales Code
		$this->db->where("sales_code",$sales_entry_init['sales_code']);
		//if($command=='update'){
			$this->db->where("id<>",$sales_id);
		//}
		$this->db->from('db_sales');
		$count = $this->db->count_all_results();
		

		if($count>0){
			echo "Sales Code already exist";
			exit;
		}


		$remaining_stock_by_item = array();
		//Import post data from form
		for($i=0;$i<$rowcount;$i++){
		
			if(isset($_REQUEST['tr_item_id_'.$i]) && trim($_REQUEST['tr_item_id_'.$i])!=''){
			
				//RECEIVE VALUES FROM FORM
				$item_id 	=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$sales_qty 	=$this->xss_html_filter(trim($_REQUEST['item_qty_'.$i]));
				if (!ctype_digit((string) $sales_qty) || (int) $sales_qty < 1 || (int) $sales_qty > 999) {
					$this->db->trans_rollback();
					return "Quantity must be a whole number between 1 and 999.";
				}
				$price_per_unit =$this->xss_html_filter(trim($_REQUEST['sales_price_'.$i]));
				$tax_amt =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
				$tax_type =$this->xss_html_filter(trim($_REQUEST['tr_tax_type_'.$i]));
				$tax_id =$this->xss_html_filter(trim($_REQUEST['tr_tax_id_'.$i]));
				$tax_value =$this->xss_html_filter(trim($_REQUEST['tr_tax_value_'.$i]));//%
				$total_cost =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
				$description =$this->xss_html_filter(trim($_REQUEST['description_'.$i]));
				
				$discount_type =$this->xss_html_filter(trim($_REQUEST['item_discount_type_'.$i]));
				$discount_input =$this->xss_html_filter(trim($_REQUEST['item_discount_input_'.$i]));
				$discount_amt =$this->xss_html_filter(trim($_REQUEST['item_discount_'.$i]));

				if($tax_type=='Exclusive'){
					$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
				}
				else{//Inclusive
					$single_unit_total_cost =$price_per_unit;
				}

				
				if($tax_id=='' || $tax_id==0){$tax_id=null;}
				if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
				if($total_cost=='' || $total_cost==0){$total_cost=null;}
				
				
				/* ******************************** */
				//Find the qty available or not
				$item_details = get_item_details($item_id);
				$item_name = $item_details->item_name;
				$service_bit = $item_details->service_bit;
				$purchase_price = $item_details->purchase_price;

				if ((float) $price_per_unit < (float) $purchase_price) {
					$this->db->trans_rollback();
					return $item_name." sales price cannot be less than purchase price (".
						store_number_format($purchase_price).")";
				}

				
				if(!isset($remaining_stock_by_item[(int)$item_id])){
					$current_stock_of_item = total_available_qty_items_of_warehouse($warehouse_id,null,$item_id);
					$remaining_stock_by_item[(int)$item_id] = $current_stock_of_item + (($command=='update' && isset($previous_sales_qty[(int)$item_id])) ? $previous_sales_qty[(int)$item_id] : 0);
				}
				$available_for_sale = $remaining_stock_by_item[(int)$item_id];
				if(!is_negative_stock_allowed($store_id) && $available_for_sale<$sales_qty && $service_bit==0){
					return $item_name." has only ".$available_for_sale." in Stock!!";exit;
				}
				$remaining_stock_by_item[(int)$item_id] -= (float)$sales_qty;
				
				$salesitems_entry = array(
		    				'store_id' 			=> $store_id, 
		    				'sales_id' 			=> $sales_id, 
		    				'sales_status'		=> 'Final', 
		    				'item_id' 			=> $item_id, 
		    				'description' 		=> $description, 
		    				'sales_qty' 		=> $sales_qty,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'tax_type' 			=> $tax_type,
		    				'discount_type' 	=> $discount_type,
		    				'discount_input' 	=> $discount_input,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $total_cost,
		    				'purchase_price' 	=> $purchase_price,
		    				'status'	 		=> 1,
		    				'seller_points'		=> get_seller_points($item_id) * $sales_qty,
		    			);
				$q4 = $this->db->insert('db_salesitems', $salesitems_entry);

				$q11=$this->update_items_quantity($item_id);
				if(!$q11){
					return "failed";
				}

			}
		
		}//for end
		
		if($pay_all=='true'){
			$by_cash=true;
			$payment_row_count=1;
		}
		else{
			$by_cash=false;
		}

		$tot_received_amt = 0;
		$currency_decimals = (int) decimals();
		$invoice_total_numeric = round((float) str_replace(',', '', trim($tot_grand)), $currency_decimals);
		// Calculate change from the complete tendered amount. This also handles
		// multiple payments where no single row exceeds the invoice total.
		$tendered_total = isset($paid_amt) ? str_replace(',', '', trim($paid_amt)) : 0;
		$invoice_total = str_replace(',', '', trim($tot_grand));
		$expected_change_return = (is_numeric($tendered_total) && is_numeric($invoice_total))
			? max(0, round((float)$tendered_total, $currency_decimals) - $invoice_total_numeric)
			: 0;
		//UPDATE CUSTMER MULTPLE PAYMENTS
		for($i=1;$i<=$payment_row_count;$i++){
		
			if((isset($_REQUEST['amount_'.$i]) && trim($_REQUEST['amount_'.$i])!='') || ($by_cash==true)){

				if($by_cash==true){
					//RECEIVE VALUES FROM FORM
					$amount 		=$tot_grand;
					$payment_type 	='Cash';
					$payment_note 	='Paid By Cash';
				}
				else{
					//RECEIVE VALUES FROM FORM
					$amount_input = $this->xss_html_filter(trim($_REQUEST['amount_'.$i]));
					// Payment fields may contain thousands separators from formatted
					// POS values. Convert them before doing arithmetic or saving.
					$amount_input = str_replace(',', '', $amount_input);
					if(!is_numeric($amount_input) || $amount_input < 0){
						return "Invalid payment amount in payment row ".$i.".";
					}
					$amount 		= round((float) $amount_input, $currency_decimals);
					$requested_payment_type = isset($_REQUEST['payment_type_'.$i])
						? $_REQUEST['payment_type_'.$i]
						: (isset($_REQUEST['direct_payment_type']) ? $_REQUEST['direct_payment_type'] : '');
					$payment_type 	=$this->xss_html_filter(trim($requested_payment_type));
					$requested_payment_note = isset($_REQUEST['payment_note_'.$i])
						? $_REQUEST['payment_note_'.$i]
						: (!empty($payment_type) ? 'Paid By '.$payment_type : '');
					$payment_note 	=$this->xss_html_filter(trim($requested_payment_note));
				}

				$account_id 	=$this->xss_html_filter(trim($_REQUEST['account_id_'.$i]));
				//If amount is greater than paid amount
				$change_return=0;
				if($amount>$invoice_total_numeric){
					$change_return = round($amount-$invoice_total_numeric, $currency_decimals);
					$amount = $invoice_total_numeric;
				}
				if($i===1 && $expected_change_return>$change_return){
					$change_return = $expected_change_return;
				}
				//end
				$payment_code=get_init_code('sales_payment');
				$salespayments_entry = array(
					'payment_code' 		=> $payment_code,
		    		'count_id'	  		=> get_count_id('db_salespayments'),
					'store_id' 		=> $store_id, 
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $sales_date,//Current Payment with sales entry
					'payment_type' 		=> $payment_type,
					'payment' 			=> $amount,
					'payment_note' 		=> $payment_note,
					'created_date' 		=> $CUR_DATE,
    				'created_time' 		=> $CUR_TIME,
    				'created_by' 		=> $CUR_USERNAME,
    				'system_ip' 		=> $SYSTEM_IP,
    				'system_name' 		=> $SYSTEM_NAME,
    				'change_return' 	=> $change_return,
    				'status' 			=> 1,
    				'customer_id' 		=> $customer_id,
    				'account_id' 		=> (empty($account_id)) ? null : $account_id,
				);


				//is total advance payment enabled ?
				$advance_adjusted=0;
				if(isset($allow_tot_advance)){
					$tot_advance = get_customer_details($customer_id)->tot_advance;
					if($tot_advance>0){
						if($amount==$tot_advance){
							$advance_adjusted = $amount;
						}
						else if($amount>$tot_advance){
							$advance_adjusted = $tot_advance;	
						}
						else{
							$advance_adjusted =  $amount;
						}
					}
				}
				//end 
				$salespayments_entry['advance_adjusted'] = $advance_adjusted;


			  
			  $q7 = $this->db->insert('db_salespayments', $salespayments_entry);
			  $last_insert_id = $this->db->insert_id();

			    if(!$q7)
				{
					return "failed";
				}

				// Persist returned change explicitly. Some existing database
				// configurations/defaults have been observed resetting this
				// value during the initial payment insert.
				if($change_return > 0){
					$change_update = $this->db
						->where('id', $last_insert_id)
						->update('db_salespayments', array('change_return' => $change_return));
					if(!$change_update){
						return "failed";
					}
				}

				if(!set_customer_tot_advance($customer_id)){
		        	return 'failed';
		        }
				//Set the payment to specified account
				if(!empty($account_id)){
					//ACCOUNT INSERT
					$insert_bit = insert_account_transaction(array(
																'transaction_type'  	=> 'SALES PAYMENT',
																'reference_table_id'  	=> $last_insert_id,
																'debit_account_id'  	=> null,
																'credit_account_id'  	=> $account_id,
																'debit_amt'  			=> 0,
																'credit_amt'  			=> $amount,
																'process'  				=> 'SAVE',
																'note'  				=> $payment_note,
																'transaction_date'  	=> $CUR_DATE,
																'payment_code'  		=> $payment_code,
																'customer_id'  			=> $customer_id,
																'supplier_id'  			=> null,
														));
					if(!$insert_bit){
						return "failed";
					}
				}
				//end


				$tot_received_amt = round($tot_received_amt + $amount, $currency_decimals);
				
			}//if()
		
		}//for end


		if(round($tot_received_amt, $currency_decimals)>$invoice_total_numeric){
			echo "Payble amount should not be exceeds Invoice Amount!!";exit;
		}

		/**
		 * Verifieng previous and current payment total with invoice amount
		*/
		
		$tot_payment = $this->db->select('coalesce(sum(payment),0) as payment')->where('sales_id',$sales_id)->get('db_salespayments')->row()->payment;

		if(round((float)$tot_payment, $currency_decimals)>$invoice_total_numeric){
			echo "Payble amount should not be exceeds Invoice Amount!!\nPlease check previous payments as well.";exit;
		}
		

	
		//UPDATE itemS QUANTITY IN itemS TABLE
		$this->load->model('sales_model');				
		$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id);
		if(!$q6){
			return "failed";
		}

		//Calculate Opening balance before and after invoice
		/*$q7=calculate_ob_of_customer($sales_id,$customer_id);
		if(!$q7){
			return "failed";
		}*/

		if(isset($hidden_invoice_id) && !empty($hidden_invoice_id)){
			$q13=$this->hold_invoice_delete($hidden_invoice_id);
			if(!$q13){
				return "failed";
			}
		}
		
		
		$sms_info='';
		if(isset($send_sms) && $customer_id!=1){
			if(send_sms_using_template($sales_id,1)==true){
				$sms_info = 'SMS Has been Sent!';
			}else{
				$sms_info = 'Failed to Send SMS';
			}
		}

		##############################################START
		//FIND THE PREVIOUSE ITEM LIST ID'S
		$curr_item_ids = $this->db->select("item_id")->from("db_salesitems")->where("sales_id",$sales_id)->get()->result_array();
		$two_array = array_merge($prev_item_ids,$curr_item_ids);

		/*Update items in all warehouses of the item*/
		$q7=update_warehouse_items($two_array);
		if(!$q7){
			return "failed";
		}
		##############################################END

		

		//Dont save if invoice credit limit exceeds
		if(!check_credit_limit_with_invoice($customer_id,$sales_id)){
			return 'failed';
		}

		
		//COMMIT RECORD
		$this->db->trans_commit();
		
		$this->session->set_flashdata('success', 'Success!! Sales Created Successfully!'.$sms_info);
        return "success<<<###>>>$sales_id";


	}

	public function update_items_quantity($item_id){
		//FIND IS IS SERVICE OR NOT
		$service_bit=$this->db->query("select service_bit from db_items where id='$item_id'")->row()->service_bit;
		if($service_bit==1){
			return true;
		}
		
		//UPDATE itemS QUANTITY IN itemS TABLE
		$q7=$this->db->query("select COALESCE(SUM(adjustment_qty),0) as stock_qty from db_stockadjustmentitems where item_id='$item_id'");
		$stock_qty=$q7->row()->stock_qty;

		$q8=$this->db->query("select COALESCE(SUM(purchase_qty),0) as pu_tot_qty from db_purchaseitems where item_id='$item_id' and purchase_status='Received'");
		$pu_tot_qty=$q8->row()->pu_tot_qty;
		
		$q9=$this->db->query("select coalesce(SUM(sales_qty),0) as sl_tot_qty from db_salesitems where item_id='$item_id' and sales_status='Final'");
		$sl_tot_qty=$q9->row()->sl_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as pu_return_tot_qty from db_purchaseitemsreturn where item_id='$item_id' ");/*and purchase_id is null */
		$pu_return_tot_qty=$q6->row()->pu_return_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as sl_return_tot_qty from db_salesitemsreturn where item_id='$item_id' ");/*and sales_id is null */
		$sl_return_tot_qty=$q6->row()->sl_return_tot_qty;

		/*Find Damaged Items Count*/
		$q_dmg=$this->db->query("select COALESCE(SUM(damaged_qty),0) as damaged_tot_qty from db_damageditems where item_id='$item_id'");
		$damaged_tot_qty=$q_dmg->row()->damaged_tot_qty;

		$stock=((($stock_qty+$pu_tot_qty)-$sl_tot_qty)+$sl_return_tot_qty)-$pu_return_tot_qty-$damaged_tot_qty;
		$q7=$this->db->query("update db_items set stock=$stock where id='$item_id'");
		if($q7){
			return true;
		}
		else{
			return false;
		}
	}	
	

	public function edit_pos($sales_id){
		$data=$this->data;
		extract($data);
	     $q2=$this->db->query("select * from db_sales where id='$sales_id'");
	    if($q2->num_rows()>0){
	      $res2=$q2->row();
	      $sales_date=show_date($res2->sales_date);
	      $customer_id=$res2->customer_id;
	      $discount_input=$res2->discount_to_all_input;
	      $discount_type=$res2->discount_to_all_type;
	      $grand_total=$res2->grand_total;
	      $store_id=$res2->store_id;
	      $warehouse_id=$res2->warehouse_id;
	      $sales_note=$res2->sales_note;
	      $invoice_terms=trim($res2->invoice_terms);

	      $q3=$this->db->query("SELECT * FROM db_salesitems WHERE sales_id='$sales_id'");
		  $rows=$q3->num_rows();
		  if($rows>0){
		  	$i=0;
		  	
		  	foreach ($q3->result() as $res3) { 
		  		$q5=$this->db->query("select * from db_items where id=".$res3->item_id);
		  		$price_per_unit = $res3->price_per_unit;
		  		$description = $res3->description;
		  		$service_bit = $q5->row()->service_bit;
		  		$stock=$q5->row()->stock + $res3->sales_qty;

			$item_discount = store_number_format($res3->discount_amt, false);
		  		$item_discount_type = $res3->discount_type;
		  		$item_discount_input = $res3->discount_input;


		  		$q6=$this->db->query("select * from db_tax where id=".$res3->tax_id)->row();

		  		//$item_tax_type = $q5->row()->tax_type;
	        	/*if($item_tax_type=='Exclusive'){
	        		$per_item_price_inc_tax=$price_per_unit+(($price_per_unit*$q5->row()->tax)/100);
				}
				else{//Inclusive	
					$per_item_price_inc_tax=$price_per_unit;
				}*/
				$per_item_price_inc_tax=$price_per_unit;
				$per_item_price_inc_tax=number_format($per_item_price_inc_tax,decimals(),'.','');	

			$tax_amt = store_number_format($res3->tax_amt, false);
				$tax_type = $res3->tax_type;
				$tax_id = $res3->tax_id;
				$tax_value = $q6->tax;

		  		$quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			$quantity       .='<input type="text" inputmode="numeric" maxlength="3" value="'.min(999,max(1,(int)$res3->sales_qty)).'" data-last-valid="'.min(999,max(1,(int)$res3->sales_qty)).'" class="form-control no-padding text-center min_width pos-qty-input" style="font-size:16px;font-weight:bold;" onkeydown="return allow_pos_qty_key(event)" oninput="validate_pos_qty(this)" onchange="item_qty_input('.$res3->item_id.','.$i.')" id="item_qty_'.$i.'" name="item_qty_'.$i.'">';
			    $quantity       .='<span class="input-group-btn"><button onclick="increment_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			    $sub_total       =$res3->total_cost;
			    $remove_btn      ='<img src="'.base_url('uploads/icon02.png').'" class="pos-remove-icon" onclick="removerow('.$i.')" title="Delete Item?" alt="Remove">';
			    
		  		echo '<tr id="row_'.$i.'" data-row="0" data-item-id="'.$res3->item_id.'" >'; /*item id */
		  		echo '<td id="td_'.$i.'_barcode">'.$q5->row()->custom_barcode.'</td>';
		  		echo '<td id="td_'.$i.'_0"><span id="td_data_'.$i.'_0">'.$q5->row()->item_name.'</span></td>';  /*td_0_0 item name*/
		  		echo '<td id="td_'.$i.'_1" class="text-center">'.format_qty($stock).'</td>';  /*td_0_1 item available qty*/
		  		echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';    /*td_0_2 item available qty */

		  		$info = '<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$q5->row()->purchase_price.')" onkeyup="update_price('.$i.','.$q5->row()->purchase_price.')" name="sales_price_'.$i.'" type="text" class="form-control min_width text-center" value="'.$per_item_price_inc_tax.'">';

		  		echo '<td id="td_'.$i.'_3" class="text-right" >'.$info.'</td>';    /*td_0_3 item sales price */

		  		$info = '<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal('.$i.')" id="item_discount_'.$i.'" readonly name="item_discount_'.$i.'" type="text" class="form-control text-center no-padding" value="'.$item_discount.'">';

		  		echo '<td id="td_'.$i.'_6" class="text-right" >'.$info.'</td>';

		  		echo '<td id="td_'.$i.'_11" class="text-center"><input tabindex="-1" id="td_data_'.$i.'_11" name="td_data_'.$i.'_11" type="text" class="form-control no-padding min_width text-center pos-calculated-field" readonly value="'.$tax_amt.'"></td>';
		  		echo '<td id="td_'.$i.'_4" class="text-right" >
		  		<input tabindex="-1" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding min_width text-center pos-calculated-field" readonly value="'.store_number_format($sub_total,false).'"></td>';    /*td_0_4 item sub_total */
		  		echo '<td id="td_'.$i.'_5">'.$remove_btn.'</td>';    /* td_0_5 item gst_amt  */

		  		echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">'; 
		  		echo '<input type="hidden" id="tr_item_per_'.$i.'" name="tr_item_per_'.$i.'" value="'.$q6->tax.'">';
		  		echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_inc_tax.'">';
		  		echo '</tr>';
		  		echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
        		echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
        		echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
        		echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
        		echo '<input type="hidden" id="service_bit_'.$i.'" name="service_bit_'.$i.'" value="'.$service_bit.'">';
		  		echo '<input type="hidden" id="item_discount_type_'.$i.'" name="item_discount_type_'.$i.'" value="'.$item_discount_type.'">';
        		echo '<input type="hidden" id="item_discount_input_'.$i.'" name="item_discount_input_'.$i.'" value="'.$item_discount_input.'">';
		  		$i++;
		  	}//foreach() end

		  	echo "<<<###>>>".$discount_input."<<<###>>>".$discount_type."<<<###>>>".$customer_id."<<<###>>>".$store_id."<<<###>>>".$warehouse_id."<<<###>>>".$sales_note."<<<###>>>".$invoice_terms;

		  }//if ()
		 
	    }
	    else{
	      print "Record Not Available";
	    }
	     
	}//edit_pos()

	
	/* ######################################## HOLD INVOICE ############################# */
	
	public function hold_invoice_list(){
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str ='';
	      $q2=$this->db->query("select * from db_hold where store_id=".get_current_store_id()." order by id desc");
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	     
                  $str =$str."<tr>";
                  $str =$str."<td>".$res2->id."</td>";
                  $str =$str."<td>".show_date($res2->sales_date)."</td>";
                  $str =$str."<td>".$res2->reference_id."</td>";
                  $str =$str."<td>";
                  	$str =$str.'<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete('.$res2->id.')" title="Delete Invoive?"></a>';
                  	$str =$str.'<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_edit('.$res2->id.')" title="Edit Invoive?"></a>';
                  $str =$str."</td>";
                $str =$str."</tr>";
	     
	          $i++;
	          }//for end
	      }//if num_rows() end
	      else{
	      	
	      	$str =$str."<tr>";
	      		$str =$str.'<td colspan="4" class="text-danger text-center">No Records Found</td>';
	      	$str =$str.'</tr>';
	      	
	      }
		return $str;
	}
	public function hold_invoice_delete($id){
		$this->db->trans_begin();
		$q1=$this->db->query("DELETE from db_hold where id='$id' and store_id=".get_current_store_id());
		if(!$q1){
			return "failed";
		}
		//COMMIT RECORD
		$this->db->trans_commit();
        return "success";

	}


	public function hold_invoice_edit(){
		$data=$this->data;
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
	     $q2=$this->db->query("select * from db_hold where id='$hold_id'");
	    if($q2->num_rows()>0){
	      $res2=$q2->row();
	      $sales_date=show_date($res2->sales_date);
	      $customer_id=$res2->customer_id;
	      $discount_input=$res2->discount_to_all_input;
	      $discount_type=$res2->discount_to_all_type;
	      $grand_total=$res2->grand_total;
	      $store_id=$res2->store_id;
	      $warehouse_id=$res2->warehouse_id;
	      $sales_note=$res2->sales_note;

	      $q3=$this->db->query("SELECT * FROM db_holditems WHERE hold_id='$hold_id'");
		  $rows=$q3->num_rows();
		  if($rows>0){
		  	$i=0;
		  	
		  	foreach ($q3->result() as $res3) { 
		  		$q5=$this->db->query("select * from db_items where id=".$res3->item_id);
		  		$price_per_unit = $res3->price_per_unit;
		  		$description = $res3->description;
		  		$service_bit = $q5->row()->service_bit;

		  		$warehouse_stock = total_available_qty_items_of_warehouse($warehouse_id,null,$res3->item_id);
		  		$stock=$warehouse_stock;//$q5->row()->stock + $res3->sales_qty;

			$item_discount = store_number_format($res3->discount_amt, false);
		  		$item_discount_type = $res3->discount_type;
		  		$item_discount_input = $res3->discount_input;


		  		$q6=$this->db->query("select * from db_tax where id=".$res3->tax_id)->row();

		  		
				$per_item_price_inc_tax=$price_per_unit;
				$per_item_price_inc_tax=number_format($per_item_price_inc_tax,decimals(),'.','');	

			$tax_amt = store_number_format($res3->tax_amt, false);
				$tax_type = $res3->tax_type;
				$tax_id = $res3->tax_id;
				$tax_value = $q6->tax;

		  		$quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			    $quantity       .='<input type="text" inputmode="numeric" maxlength="3" value="'.min(999,max(1,(int)$res3->sales_qty)).'" data-last-valid="'.min(999,max(1,(int)$res3->sales_qty)).'" class="form-control min_width text-center pos-qty-input" onkeydown="return allow_pos_qty_key(event)" oninput="validate_pos_qty(this)" onchange="item_qty_input('.$res3->item_id.','.$i.')" id="item_qty_'.$i.'" name="item_qty_'.$i.'">';
			    $quantity       .='<span class="input-group-btn"><button onclick="increment_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			    $sub_total       =$res3->total_cost;
			    $remove_btn      ='<img src="'.base_url('uploads/icon02.png').'" class="pos-remove-icon" onclick="removerow('.$i.')" title="Delete Item?" alt="Remove">';
			    
		  		echo '<tr id="row_'.$i.'" data-row="0" data-item-id="'.$res3->item_id.'" >'; /*item id */
		  		echo '<td id="td_'.$i.'_barcode">'.$q5->row()->custom_barcode.'</td>';
		  		echo '<td id="td_'.$i.'_0">
		  		<a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'.$i.'_0" onclick="show_sales_item_modal('.$i.')">'.$q5->row()->item_name.'</a>
		  		</td>';  /*td_0_0 item name*/
		  		echo '<td id="td_'.$i.'_1">'.format_qty($stock).'</td>';  /*td_0_1 item available qty*/
		  		echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';    /*td_0_2 item available qty */

		  		$info = '<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$q5->row()->purchase_price.')" onkeyup="update_price('.$i.','.$q5->row()->purchase_price.')" name="sales_price_'.$i.'" type="text" class="form-control min_width" value="'.$per_item_price_inc_tax.'">';

		  		echo '<td id="td_'.$i.'_3" class="text-right" >'.$info.'</td>';    /*td_0_3 item sales price */

		  		$info = '<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal('.$i.')" id="item_discount_'.$i.'" readonly name="item_discount_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$item_discount.'">';

		  		echo '<td id="td_'.$i.'_6" class="text-right" >'.$info.'</td>';

		  		echo '<td id="td_'.$i.'_11"><input tabindex="-1" id="td_data_'.$i.'_11" name="td_data_'.$i.'_11" type="text" class="form-control no-padding min_width text-center pos-calculated-field" readonly value="'.$tax_amt.'"></td>';
		  		echo '<td id="td_'.$i.'_4" class="text-right" >
		  		<input tabindex="-1" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding min_width text-center pos-calculated-field" readonly value="'.store_number_format($sub_total,false).'"></td>';    /*td_0_4 item sub_total */
		  		echo '<td id="td_'.$i.'_5">'.$remove_btn.'</td>';    /* td_0_5 item gst_amt  */

		  		echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">'; 
		  		echo '<input type="hidden" id="tr_item_per_'.$i.'" name="tr_item_per_'.$i.'" value="'.$q6->tax.'">';
		  		echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_inc_tax.'">';
		  		echo '</tr>';
		  		echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
        		echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
        		echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
        		echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
        		echo '<input type="hidden" id="service_bit_'.$i.'" name="service_bit_'.$i.'" value="'.$service_bit.'">';
		  		echo '<input type="hidden" id="item_discount_type_'.$i.'" name="item_discount_type_'.$i.'" value="'.$item_discount_type.'">';
        		echo '<input type="hidden" id="item_discount_input_'.$i.'" name="item_discount_input_'.$i.'" value="'.$item_discount_input.'">';
		  		$i++;
		  	}//foreach() end

		  	echo "<<<###>>>".$discount_input."<<<###>>>".$discount_type."<<<###>>>".$customer_id."<<<###>>>".$store_id."<<<###>>>".$warehouse_id."<<<###>>>".$sales_note."<<<###>>>".$hold_id;

		  }//if ()
		 
	    }
	    else{
	      print "Record Not Available";
	    }
	     
	}//edit_pos()


	public function hold_list_save_update(){//Save or update sales
		$this->db->trans_begin();
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();

		$store_id= get_current_store_id();
		$rowcount 			=$hidden_rowcount;
		$sales_date 		=date("Y-m-d",strtotime($CUR_DATE));
		//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
		$discount_input 	= (empty($discount_input)) ? 'NULL' : $discount_input;
		$tot_disc 		= (empty($tot_disc) || $tot_disc==0) ? 'NULL' : $tot_disc;
		$raw_total = (float) string_to_number($tot_amt)
			- (float) string_to_number($tot_disc)
			- (float) string_to_number($coupon_discount_amt);
		if(is_enabled_round_off()){
			$tot_grand = number_format(round($raw_total), decimals(), '.', '');
			$round_off = number_format((float)$tot_grand - $raw_total, decimals(), '.', '');
		}
		else{
			$tot_grand = number_format($raw_total, decimals(), '.', '');
			$round_off = null;
		}
		

		$prev_item_ids = array();


		$tot = $this->db->select("count(*) as tot")->where("store_id",$store_id)->where("reference_id",$reference_id)->get("db_hold")->row()->tot;
		if($tot>0){
			$q11=$this->db->query("delete from db_hold where reference_id='$reference_id' and store_id=".$store_id);
			if(!$q11){
				return "failed";
			}
		}
		

		$sales_entry = array(
						'reference_id' 				=> $reference_id,
	    				'store_id' 					=> $store_id,
	    				'sales_date' 				=> $sales_date,
	    				'sales_status' 				=> 'Final',
	    				'customer_id' 				=> $customer_id,
	    				/*Discount*/
	    				'discount_to_all_input' 	=> $discount_input,
	    				'discount_to_all_type' 		=> $discount_type,
	    				'tot_discount_to_all_amt' 	=> $tot_disc,
	    				/*Subtotal & Total */
	    				'subtotal' 					=> $tot_amt,
	    				'round_off' 				=> $round_off,
	    				'grand_total' 				=> $tot_grand,
	    				'pos' 						=> 1,
	    				'sales_note' 				=> $sales_note,
	    			);
		$sales_entry['warehouse_id']=(warehouse_module() && warehouse_count()>1) ? $warehouse_id : get_store_warehouse_id();
		$q3 = $this->db->insert('db_hold', $sales_entry);
		$hold_id = $this->db->insert_id();
		
		//Import post data from form
		for($i=0;$i<$rowcount;$i++){
		
			if(isset($_REQUEST['tr_item_id_'.$i]) && trim($_REQUEST['tr_item_id_'.$i])!=''){
			
				//RECEIVE VALUES FROM FORM
				$item_id 	=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$sales_qty 	=$this->xss_html_filter(trim($_REQUEST['item_qty_'.$i]));
				if (!ctype_digit((string) $sales_qty) || (int) $sales_qty < 1 || (int) $sales_qty > 999) {
					$this->db->trans_rollback();
					return "Quantity must be a whole number between 1 and 999.";
				}
				$price_per_unit =$this->xss_html_filter(trim($_REQUEST['sales_price_'.$i]));
				$tax_amt =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
				$tax_type =$this->xss_html_filter(trim($_REQUEST['tr_tax_type_'.$i]));
				$tax_id =$this->xss_html_filter(trim($_REQUEST['tr_tax_id_'.$i]));
				$tax_value =$this->xss_html_filter(trim($_REQUEST['tr_tax_value_'.$i]));//%
				$total_cost =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
				$description =$this->xss_html_filter(trim($_REQUEST['description_'.$i]));
				
				$discount_type =$this->xss_html_filter(trim($_REQUEST['item_discount_type_'.$i]));
				$discount_input =$this->xss_html_filter(trim($_REQUEST['item_discount_input_'.$i]));
				$discount_amt =$this->xss_html_filter(trim($_REQUEST['item_discount_'.$i]));

				if($tax_type=='Exclusive'){
					$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
				}
				else{//Inclusive
					$single_unit_total_cost =$price_per_unit;
				}

				
				if($tax_id=='' || $tax_id==0){$tax_id=null;}
				if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
				if($total_cost=='' || $total_cost==0){$total_cost=null;}
				
				
				/* ******************************** */
				//Find the qty available or not
				$item_details = get_item_details($item_id);
				$item_name = $item_details->item_name;
				$service_bit = $item_details->service_bit;
				/* Negative stock sales are allowed.
				$current_stock_of_item = total_available_qty_items_of_warehouse($warehouse_id,null,$item_id);
				if($current_stock_of_item<$sales_qty && $service_bit==0){
					return $item_name." has only ".$current_stock_of_item." in Stock!!";exit;
				}
				*/
				
				$salesitems_entry = array(
							'store_id' 			=> $store_id,
		    				'hold_id' 			=> $hold_id, 
		    				'item_id' 			=> $item_id, 
		    				'description' 		=> $description, 
		    				'sales_qty' 		=> $sales_qty,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'tax_type' 			=> $tax_type,
		    				'discount_type' 	=> $discount_type,
		    				'discount_input' 	=> $discount_input,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $total_cost,
		    			);
				$q4 = $this->db->insert('db_holditems', $salesitems_entry);

				$q11=$this->update_items_quantity($item_id);
				if(!$q11){
					return "failed";
				}

			}
		
		}//for end
		

		//COMMIT RECORD
		$this->db->trans_commit();
		
		$this->session->set_flashdata('success', 'Success!! Sales Created Successfully!');
        return "success";


	}
}
