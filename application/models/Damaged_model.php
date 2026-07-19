<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Damaged_model extends CI_Model {
	var $table = 'db_damaged as a';
	var $column_order = array( 
								'a.id',
								'a.damaged_date',
								'a.reference_no',
								'a.created_by',
								'a.store_id'
								);
	var $column_search = array( 
								'a.id',
								'a.damaged_date',
								'a.reference_no',
								'a.created_by',
								'a.store_id'
								);
	var $order = array('a.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		
		$warehouse_id = $this->input->post('warehouse_id');
		if(!empty($warehouse_id)){
			$this->db->join('db_warehouse as w','w.id='.$warehouse_id,'left');
			$this->db->where('a.warehouse_id',$warehouse_id);
		}

		$this->db->where("a.store_id",get_current_store_id());
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
		$this->db->where("store_id",get_current_store_id());
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}

	public function verify_save_and_update(){
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		
		$this->db->trans_begin();
		$damaged_date=system_fromatted_date($damaged_date);

	    $prev_item_ids = array();
	    
	    $store_id = (store_module() && is_admin()) ? $store_id : get_current_store_id();  
	    $warehouse_id=(warehouse_module() && warehouse_count()>1) ? $warehouse_id : get_store_warehouse_id(); 	
	    
	    if($command=='save'){
			$this->db->query("ALTER TABLE db_damaged AUTO_INCREMENT = 1");
			
		    $damaged_entry = array(
		    				'store_id' 				=> $store_id, 
		    				'warehouse_id' 				=> $warehouse_id, 
		    				'reference_no' 				=> $reference_no, 
		    				'damaged_date' 			=> $damaged_date,
		    				'damaged_note' 			=> $damaged_note,
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $CUR_USERNAME,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'status' 					=> 1,
		    			);
		    
			$q1 = $this->db->insert('db_damaged', $damaged_entry);
			$damaged_id = $this->db->insert_id();
		}
		else if($command=='update'){	
			$damaged_entry = array(
		    				'store_id' 				=> $store_id, 
		    				'warehouse_id' 				=> $warehouse_id, 
		    				'reference_no' 				=> $reference_no, 
		    				'damaged_date' 			=> $damaged_date,
		    				'damaged_note' 			=> $damaged_note,
		    			);
			
			$q1 = $this->db->where('id',$damaged_id)->update('db_damaged', $damaged_entry);

			$prev_item_ids = $this->db->select("item_id")->from("db_damageditems")->where("damaged_id",$damaged_id)->get()->result_array();

			$q11=$this->db->query("delete from db_damageditems where damaged_id='$damaged_id'");
			if(!$q11){
				return "failed";
			}
		}

		for($i=1;$i<=$rowcount;$i++){
			if(isset($_REQUEST['tr_item_id_'.$i]) && !empty($_REQUEST['tr_item_id_'.$i])){

				$item_id 			=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$damaged_qty		=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_3']));
				$description		=$this->xss_html_filter(trim($_REQUEST['description_'.$i]));

				$damaged_item_entry = array(
							'store_id' 				=> $store_id, 
		    				'warehouse_id' 				=> $warehouse_id, 
		    				'damaged_id' 		=> $damaged_id,
		    				'item_id' 			=> $item_id,
		    				'damaged_qty' 		=> $damaged_qty,
		    				'description' 		=> $description, 
		    				'status'			=> 1,
		    			);
				
				$q2 = $this->db->insert('db_damageditems', $damaged_item_entry);
				
				$this->load->model('pos_model');				
				$q6=$this->pos_model->update_items_quantity($item_id);
				if(!$q6){
					return "failed";
				}
			}
		}

		$curr_item_ids = $this->db->select("item_id")->from("db_damageditems")->where("damaged_id",$damaged_id)->get()->result_array();
		
		$two_array = array_merge($prev_item_ids,$curr_item_ids);

		$q7=update_warehouse_items($two_array);
		if(!$q7){
			return "failed";
		}
		
		$this->db->trans_commit();
		$this->session->set_flashdata('success', 'Success!! Record Saved Successfully!');
		return "success<<<###>>>$damaged_id";
	}

	public function delete_damaged($ids){
      	$this->db->trans_begin();

		$prev_item_ids = $this->db->select("item_id")->from("db_damageditems")->where("damaged_id in ($ids)")->get()->result_array();

		$this->db->where("id in ($ids)");
		if(!is_admin()){
			$this->db->where("store_id",get_current_store_id());
		}
		$q3=$this->db->delete("db_damaged");

		$this->db->where("damaged_id in ($ids)");
		if(!is_admin()){
			$this->db->where("store_id",get_current_store_id());
		}
		$q7=$this->db->delete("db_damageditems");

		$q6=$this->db->query("select id from db_items");
		if($q6->num_rows()>0){
			$this->load->model('pos_model');				
			foreach ($q6->result() as $res6) {
				$q6=$this->pos_model->update_items_quantity($res6->id);
				if(!$q6){
					return "failed";
				}
			}
		}

		$q7=update_warehouse_items($prev_item_ids);
		if(!$q7){
			return "failed";
		}
		
		if($q3!=1)
		{
			$this->db->trans_rollback();
		    return "failed";
		}
		else{
			$this->db->trans_commit();
		    return "success";
		}
	}
	
	public function get_items_info($rowcount,$item_id){
		$res1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get()->row();
		
		$info = array(
							'item_id' 					=> $res1->id, 
							'description' 				=> $res1->description, 
							'item_name' 				=> $res1->item_name,
							'item_damaged_qty' 		=> 1, 
							'service_bit' 				=> $res1->service_bit, 
						);

		echo $this->return_row_with_data($rowcount,$info);
	}

	public function return_damaged_list($damaged_id){
		$q1=$this->db->select('*')->from('db_damageditems')->where("damaged_id=$damaged_id")->get();
		$rowcount =1;
		$result = '';
		foreach ($q1->result() as $res1) {
			$res2=$this->db->query("select * from db_items where id=".$res1->item_id)->row();
			
			$info = array(
							'item_id' 					=> $res1->item_id, 
							'description' 				=> $res1->description, 
							'item_name' 				=> $res2->item_name,
							'item_damaged_qty' 			=> $res1->damaged_qty, 
							'service_bit' 				=> $res2->service_bit, 
						);

			$result .= $this->return_row_with_data($rowcount++,$info);
		}
		return $result;
	}

	public function return_row_with_data($rowcount,$info){
		extract($info);
		ob_start();
		?>
            <tr id="row_<?=$rowcount;?>" data-row='<?=$rowcount;?>'>
               <td id="td_<?=$rowcount;?>_1">
                  <label class='form-control' style='height:auto;' data-toggle="tooltip" title='Edit ?' >
                  <a id="td_data_<?=$rowcount;?>_1" href="javascript:void(0)" onclick="show_purchase_item_modal(<?=$rowcount;?>)" title=""><?=$item_name;?></a> 
                  		<i onclick="show_purchase_item_modal(<?=$rowcount;?>)" class="fa fa-edit pointer"></i>
                  	</label>
               </td>
               <td id="td_<?=$rowcount;?>_3">
                  <div class="input-group ">
                     <span class="input-group-btn">
                     <button onclick="decrement_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>
                     <input type="text" value="<?=format_qty($item_damaged_qty);?>" class="form-control no-padding text-center" onkeyup="final_total()" id="td_data_<?=$rowcount;?>_3" name="td_data_<?=$rowcount;?>_3">
                     <span class="input-group-btn">
                     <button onclick="increment_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span>
                  </div>
               </td>
               <td id="td_<?=$rowcount;?>_16" style="text-align: center;">
                  <a class=" fa fa-fw fa-minus-square text-red" style="cursor: pointer;font-size: 34px;" onclick="removerow(<?=$rowcount;?>)" title="Delete ?" name="td_data_<?=$rowcount;?>_16" id="td_data_<?=$rowcount;?>_16"></a>
               </td>
               <input type="hidden" id="tr_item_id_<?=$rowcount;?>" name="tr_item_id_<?=$rowcount;?>" value="<?=$item_id;?>">
               <input type="hidden" id="description_<?=$rowcount;?>" name="description_<?=$rowcount;?>" value="<?=$description;?>">
               <input type="hidden" id="service_bit_<?=$rowcount;?>" name="service_bit_<?=$rowcount;?>" value="<?=$service_bit;?>">
            </tr>
		<?php
		return ob_get_clean();
	}
}
